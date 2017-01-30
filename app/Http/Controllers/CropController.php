<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
// use Input;

class CropController extends Controller
{
    public function image()
    {
        return view('index');
    }

    public function postImage(Request $request)
    {
        // resize real image but keep ratio
        $orig_w = 600;
        $realPath = public_path().'/'.'uploads/images/';

        if($request->hasFile('image')) {

            $filename = date("ymd").str_random(6).'.'.$request->file('image')->getClientOriginalExtension();

            list($width, $height) = getimagesize($request->file('image')->getPathName());

            $orig_h = ($height/$width) * $orig_w;

            Image::make($request->file('image'))
                // ->resize($request->input('img-width'), $request->input('img-height'))
                // ->crop($request->input('width'), $request->input('height'), $request->input('x'), $request->input('y'))
                ->resize($orig_w, $orig_h)
                ->save($realPath.$filename, 100);
        }

        return view('crop')->with([
                'filename' => $filename,
                'height' => $orig_h
            ]);
    }

    public function postCrop(Request $request)
    {
        // dd($request->all());
        $thumbw = 120;
        $thumbh = 100;
        $targetPath = public_path().'/'.'uploads/crops/';
        $realPath = public_path().'/'.'uploads/images/';

        $filename = 'thumb_'.$request->filename;
        Image::make($realPath.$request->filename)
            // ->resize($request->w, $request->h)
            ->crop((int)$request->w, (int)$request->h, (int)$request->x, (int)$request->y)
            ->resize($thumbw, $thumbh)
            ->save($targetPath.$filename, 100);

        return back()->with([
                'thumb' => $filename
            ]);
    }
}
