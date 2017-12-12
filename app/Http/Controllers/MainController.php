<?php

namespace App\Http\Controllers;

use Auth;
use SammyK;
use App\Models\Candidate;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $fb;
    
    public function __construct(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $facebook)
    {
        $this->fb = $facebook;
    }

    public function index()
    {
        $candidates = Candidate::all();
        $login_url = $this->fb->getLoginUrl(['email']);
        return view('pages.stages.voting', compact('login_url', 'candidates'));
    }
}
