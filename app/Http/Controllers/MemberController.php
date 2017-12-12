<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use SammyK;
use App\Models\Admin;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected $fb;
    
    public function __construct(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $facebook)
    {
        $this->fb = $facebook;
    }

    public function index()
    {
        $members = DB::table('members')->paginate(50);
        $starting_at = ($members->currentPage() - 1) * $members->count();
        return view('pages.groups.member', compact('members', 'starting_at'));
    }
    
    public function admin()
    {
        $admins = Admin::all();
        return view('pages.groups.admin', compact('admins'));
    }
}
