<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Upload;
use Auth;

class FileUploadController extends Controller
{
    public function uploadFile(Request $req)
    {
        $file = $req->file('img');
        $fName = time().'_'.$file->getClientOriginalName();
        $upPath = "image/".date('Y')."/".date('m');
        $store = $file->storeAs("public/".$upPath, $fName);
        $viewPath = '/storage/'.$upPath.'/'.$fName;
        $uploadData = [
            'orginal_name'  => $file->getClientOriginalName(),
            'storage_path'   => $store,
            'view_path'      => $viewPath,
            'file_size'     => $file->getSize(),
            'file_extesion' => $file->getClientOriginalExtension(),
        ];
        if ($store) {
            $upload_save = Upload::create($uploadData);
            //User::where('id', Auth::id())->update(['upload_id' => $upload_save->id]);
            return response()->json([
                'success'   => true, 
                'FileName'  => $fName,
                'uploadPath'    => $store,
                'viewPath'      => $viewPath,
                'orginalName'   => $file->getClientOriginalName()
            ]);
        }
        return response()->json([
            'success'   => false,
            'FileName'  => null,
        ]);
        
    }

    /**
     * Retrive images from database
     * Return as json formate 
     */

    public function retriveImages(Request $req)
    {
        $allImages = Upload::whereIn('file_extesion', ['webp', 'jpg', 'png', 'jpeg', 'mp4'])
        ->select(['id', 'view_path', 'storage_path','file_size', 'orginal_name', 'file_extesion'])->get();

        return response()->json([
            'status'    => true,
            'images'    => $allImages,
        ]);
    }


    /**
     * deleteFile images from database & files
     * Return response as json formate 
     */

    public function deleteFile(Request $req)
    {
        $file_id = $req->fileId; 
        $load_file_info = Upload::find($file_id);
        $file_deleted = Storage::delete($load_file_info->storage_path);
        $db_deleted = Upload::where('id', $file_id)->delete();

        return response()->json([
            'db_deleted_status'    => $db_deleted,
            'file_deleted_status'    => $file_deleted,
        ]);
    }
}
