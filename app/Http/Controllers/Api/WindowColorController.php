<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWindowColorRequest;
use App\Http\Requests\UpdateWindowColorRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowWindowColorResource;
use App\Http\Resources\WindowColorCollection;
use App\Models\WindowColor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WindowColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new WindowColorCollection(WindowColor::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWindowColorRequest $request)
    {
        // Image uploading is not working yet
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');

            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('uploads')->putFileAs('', $uploadedFile, $imageName);
        }

        return new ShowWindowColorResource(WindowColor::create([
            'image' => $filePath ,
            'name' => $request->name ,
            'vendor_code' => $request->vendor_code ,
            'price' => $request->price ,
            'sort_index' => $request->sort_index
        ]));
    }

    public function getImage($filename)
    {
        $file = Storage::disk('uploads')->get($filename);
        return response($file, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $windowColor = WindowColor::find($id);
        if (!$windowColor) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        return new ShowWindowColorResource($windowColor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWindowColorRequest $request, string $id)
    {
        $windowColor = WindowColor::find($id);

        $request->validate([
            'vendor_code' => Rule::unique('window_colors')->ignore($windowColor->id),
        ]);

        if($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('uploads')->delete($windowColor->image);
            // Upload the new image
            $uploadedFile = $request->file('image');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('uploads')->putFileAs('', $uploadedFile, $imageName);
        }else{
            $filePath = $windowColor->image;
        }
        $windowColor->update([
            'name' => $request->name,
            'image' => $filePath,
            'sort_index' => $request->sort_index,
            'vendor_code' => $request->vendor_code,
            'price' => $request->price
        ]);

        return new ShowWindowColorResource($windowColor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $windowColor = WindowColor::find($id);

        if (!$windowColor) {
            return new ReturnResponseResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }
        Storage::disk('uploads')->delete($windowColor->image);
        $windowColor->delete();
        return new ReturnResponseResource([
            'code' => 200,
            'message' => 'Window color deleted successfully'
        ]);
    }
}
