<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWindowColorRequest;
use App\Http\Requests\UpdateWindowColorRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\ShowWindowColorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\WindowColorCollection;
use App\Models\WindowColor;
use Illuminate\Http\Request;
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
        return new ShowWindowColorResource(WindowColor::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $windowColor = WindowColor::find($id);
        if (!$windowColor) {
            return new ErrorResource([
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

        $windowColor->update([
            'name' => $request->name,
            'image' => $request->image,
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
            return new ErrorResource([
                'code' => 404,
                'message' => 'Record not found.',
            ]);
        }

        $windowColor->delete();

        return new SuccessResource([
            'code' => 200,
            'message' => 'Window color deleted successfully'
        ]);
    }
}
