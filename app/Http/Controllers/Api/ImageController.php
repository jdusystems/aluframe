<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function imageUpload(StoreImageRequest $request){

        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');

            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('uploads')->putFileAs('', $uploadedFile, $imageName);

            $file_url = route('image.get' , $filePath);

            return response([
                 'message' => "Image uploaded successfully" ,
                 'image_name' => $filePath ,
                 'image_url' => $file_url
            ]);
        }
    }
    public function imageDelete(Request $request){
        $request->validate([
            'image_name' => "required"
        ]);
        Storage::disk('uploads')->delete($request->image_name);
        return response([
            'code' => 200 ,
            'message' => "Image deleted successfully"
        ]);
    }


}
