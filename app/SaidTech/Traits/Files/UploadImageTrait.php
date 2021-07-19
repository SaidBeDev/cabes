<?php

namespace App\SaidTech\Traits\Files;

use Dirape\Token\Token;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as IntImage;

trait UploadImageTrait
{

    public function getConfigs($uri) {
        $upload_path = config('SaidTech.images.'. $uri .'.upload_path');
        $height = config('SaidTech.images.'. $uri .'.height');
        $width = config('SaidTech.images.'. $uri .'.width');

        $config = [
            'upload_path' => $upload_path,
            'height' => $height,
            'width' => $width
        ];

        return $config;
    }

    /**
     * Upload image to server
     */
    public function uploadImage($image, $uri, $table = '', $field = '') {

        $config = $this->getConfigs($uri);

        if ($table !== '' && $field != '') {
            $fileName = $this->generateImageName($image, $table, $field);

            if (isset($config['height']) || isset($config['width']))
            {
                if (!empty(request()->image)) {
                    $res = Storage::put($config['upload_path'] . $fileName, $this->resizeImage($image, $config));
                }
            }
        }else {
            throw new \LogicException("Table name and field can't be null");
        }

        return $fileName ? $fileName : false;

    }

    /**
     * Upload image to server and move old one
     */
    public function uploadImageAndMove($image, $oldImage, $uri, $table = '', $field = '') {

        $config = $this->getConfigs($uri);

        if ($table !== '' && $field != '') {
            if (!empty($oldImage)) {
                Storage::move($config['upload_path'] . $oldImage, $config['upload_path'] . 'oldImages/' . $oldImage);
            }

            $fileName = $this->uploadImage($image, $uri, $table, $field);

        }else {
            throw new \LogicException("Table name and field can't be null");
        }

        return $fileName ? $fileName : false;

    }


    public function resizeImage($image, $config = []) {

        if (isset($config['height']) && isset($config['width']))
        {
            $img = IntImage::make($image->getRealPath());

            $img->resize($config['width'], $config['height']);

            $img->stream();

            return $img;
        }
        elseif (isset($config['height'])) {

            $img = IntImage::make($image->getRealPath());

            $img->resize(null, $config['height'], function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream();

            return $img;
        }
        elseif (isset($config['width'])) {
            $img = IntImage::make($image->getRealPath());

            $img->resize($config['width'], null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream();

            return $img;
        }

    }

    public function generateImageName($image, $table, $field) {

        // Generate a unique image name
        $token = new Token();
        $imageName = $token->UniqueString($table, $field, 15) . '.' . request()->image->getClientOriginalExtension();

        return $imageName;
    }

}
