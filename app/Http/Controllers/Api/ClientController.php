<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ClientCollection(Client::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::firstOrNew(['phone_number' => $request->phone_number]);
        $client->name = $request->name;
        $client->save();
        return new ShowClientResource($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
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
        $client = Client::find($id);
        if(!$client){
            return new  ReturnResponseResource([
                'code' =>  404,
                'message' => "Record not found"
            ]);
        }
        $client->update([
            'name' => $request->name ,
            'phone_number' => $request->phone_number
        ]);
        return new ShowClientResource($client);
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
        $client->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => 'Client deleted successfully'
        ]);
    }
}
