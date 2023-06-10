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
        $media = LaravelGallery::select('id', 'url', 'created_at', 'status')
            ->where('url', 'like', '%' . $search_query . '%')
            ->when(!request()->has('search_query'), function ($query) use ($status) {
                $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate(15);

        $media->appends(['search_query' => $search_query, 'status' => $status]);

        // if ($request->ajax()) {
        //     if($request->type == 'modal'){
        //         return view('admin.layouts.components.media-ajax-data', compact('media'));
        //     }
        //     return view('admin.media.ajax', compact('media'));
        // }
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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = imageUpload($file);
                $data[] =  [
                    'url' => $image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        LaravelGallery::insert($data);

        return redirect()->back()->with('success', 'Successfully Updated!');
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
        $ids = $request->image_ids;
        try {
            $media = LaravelGallery::whereIn('id', $ids);
            if ($media->exists()) {
                foreach ($media->get() as $image) {
                    deleteFile($image->url);
                }
            }
            $media->delete();
            $status = "success";
            $message = "Media files successfully deleted";
        } catch (\Illuminate\Database\QueryException $ex) {
            $status = "danger";
            $message = $ex->getMessage();
        }
        return redirect()->back()->with($status, $message);
    }
}
