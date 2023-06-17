<?php

namespace Rabbi\LaravelGallery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Rabbi\LaravelGallery\LaravelGallery;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Storage;

class LaravelGalleryController extends Controller
{
    public function index(Request $request)
    {
        $search_query = $request->search_query;
        $status = 'active';
        $paginateItems = 20;
        $media = LaravelGallery::getImages($search_query, $status, $paginateItems);
        if ($request->ajax()) {
            // if($request->type == 'modal'){
            //     return view('admin.layouts.components.media-ajax-data', compact('media'));
            // }
            return view('laravel-gallery::item', compact('media'));
        }
        // return view('admin.media.index', compact('media'));
        return view('laravel-gallery::index', compact('media'));
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'images' => 'required|array',
            'images.*' => 'file|max:2000|mimes:jpeg,jpg,png'
        );

        $messages = [
            'images.*.max' => 'File Size Cannot be more than 2000kb',
            'images.*.mimes' => 'File format supported: jpeg,jpg,png',
        ];

        $validator = FacadesValidator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->errors()->first();
            return Redirect::back()->with('danger', $messages);
        }

        if ($request->hasFile('images')) LaravelGallery::storeImage($request->file('images'));

        return response()->json([
            'msg' => 'Media Successfully Updated!',
            'refresh' => 'media-container'
        ]);
        // return redirect()->back()->with('success', 'Successfully Updated!');
    }

    public function tailwind()
    {
        return view('laravel-gallery::tl');
    }

    public function downloadImage(Request $request){
        return Storage::disk(config('gallery.storage'))->download($request->url); 
    }


    public function destroy(Request $request)
    {
        try {
            LaravelGallery::deleteImage($request->image_ids, $request->type);
            $status = "success";
            $message = "Media files successfully deleted";
        } catch (\Illuminate\Database\QueryException $ex) {
            $status = "danger";
            $message = $ex->getMessage();
        }
        return redirect()->back()->with($status, $message);
    }
}
