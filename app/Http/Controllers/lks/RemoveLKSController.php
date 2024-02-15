<?php

namespace App\Http\Controllers\lks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Svg\Tag\Rect;
use ZipArchive; 

class RemoveLKSController extends Controller
{
    //



    public function createZipAndDownload(Request $req) 
    {
        try 
        {  
            if (!empty($req->fileName)) 
            {
                
                $paths = explode(',',$req->fileName);
                
                $zip = new ZipArchive;
                $zipFileName = $req->ba.' - '. $req->name .' - ' .$req->from_date.'-'.$req->to_date.'.zip';

                if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) 
                {
            
                    $destination = public_path('temp/'.$req->folder_name);
                    foreach ($paths as $file) 
                    {
                        $filePath = $destination.'/'.$file;
                        if (file_exists($filePath)) 
                        {
                            $zip->addFile($filePath, basename($filePath));
                        }
                    }

                    $zip->close();


                        File::deleteDirectory($destination);
                    

                    return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
                } 
            }
            else 
            {
                return "Failed to create the zip file.";
            }
        } catch (\Throwable $th) {
            return "try again...";
        }
    }

    public function removeFiles(Request $req)  
    {
        if ($req->has('fileName') && $req->fileName != '') 
        {
            if (file_exists(public_path('/temp/'.$req->fileName))) 
            {
                File::delete(public_path('/temp/'.$req->fileName));
                return 'success';
            }
        }
    }
}
