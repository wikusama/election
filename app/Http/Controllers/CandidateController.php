<?php

namespace App\Http\Controllers;

use DB;
use File;
use Auth;
use SammyK;
use Storage;
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
        $candidate = new Candidate;
        $candidate->lead_name = $request->lead_name;
        $candidate->lead_about = $request->lead_about;
        $candidate->deputy_name = $request->deputy_name;
        $candidate->deputy_about = $request->deputy_about;
        $candidate->vision = $request->vision;
        $candidate->mission = $request->mission;

        // generating pic lead
        $lead_pic = 'wikusama_election_'.date('Y_m_d_H_i_s').'_lead_'.md5($request->file('lead_pic')->getClientOriginalName()).'.'.($request->file('lead_pic')->getClientOriginalExtension());
        Storage::disk('public')->put($lead_pic, file_get_contents($request->file('lead_pic')));
        
        // generating pic deputy
        $deputy_pic = 'wikusama_election_'.date('Y_m_d_H_i_s').'_deputy_'.md5($request->file('deputy_pic')->getClientOriginalName()).'.'.($request->file('deputy_pic')->getClientOriginalExtension());
        Storage::disk('public')->put($deputy_pic, file_get_contents($request->file('deputy_pic')));


        $candidate->lead_pic = $lead_pic;
        $candidate->deputy_pic = $deputy_pic;

        $candidate->save();

        return redirect()->route('candidates');

    }

    public function picture($filename)
    {
        $path = storage_path('public/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }
}
