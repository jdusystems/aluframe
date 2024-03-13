<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowClientResource;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $phoneNumber = $request->number;
        if($request->exists('per_page')){
            $itemsPerPage = $request->per_page;
        }else{
            $itemsPerPage = 10;
        }
        if(empty($name) && empty($phoneNumber)){
            return new ClientCollection(User::latest()->paginate($itemsPerPage));
        }else{
            $clients = User::where('active' , 1)->when($phoneNumber, function ($query) use ($phoneNumber) {
                $query->where('phone_number','LIKE', '%'. $phoneNumber .'%');
            })->when($name, function ($query) use ($name) {
                    $query->where('name', 'LIKE','%'. $name.'%');
                })->latest()->paginate($itemsPerPage);
            return new ClientCollection($clients);
        }

    }

    public function all()
    {
        return new ClientCollection(User::orderBy('created_at')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $password = Str::random(10);
        $client = User::create([
            'phone_number' => $request->phone_number ,
            'name' => $request->name ,
            'password' => $password ,
            'registered' => true ,
            'parol' => $password
        ]);
        return new ShowClientResource($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = User::find($id);
        if(!$client){
            return new ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        return new ShowClientResource($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, string $id)
    {
        $client = User::find($id);
        if(!$client){
            return new  ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        $client->update([
            'name' => $request->name ,
            'phone_number' => $request->phone_number ,
        ]);
        return new ShowClientResource($client);
    }
    public function deleteMultiple(Request $request){
        $request->validate([
            'ids' => 'required|array|min:1' ,
        ]);
        $ids = $request->json('ids');
        if (!empty($ids) && is_array($ids)) {
            DB::table('users')->whereIn('id',$ids)->update(['active' => 0]);
            return response()->json(['message' => 'Records deleted successfully.'], 200);
        } else {
            return response()->json(['error' => 'Invalid or empty IDs provided.'], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        if(!$client){
            return new ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        if($client->orders()->count() > 0){
            return new ReturnResponseResource([
                'code' => 422 ,
                'message' => "You can not delete this Item!"
            ]);
        }
        $client->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Client deleted successfully'
        ]);
    }
}
