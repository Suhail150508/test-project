<?php

namespace App\Helpers;
use File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public static function Image(array $image_parameters = null) {
        $image = $image_parameters['image'];

        if (Str::length($image) > 500) {
            $directory = 'uploads/images/'.$image_parameters['directory'];
            $width = @$image_parameters['width'] ?? '100%';
            $height = @$image_parameters['height'] ?? '100%';

            $filename = Str::random(10).'_'.uniqid().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $path = $directory.'/'.$filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            file_put_contents($path, $image_base64);

            // $img = Image::make($image);
            // $img->resize($width, $height, function ($constraint) {
            // })->save($path);

            return $path;
        }else {
            $directory = 'uploads/images/' . $image_parameters['directory'];
            $width = @$image_parameters['width'] ?? '100%';
            $height = @$image_parameters['height'] ?? '100%';

            $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME).'_'.rand(1000000,9999999);
            $extension = $image->extension();
            $name = $filename.'.'.$extension;
            $path = $directory.'/'.$name;
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }
            $img = Image::make($image->path());
            $img->resize($width, $height, function ($constraint) {
            })->save($path);

            return $path;
        }
    }

    // public static function Image(array $image_parameters = null) {
    //     $image = $image_parameters['image'];
    //     $directory = 'uploads/images/'.$image_parameters['directory'];
    //     $width = @$image_parameters['width'] ?? '100%';
    //     $height = @$image_parameters['height'] ?? '100%';

    //     $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME).'_'.rand(1000000,9999999);
    //     $extension = $image->extension();
    //     $name = $filename.'.'.$extension;
    //     $path = $directory.'/'.$name;
    //     if (!File::exists($directory)) {
    //         File::makeDirectory($directory, 0775, true, true);
    //     }
    //     $img = Image::make($image->path());
    //     $img->resize($width, $height, function ($constraint) {
    //     })->save($path);
    //     return $path;
    // }


    public static function Attachment(array $file_parameters = null) {
        $file = $file_parameters['file'];

        if (Str::length($file) > 500) {
            $directory = $file_parameters['directory'];
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];

            $file_parts = explode(";base64,", $file);
            $file_base64 = $file_parts[1];

            $path = 'uploads/attachment/'.$directory.'/'. $filename;
            \Storage::disk('custom')->put($path, base64_decode($file_base64));

            return $path;
        } else {
            $directory = $file_parameters['directory'];
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'_'.rand(1000000,9999999);
            $extension = $file->getClientOriginalExtension();
            $name = $filename.'.'.$extension;
            \Storage::disk('custom')->put('/uploads/attachment/'.$directory.'/'.$name,$file->get());
            $path = 'uploads/attachment/'.$directory.'/'.$name;

            return $path;
        }
    }


    // public static function Attachment(array $file_parameters = null) {
    //     $file = $file_parameters['file'];
    //     $directory = $file_parameters['directory'];

    //     $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'_'.rand(1000000,9999999);
    //     $extension = $file->getClientOriginalExtension();
    //     $name = $filename.'.'.$extension;
    //     \Storage::disk('custom')->put('/uploads/attachment/'.$directory.'/'.$name,$file->get());
    //     $path = 'uploads/attachment/'.$directory.'/'.$name;
    //     return $path;
    // }

}
