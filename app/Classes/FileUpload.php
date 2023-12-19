<?php

namespace App\Classes;

use DB;

class FileUpload
{

    
    public function __construct()
    {
        
    }
    public function upload_image($file,$imagename,$imagepath,$oldimage) {
        
        $allowedfileExtension = array('jpg','png','PNG', 'JPG');
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $allowedfileExtension);
        if ($check){
            $destinationPath = storage_path($imagepath); // upload path
            $ImageName = $imagename.date('YmdHis').".".$extension;
            $upload_image = $file->move($destinationPath, $ImageName);
            $image = $ImageName;
            if ($oldimage !='NA') {
                $file_path = storage_path($imagepath).'/'.$oldimage;
                if(file_exists($file_path)){unlink($file_path);}
            }
        }else {
            return redirect()->back()->with('warning', 'Image extension not match.')->withInput();
        }

        return $image;
    }


  


}
