<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadFile
{
  public function uploadSingleFile($file, $path): string
  {
    if (is_string($file)) {
      $file = new UploadedFile($file, basename($file));
    }

    $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    $file->move($path, $filename);
    return $filename;
  }

  public function deleteExistFile($path)
  {
    if(File::exists("$path") ) {
      File::delete("$path");
    }
  }
}
