<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetOrderDetailRequest;
use App\Http\Resources\ReturnResponseResource;
use App\Http\Resources\ShowOrderResource;
use App\Models\AdditionalService;
use App\Models\AssemblyService;
use App\Models\Corner;
use App\Models\HandlerPosition;
use App\Models\OpeningType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProfileColor;
use App\Models\ProfileType;
use App\Models\Sealant;
use App\Models\Status;
use App\Models\User;
use App\Models\WindowColor;
use App\Models\WindowHandler;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{

    public function exportPdf1(string $id){
        $order = Order::find($id);
        if(!$order || $order->orderDetails()->count()  == 0){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }
        $orderDetails = $order->orderDetails;

        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width'),
            DB::raw('SUM(quantity_right) as quantity_right'),
            DB::raw('SUM(quantity_left) as quantity_left'),
            DB::raw('SUM(window_handler_quantity) as total_window_handler_quantity'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(width*height) as total_surface'),
            DB::raw('SUM(quantity_right) as quantity_right'),
            DB::raw('SUM(quantity_left) as quantity_left'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $additionalServices = OrderDetail::select('additional_service_id')->groupBy('additional_service_id')->where('order_id' , $order->id)->get();
        $assemblyServices = OrderDetail::select('assembly_service_id')->groupBy('assembly_service_id')->where('order_id' , $order->id)->get();

        $user = User::find($order->user_id);

        $filename = 'invoice1_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }
        $pdf = Pdf::loadView('pdf.pdf1' , ['order' => $order, 'orderDetails' => $orderDetails ,
            'profiles' => $profiles , 'windowColors' => $windowColors , 'user' => $user ,
            'additionalServices' => $additionalServices , 'assemblyServices' => $assemblyServices
        ]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }

    public function exportPdf2(string $id){
        $order = Order::find($id);
        if(!$order || $order->orderDetails()->count()  == 0){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }
        $orderDetails = $order->orderDetails;

        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width'),
            DB::raw('SUM(quantity_right) as quantity_right'),
            DB::raw('SUM(quantity_left) as quantity_left'),
            DB::raw('SUM(window_handler_quantity) as total_window_handler_quantity'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(width*height) as total_surface'),
            DB::raw('SUM(quantity_right) as quantity_right'),
            DB::raw('SUM(quantity_left) as quantity_left'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $additionalServices = OrderDetail::select('additional_service_id')->groupBy('additional_service_id')->where('order_id' , $order->id)->get();
        $assemblyServices = OrderDetail::select('assembly_service_id')->groupBy('assembly_service_id')->where('order_id' , $order->id)->get();

        $user = User::find($order->user_id);

        $filename = 'invoice2_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }
        $pdf = Pdf::loadView('pdf.pdf2' , ['order' => $order, 'orderDetails' => $orderDetails ,
            'profiles' => $profiles , 'windowColors' => $windowColors , 'user' => $user ,
            'additionalServices' => $additionalServices , 'assemblyServices' => $assemblyServices
        ]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }
    public function exportPdf3(string $id){
        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }

        $orderDetails = $order->orderDetails;
        $profiles = OrderDetail::select('profile_type_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width') ,
            DB::raw('SUM(quantity_right) as total_quantity_right'),
            DB::raw('SUM(quantity_left) as total_quantity_left') ,
            DB::raw('SUM(quantity_right*height) as quantity_right_height') ,
            DB::raw('SUM(quantity_right*width) as quantity_right_width') ,
            DB::raw('SUM(quantity_left*height) as quantity_left_height'),
            DB::raw('SUM(quantity_left*width) as quantity_left_width'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width') ,
            DB::raw('SUM(quantity_right) as total_quantity_right') ,
            DB::raw('SUM(quantity_left) as total_quantity_left'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $filename = 'invoice3_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }

        $pdf = PDF::loadView('pdf.pdf3' , ['order' => $order,'orderDetails' => $orderDetails , 'profiles' => $profiles , 'windowColors' => $windowColors]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }
    public function exportPdf4(string $id){

        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }

        $orderDetails = $order->orderDetails;
        $filename = 'invoice4_' . $order->order_id . '.pdf';

        if (Storage::disk('pdf')->exists($filename)) {
            // If the file exists, return its URL
            $url = url(Storage::url($filename));
            return response()->json(['pdf' => $url]);
        }


        $pdf = PDF::loadView('pdf.pdf4'  , ['order' => $order , 'orderDetails' => $orderDetails]);
        $pdfContents = $pdf->output();

        Storage::disk('pdf')->put($filename , $pdfContents);
        $url = url(Storage::url($filename));
        return response()->json(
            [
                'pdf' => $url ,
            ]);
    }




    public function orderDetails(GetOrderDetailRequest $request){

        $details = $request->input('orders');
        $totalPrice = 0;
        $data =  [];
        foreach ($details as $detail){
            $price = 0;
            $profileNumber = 0;
            if($detail['profile_type_id']){
                $profileType = ProfileType::find($detail['profile_type_id']);
                $profileNumber += 1;

                if(array_key_exists('quantity_right' , $detail) && $detail['quantity_right'] > 0){
                    $profileNumber += $detail['quantity_right'];
                }
                if(array_key_exists('quantity_left' , $detail) && $detail['quantity_left'] > 0){
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
                $surface = $profileNumber * ($width * $height);

                if($profileType->sealant){
                    $sealant = Sealant::where('profile_type_id' , $profileType->id)->first();
                    $price += $peremetr*$sealant->price;
                }
                if($profileType->window_handler){
                    $windowHandler = WindowHandler::where('profile_type_id' , $profileType->id)->where('profile_color_id' , $detail['profile_color_id'])->first();
                    $handlerPosition = HandlerPosition::find($detail['handler_position_id']);
                    if($handlerPosition->slug == "no_handler"){
                        $windowHandlerQuantity += 0;
                        $profilePeremetr = $profilePeremetr + 2 * $width + 2 * $height;
                    }
                    if($handlerPosition->slug == "opposite"){
                        $price += $height*$windowHandler->price;
                        $windowHandlerQuantity = $height;
                        $profilePeremetr = $profilePeremetr + 2*$width + $height;
                    }
                    if($handlerPosition->slug == "top"){
                        $price += $width*$windowHandler->price;
                        $windowHandlerQuantity = $width;
                        $profilePeremetr = $profilePeremetr + 2*$height + $width;
                    }
                    if($handlerPosition->slug == "below"){
                        $price += $width*$windowHandler->price;
                        $windowHandlerQuantity = $width;
                        $profilePeremetr = $profilePeremetr + 2*$height + $width;
                    }
                    if($handlerPosition->slug == "round"){
                        $price += $peremetr*$windowHandler->price;
                        $windowHandlerQuantity = $peremetr;
                        $profilePeremetr += 0;
                    }
                }
                if($profileType->corner){
                    $corner = Corner::where('profile_type_id' , $profileType->id)->first();
                    if($corner){
                        $price += 4 * $profileNumber * $corner->price;
                    }
                }
                $price += $profileNumber*$profilePeremetr*$profileType->price;
            }
            if($detail['window_color_id']){
                $windowColor = WindowColor::find($detail['window_color_id']);
                if($windowColor){
                    $price += $surface * $windowColor->price;
                }
            }
            if(array_key_exists('additional_service_id' ,$detail)){
                $additionalService = AdditionalService::find($detail['additional_service_id']);
                if($additionalService){
                    $price += $additionalService->price ;
                }
            }
            if($height < 1.8){
                $assemblyService = AssemblyService::where('facade_height' , 1800)->first();
                if($assemblyService){
                    $price += $assemblyService->price ;
                }

            }elseif($height > 1.8){
                $assemblyService = AssemblyService::where('facade_height' , 2400)->first();
                if($assemblyService){
                    $price += $assemblyService->price ;
                }
            }
            $windowColor1 = WindowColor::find($detail['window_color_id']);
            $profileColor1 = ProfileColor::find($detail['profile_color_id']);
            $openingType1 = OpeningType::find($detail['opening_type_id']);
            if(array_key_exists('additional_service_id' ,$detail)){
                $additionalService1 = AdditionalService::find($detail['additional_service_id']);
            }
             if(array_key_exists('handler_position_id' ,$detail)){
                $handlerPosition1 = HandlerPosition::find($detail['handler_position_id']);
            }
            if($profileType->sealant){
                $sealant1 = Sealant::where('profile_type_id' , $profileType->id)->first();
            }
            if($profileType->window_handler) {
                $windowHandler1 = WindowHandler::where('profile_type_id', $profileType->id)->where('profile_color_id', $detail['profile_color_id'])->first();
            }
            if($profileType->corner){
                $corner1 = Corner::where('profile_type_id' , $profileType->id)->first();
            }

            $data = [
                'profile_type_name' => $profileType->name ,
                'profile_type_price' => $profileType->price ,
                'profile_quantity' => 2*($width+$height)*( + $detail['quantity_right']+1) ,
                'window_color_name' => $windowColor1->name ,
                'window_color_price' => $windowColor1->price ,
                'window_color_surface' => ($width*$height)*($detail['quantity_left'] + $detail['quantity_right']+1) ,
                'profile_color_name' =>  $profileColor1->name,
                'opening_type_name' => $openingType1->name ,
                'handler_position_name' => ($handlerPosition1) ? $handlerPosition1->name :"",
                'additional_service_name' => ($additionalService1) ? $additionalService1->name  : "",
                'additional_service_price' => ($additionalService1) ? $additionalService1->price  : 0,
                'additional_service_quantity' => ($additionalService1) ? 1  : 0,
                'assembly_service_name' => ($assemblyService) ? $assemblyService->name : "" ,
                'assembly_service_price' => ($assemblyService) ? $assemblyService->price : 0 ,
                'assembly_service_quantity' => ($assemblyService) ? 1 : 0 ,
                'sealant_name' => ($sealant1) ? $sealant1->name : "",
                'sealant_price' => ($sealant1) ? $sealant1->price : 0,
                'sealant_quantity' => ($sealant1) ? $sealantQuantity : 0,
                'window_handler_name' => ($windowHandler1) ? $windowHandler1->name : "",
                'window_handler_price' => ($windowHandler1) ? $windowHandler1->price : 0,
                'window_handler_quantity' => ($windowHandler1) ? $windowHandlerQuantity : 0,
                'conrer_name' => ($corner1)  ? $corner->name : "",
                'conrer_price' => ($corner1)  ? $corner->price : 0,
                'conrer_quantity' => ($corner1)  ? $cornerQuantity : 0,
                'width' => $width ,
                'height' => $height ,
                'quantity_right' => (array_key_exists('quantity_right', $detail)) ? $detail['quantity_right'] : 0 ,
                'quantity_left' => (array_key_exists('quantity_left' , $detail)) ? $detail['quantity_left'] : 0 ,
                'number_of_loops' => ($detail['number_of_loops']) ? $detail['number_of_loops'] : 1 ,
                'comment' => ($detail['comment']) ? $detail['comment'] : " " ,
                'X1' => (array_key_exists('X1' , $detail)) ? $detail['X1'] : null ,
                'X2' => (array_key_exists('X2' , $detail)) ? $detail['X2'] : null ,
                'Y1' => (array_key_exists('Y1' , $detail)) ? $detail['Y1'] : null ,
            ];
        }

        return response()->json([
            'data' => $data ,
        ]);
    }

}
