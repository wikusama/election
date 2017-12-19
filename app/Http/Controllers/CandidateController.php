<?php

namespace App\Http\Controllers;

use DB;
use File;
use Auth;
use Image;
use SammyK;
use Storage;
use Validator;
use App\Models\Member;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    protected $fb;
    
    public function __construct(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $facebook)
    {
        $this->fb = $facebook;
    }

    public function index()
    {
        $candidates = Candidate::all();
        return view('pages.candidates.index', compact('candidates'));
    }
    
    public function add()
    {
        return view('pages.candidates.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_name' => 'required',
            'lead_about' => 'required',
            'deputy_name' => 'required',
            'deputy_about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
            'lead_pic' => 'required|mimes:jpeg,jpg',
            'deputy_pic' => 'required|mimes:jpeg,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $candidate = new Candidate;
        $candidate->lead_name = $request->lead_name;
        $candidate->lead_about = $request->lead_about;
        $candidate->deputy_name = $request->deputy_name;
        $candidate->deputy_about = $request->deputy_about;
        $candidate->vision = $request->vision;
        $candidate->mission = $request->mission;

        // generating pic lead
        if($request->hasFile('lead_pic')) {
            $lead_pic = $this->getImageString($request->file('lead_pic'));
            $candidate->lead_pic = $lead_pic;
        }

        // generating pic deputy
        if($request->hasFile('deputy_pic')) {
            $deputy_pic = $this->getImageString($request->file('deputy_pic'));
            $candidate->deputy_pic = $deputy_pic;
        }

        $candidate->save();

        return redirect()->route('candidates');

    }

    public function getImageString($file){
        $image = $file;
        $imageType = $image->getClientOriginalExtension();
        $imageStr = (string) Image::make( $image )
            ->resize( 300, null, function ( $constraint ) {
                $constraint->aspectRatio();
            })->encode( $imageType );
            
        $imageStr = base64_encode($imageStr);
        $data = "data:image/{$imageType};base64,{$imageStr}";
        
        return $data;
    }

    public function delete(Request $request, $id)
    {
        Member::where('voted_at', $id)->update(['voted_at' => 0]);
        
        Candidate::where('id', $id)->delete();

        echo json_encode([
            'success' => true
        ]);
    }
}
