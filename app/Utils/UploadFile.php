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
    $file->move(public_path("$path"), $filename);
    return $filename;
  }

//   public function uploadDoubleFile($file_first, $path_first, $file_second, $path_second): array
//   {
//     if (is_string($file_first)) {
//       $file_first = new UploadedFile($file_first, basename($file_first));
//       $filenamefirst = time() . '-' . Str::random(10) . '.' . $file_first->getClientOriginalExtension();    
//       $file_first->move(public_path("uploads/$path_first"), $filenamefirst);
//     }

//     if (is_string($file_second)) {
//       $file_second = new UploadedFile($file_second, basename($file_second));
//       $filenamesecond = time() . '-' . Str::random(10) . '.' . $file_second->getClientOriginalExtension();    
//       $file_second->move(public_path("uploads/$path_second"), $filenamesecond);
//     }

//     return [$filenamefirst, $filenamesecond];
//   }
  
  public function deleteExistFile($path)
  {    
    if(File::exists("uploads/$path") ) {
      File::delete("uploads/$path");
    }
  }
}