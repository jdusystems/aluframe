<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOrderResource;
use App\Models\AdditionalService;
use App\Models\AssemblyService;
use App\Models\Corner;
use App\Models\Currency;
use App\Models\HandlerPosition;
use App\Models\HandlerType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use App\Models\Sealant;
use App\Models\Status;
use App\Models\WindowColor;
use App\Models\WindowHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->exists('per_page')){
            $itemsPerPage = $request->per_page;
        }else{
            $itemsPerPage = 10;
        }
        $user = Auth::user();
        if($user->is_admin == 1 || $user->superadmin == 1){
            $orders = Order::latest()->paginate($itemsPerPage);
        }else{
            $orders = Order::where('user_id' , $user->id)->latest()->paginate($itemsPerPage);
        }
        return new OrderCollection($orders);
    }
    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $currency = Currency::find($request->currency_id);
            $startingOrderId = 1000;
            $lastOrderId = Order::max('order_id');
            $nextOrderId = $lastOrderId ? $lastOrderId + 1 : $startingOrderId;
            $status = Status::where('slug' , 'pending')->first();
            $order = Order::create([
                'currency_id' => $currency->id ,
                'language' => $request->language,
                'order_id' => $nextOrderId,
                'user_id' => $request->user_id ,
                'status_id' => $status->id
            ]);
            $details = $request->input('orders');
            $totalPrice = 0;
            foreach ($details as $detail){
                $profilePrice = 0;
                $cornerPrice = 0;
                $sealantPrice = 0;
                $windowPrice = 0;
                $windowHandlerPrice = 0;
                $assemblyServicePrice = 0;
                $additionalServicePrice = 0;
                $price = 0;
                $profileNumber = 0;
                if($detail['profile_type_id']){
                    $profileType = ProfileType::find($detail['profile_type_id']);
                    $profilePrice = $profileType->price;
                    $profileNumber = 0;
                    if(array_key_exists('quantity_right' , $detail)){
                        $profileNumber += $detail['quantity_right'];
                    }
                    if(array_key_exists('quantity_left' , $detail)){
                        $profileNumber += $detail['quantity_left'];
                    }

                    $width = $detail['width']/1000;
                    $height = $detail['height']/1000;
                    $peremetr = 2*($width + $height) * $profileNumber;

                    $cornerQuantity = 4*$profileNumber;
                    $profilePeremetr = 0;
                    $sealantQuantity = $peremetr;
                    //
                    $windowHandlerQuantity = 0;
                    //
                    $thickness = $profileType->thickness/1000;
                    $surface = $profileNumber * (($width -$thickness) * ($height - $thickness));

                    if($profileType->sealant){
                        $sealant = Sealant::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                        $price += $peremetr*$sealant->price;
                        $sealantPrice = $sealant->price;
                    }
                    $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->whereNull('deleted_at')->first();

                    if($windowHandler){
                        $windowHandlerPrice = $windowHandler->price;
                        $handlerPosition = HandlerPosition::find($detail['handler_position_id']);
                        if($handlerPosition->slug == "no_handler"){
                            $windowHandlerQuantity += 0;
                            $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                        }
                        if($windowHandler){
                            if($handlerPosition->slug == "opposite"){
                                $price += $height*$windowHandler->price*$profileNumber;
                                $windowHandlerQuantity = $height;
                                $profilePeremetr = $profilePeremetr + 2*$width + $height;
                            }
                            if($handlerPosition->slug == "top"){
                                $price += $width*$windowHandler->price*$profileNumber;
                                $windowHandlerQuantity = $width;
                                $profilePeremetr = $profilePeremetr + 2*$height + $width;
                            }
                            if($handlerPosition->slug == "below"){
                                $price += $width*$windowHandler->price*$profileNumber;
                                $windowHandlerQuantity = $width;
                                $profilePeremetr = $profilePeremetr + 2*$height + $width;
                            }
                            if($handlerPosition->slug == "round"){
                                $price += $profileNumber * 2*($width + $height)*$windowHandler->price;
                                $windowHandlerQuantity = 2*($width + $height);
                                $profilePeremetr += 0;
                            }
                        }else{
                            return new ReturnResponseResource([
                                'code' => 404 ,
                                'message' => 'Window handler not found!'
                            ]  , 404);
                        }
                    }
                    if($profileType->corner){
                        $corner = Corner::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                        if($corner){
                            $price += 4 * $profileNumber * $corner->price;
                            $cornerPrice = $corner->price;
                        }
                    }
                    $price += $profileNumber*$profilePeremetr*$profileType->price;
                }
                if($detail['window_color_id']){
                    $windowColor = WindowColor::find($detail['window_color_id']);
                    if($windowColor){
                        $price += $surface * $windowColor->price;
                        $windowPrice = $windowColor->price;
                    }
                }
                if(array_key_exists('additional_service_id' ,$detail)){
                    $additionalService = AdditionalService::find($detail['additional_service_id']);
                    if($additionalService){
                        $price += $additionalService->price*$surface;
                        $additionalServicePrice = $additionalService->price;
                    }
                }
                // Mana shu joyini ko'rish kerak balandlik yoki peremetr assembly service
                $assemblyService = null;
                if($height <= 1.8){
                    $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator', '<')->first();
                    if($assemblyService){
                        $price += $assemblyService->price*$profileNumber;
                        $assemblyServicePrice = $assemblyService->price;
                    }
                }elseif($height > 1.8){
                    $assemblyService = AssemblyService::where('facade_height' , 2400)->where('condition_operator', '>')->first();
                    if($assemblyService){
                        $price += $assemblyService->price*$profileNumber;
                        $assemblyServicePrice = $assemblyService->price;
                    }
                }
                OrderDetail::create([
                    'order_id' => $order->id ,
                    'profile_type_id' => $detail['profile_type_id'] ,
                    'window_color_id' => $detail['window_color_id'] ,
                    'profile_color_id' => $detail['profile_color_id'] ,
                    'opening_type_id' => $detail['opening_type_id'] ,
                    'handler_position_id' => $detail['handler_position_id'] ,
                    'additional_service_id' => (array_key_exists('additional_service_id' ,$detail)) ? $detail['additional_service_id'] : null ,
                    'assembly_service_id' => ($assemblyService) ? $assemblyService->id : null ,
                    'width' => $width ,
                    'height' => $height ,
                    'quantity_right' => (array_key_exists('quantity_right', $detail)) ? $detail['quantity_right'] : 0 ,
                    'quantity_left' => (array_key_exists('quantity_left' , $detail)) ? $detail['quantity_left'] : 0 ,
                    'number_of_loops' => ($detail['number_of_loops']) ? $detail['number_of_loops'] : 0 ,
                    'comment' => ($detail['comment']) ? $detail['comment'] : " " ,
                    'corner_quantity' =>  $cornerQuantity,
                    'sealant_quantity' =>  $sealantQuantity,
                    'window_handler_quantity' =>  $windowHandlerQuantity*$profileNumber,
                    'status_id' =>  1,
                    'additive_sizes' => (array_key_exists('additive_sizes' , $detail)) ? $detail['additive_sizes'] : "",
                    'profile_price' => $profilePrice * $currency->rate ,
                    'corner_price' => $cornerPrice * $currency->rate,
                    'sealant_price' => $sealantPrice * $currency->rate ,
                    'window_handler_price' => $windowHandlerPrice * $currency->rate ,
                    'window_price' => $windowPrice * $currency->rate ,
                    'assembly_service_price' => $assemblyServicePrice * $currency->rate ,
                    'additional_service_price' =>  $additionalServicePrice * $currency->rate,
                    'price' => $price * $currency->rate ,
                    'facade_quantity' => $profileNumber ,
                    'surface' => $surface ,
                    'profile_length' => $profilePeremetr*$profileNumber
                ]);
                $totalPrice += $price * $currency->rate;
            }
            if($totalPrice > 0){
                $order->update([
                    'total_price' => $totalPrice
                ]);
            }
            DB::commit();
            return new ShowOrderResource($order);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => "Something went wrong!"
            ] , 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        return new ShowOrderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'integer' , "exists:statuses,id"],
        ]);
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $order->update([
            'status_id' => $request->status
        ]);
        return new ShowOrderResource($order);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if(!$order){
            return new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ]);
        }
        $order->orderDetails()->delete();
        $order->delete();
        return new ReturnResponseResource([
            'code' => 200 ,
            'message' => "Order and associated details deleted successfully."
        ]);
    }

    public function getOrderPrice(Request $request){

        $totalPrice = 0;
        $profilePrice = 0;
        $windowPrice = 0;
        $cornerPrice = 0;
        $sealantPrice = 0;
        $windowHandlerPrice = 0;
        $additionalServicePrice = 0;
        $assemblyServicePrice = 0;
        $profilePerimeter = 0;

        $width = 0;
        $height = 0;

        if($request->has('width')  && $request->has('height') ){
            $width = $request->width/1000;
            $height = $request->height/1000;
        }elseif($request->width==0 || $request->height == 0){
            $price = 0;
            if($request->has('profile_type_id')){
                $profileType = ProfileType::find($request->profile_type_id);
                if($profileType){
                $price += $profileType->price;
                }
            }
            if($request->has('window_color_id')){
                $price += 10;
                $windowColor = WindowColor::find($request->window_color_id);
                if($windowColor){
                    $price += $windowColor->price;
                }
            }
            return response()->json([
                'total_price' => $price
            ]);
        }

        $profileNumber = 1;

        if($request->has('quantity_left')){
            $profileNumber += $request->quantity_left;
        }
        if($request->has('quantity_right')){
            $profileNumber += $request->quantity_right;
        }
        if($profileNumber > 1){
            $profileNumber = $profileNumber - 1;
        }
        $perimeter = 2*($width + $height);

        if($request->has('profile_type_id')){
            $profileType = ProfileType::find($request->profile_type_id);
            if($profileType){
                if($profileType->sealant){
                    $sealant  = Sealant::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                    if($sealant){
                        $sealantPrice += 2*($height + $width)*$sealant->price*$profileNumber;
                    }
                }
                if($profileType->corner){
                    $corner = Corner::where('profile_type_id' , $profileType->id)->whereNull('deleted_at')->first();
                    if($corner){
                        $cornerPrice += $corner->price*4*$profileNumber;
                    }
                }
                if($request->has('handler_position_id')){
                    if($profileType->window_handler){
                            if($request->has('profile_color_id')){
                                $profileColor = ProfileColor::where('id',$request->profile_color_id)->whereNull('deleted_at')->first();
                                if($profileColor){
                                    $handlerPosition = HandlerPosition::find($request->handler_position_id);
                                    $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $profileColor->id)->whereNull('deleted_at')->first();
                                    if($handlerPosition && $windowHandler){
                                        if($handlerPosition->slug =="no_handler"){
                                            $profilePerimeter = $profilePerimeter + 2*($width + $height);
                                        }
                                        if($handlerPosition->slug =="opposite"){
                                         $profilePerimeter = $profilePerimeter + 2*$width + $height;
                                         $windowHandlerPrice += $height*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug=="top"){
                                            $profilePerimeter = $profilePerimeter + 2*$height + $width;
                                            $windowHandlerPrice =+ $width*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug == "below"){
                                            $profilePerimeter = $profilePerimeter + 2*$height + $width;
                                            $windowHandlerPrice += $width*$windowHandler->price*$profileNumber;
                                        }
                                        if($handlerPosition->slug=="round"){
                                            $profilePerimeter += 0;
                                            $windowHandlerPrice += 2*($width + $height)*$profileNumber*$windowHandler->price;
                                        }
                                    }
                                }
                            }
                    }
                }
                else{
                    $profilePerimeter = 2*($width + $height);
                }
            }
                $profilePrice = $profileNumber * $profileType->price*$profilePerimeter;
        }
        if($request->has('window_color_id')){
            $windowColor = WindowColor::find($request->window_color_id);
            if($windowColor){
                if($width > 0 && $height > 0){
                $windowPrice = $windowPrice + $profileNumber*$width*$height*$windowColor->price;
                }else{
                   $windowPrice +=  $windowColor->price;
                }
            }
        }
        if($request->has('additional_service_id')){
            $additionalService = AdditionalService::find($request->additional_service_id);
            if($additionalService){
                if($height && $width){
                    $additionalServicePrice += $additionalService->price*$height*$width*$profileNumber;
                }else{
                    $additionalServicePrice += $additionalService->price;
                }
            }
        }
        if($height < 1800 ){
            $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '<')->first();
            if($assemblyService){
                $assemblyServicePrice += $assemblyService->price*$profileNumber;
            }
        }elseif($height >= 1800){
            $assemblyService = AssemblyService::where('facade_height' , 1800)->where('condition_operator' , '>')->first();
            if($assemblyService){
                $assemblyServicePrice += $assemblyService->price*$profileNumber;
            }
        }

        $totalPrice += $sealantPrice + $cornerPrice+$windowHandlerPrice+$profilePrice+$windowPrice+$additionalServicePrice+$assemblyServicePrice;

        return response()->json([
            'totalPrice' => $totalPrice ,
            'sealant_price' => $sealantPrice ,
            'corner_price' => $cornerPrice ,
            'window_handler_price' =>$windowHandlerPrice ,
            'profile_price' => $profilePrice ,
            'window_price' => $windowPrice ,
            'additional_service_price' => $additionalServicePrice ,
            'assembly_service_price' => $assemblyServicePrice
        ]);
    }

}
