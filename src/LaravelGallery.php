<?php

namespace Rabbi\LaravelGallery;
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class LaravelGallery extends Eloquent{
    /**
     * The table used by this model
     *
     * @var string
     **/
    protected $table = 'media';



    public static function storeImage($files){
            foreach ($files as $file) {
                $image = self::imageUpload($file);
                $data[] =  [
                    'url' => $image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

        self::insert($data);
    }

    public static function deleteImage($ids, $type=null){
        if($type =='all'){
            LaravelGallery::query()->delete();
        }else{
            $media = LaravelGallery::whereIn('id', $ids);
            if ($media->exists()) {
                foreach ($media->get() as $image) {
                    deleteFile($image->url);
                }
            }
            $media->delete();
        }
    }

    public static function getImages($search_query, $status, $paginate=15){
        $media = self::select('id', 'url', 'created_at', 'status')
            ->where('url', 'like', '%' . $search_query . '%')
            ->when(!request()->has('search_query'), function ($query) use ($status) {
                $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate($paginate);

        $media->appends(['search_query' => $search_query, 'status' => $status]);
        return $media;
    }

    private static function imageUpload($photo, $existingPhoto = '', $prefix = '', $directory = '')
    {
        $directoryName = "uploads/";
        if ($photo->isValid()) {
            $photo_name = time() . hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            if ($directory) {
                $directoryName = $directory;
            }
            $photo_path = $directoryName . $photo_name;

            deleteFile($existingPhoto);
            //Upload new photo
            $img = Image::make($photo->getRealPath())->stream('png', 90);
            $path = Storage::disk('public')->put($photo_path, $img);

            return $photo_path;
        }
    }
}