<?php

namespace App\Http\Controllers;

use Auth;
use SammyK;
use Session;
use App\Models\User;
use App\Models\Admin;
use App\Models\Graph;
use App\Models\Member;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    protected $fb;

    public function __construct(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $facebook)
    {
        $this->fb = $facebook;
    }

    public function callback() {
        // Obtain an access token.
        try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    
        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (! $token) {
            // Get the redirect helper
            $helper = $this->fb->getRedirectLoginHelper();
    
            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }
    
            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }
    
        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->fb->getOAuth2Client();
    
            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }
    
        $this->fb->setDefaultAccessToken($token);
    
        // Save for later
        Session::put('fb_user_access_token', (string) $token);
    
        // Get basic info on the user from Facebook.
        try {
            $response = $this->fb->get('/me?fields=id,name,email,link');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    
        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();
    
        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $user = User::createOrUpdateGraphNode($facebook_user);
    
        // Log the user into Laravel
        Auth::login($user);

        $group_id = $this->myGroupId();

        $user->save();
        
        // set group id for users
        $user_for_group = User::where('id', Auth::user()->id)->first();
        $user_for_group->group_id = $group_id;
        $user_for_group->save();

        $this->groupAdmins();

        $this->groupStats();
    
        return redirect('/')->with('message', 'Successfully logged in with Facebook');
    }

    function myGroupId()
    {
        $this->fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
        try {
            $response = $this->fb->get('/me?fields=groups');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    
        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $fb_group = $response->getGraphUser();

        return $fb_group['id'];

    }

    protected function groupAdmins()
    {
        $this->fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
        try {
            $response = $this->fb->get('/'.env('FACEBOOK_GROUP_ID').'/admins/');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    
        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $group_admin = $response->getGraphEdge();

        foreach ($group_admin as $key => $value) {
            Admin::createOrUpdateGraphNode($value);
        }

    }
    
    protected function groupStats()
    {
        $this->fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
        try {
            $response = $this->fb->get('/'.env('FACEBOOK_GROUP_ID').'?fields=members.limit(0).summary(true)');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        $groups = $response->getGraphUser();
        $stats = $groups['members']->getMetaData();

        $total_count = Graph::where('const', 'group.summary.total_count')->first();
        if(!$total_count){
            Graph::create(['const' => 'group.summary.total_count', 'val' => $stats['summary']['total_count']]);
        } else {
            $total_count->val = $stats['summary']['total_count'];
            $total_count->save();
        }

    }
    
    protected function groupMembers()
    {
        $this->fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
        $getAfter = Graph::where('const', 'meta.paging.cursors.after')->first();
        try {
            $getAfter = Graph::where('const', 'meta.paging.cursors.after')->first();
            if(!$getAfter)
                $response = $this->fb->get('/'.env('FACEBOOK_GROUP_ID').'/members');
            else
                $response = $this->fb->get('/'.env('FACEBOOK_GROUP_ID').'/members?after='.$getAfter->val);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        $group_members = $response->getGraphEdge();

        $pageCount = 0;
        $maxPages = 5; // stepping forward

        do {
            // storing meta paging to database     
            $cursors = $group_members->getMetaData()['paging']['cursors'];       
            $before = Graph::where('const', 'meta.paging.cursors.before')->first();
            if(!$before){
                Graph::create(['const' => 'meta.paging.cursors.before', 'val' => $cursors['before']]);
            } else {
                $before->val = $cursors['before'];
                $before->save();
            }
            $after = Graph::where('const', 'meta.paging.cursors.after')->first();
            if(!$after){
                Graph::create(['const' => 'meta.paging.cursors.after', 'val' => $cursors['after']]);
            } else {
                $after->val = $cursors['after'];
                $after->save();
            }

            // storing member to database
            foreach ($group_members as $member) {
                Member::createOrUpdateGraphNode($member);
            }
            
            $pageCount++;
        } while ($pageCount < $maxPages && $group_members = $this->fb->next($group_members));

        $total_count = Graph::where('const', 'group.summary.total_count')->first();

        echo json_encode([
            'success' => true, 
            'pages' => $pageCount,
            'loadedMember' =>  Member::count(),
            'memberQty' => $total_count->val
        ]);

    }

    public function login() {
        // Send an array of permissions to request
        $login_url = $this->fb->getLoginUrl(['email']);
    
        // Obviously you'd do this in blade :)
        echo '<a href="' . $login_url . '">Login with Facebook</a>';
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
