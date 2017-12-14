<?php

namespace App\Http\Controllers;

use DB;
use File;
use Auth;
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
        $lead_pic = 'lead_'.md5($request->file('lead_pic')->getClientOriginalName()).'.'.($request->file('lead_pic')->getClientOriginalExtension());
        Storage::disk('public')->put($lead_pic, file_get_contents($request->file('lead_pic')));
        
        // generating pic deputy
        $deputy_pic = 'deputy_'.md5($request->file('deputy_pic')->getClientOriginalName()).'.'.($request->file('deputy_pic')->getClientOriginalExtension());
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

    public function delete(Request $request, $id)
    {
        Member::where('voted_at', $id)->update(['voted_at' => 0]);
        
        $candidate = Candidate::where('id', $id)->first();
        Storage::disk('public')->delete([$candidate->lead_pic, $candidate->deputy_pic]);
        $candidate->delete();

        echo json_encode([
            'success' => true
        ]);
    }
}
