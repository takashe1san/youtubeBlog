<?php

namespace App\Http\Trait;

trait imageUpload
{
    public function upload($file){
        $path = $file->store('images');
        return $path;
    }
}