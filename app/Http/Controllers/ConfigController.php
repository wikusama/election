<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use SammyK;
use App\Models\Graph;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    protected $fb;
    
    public function __construct(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $facebook)
    {
        $this->fb = $facebook;
    }

    public function header()
    {
        $background = Graph::where('const', 'config.header');
        return view('pages.configs.header', compact('background'));
    }
    
    public function headerStore(Request $request)
    {
        // dd($request->all());
        if($request->hasFile('config_header')) {
            $image = $request->file( 'config_header' );
            $imageType = $image->getClientOriginalExtension();
            $imageStr = (string) Image::make( $image )
                ->resize( 300, null, function ( $constraint ) {
                    $constraint->aspectRatio();
                })->encode( $imageType );
                
            $imageStr = base64_encode($imageStr);
            $data = "data:image/{$imageType};base64,{$imageStr}";
            
            $graph_header = Graph::where('const', 'config.header')->first();
            if(!$graph_header){
                Graph::create(['const' => 'config.header', 'val' => $data]);
            } else {
                $graph_header->val = $data;
                $graph_header->save();
            }

            return redirect()->back();

        }
    }
}
