<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReturnResponseResource;
use App\Models\Order;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{

    public function exportPdf1(string $id){
        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }

        $orderDetails = $order->orderDetails;

        $pdf = Pdf::loadView('pdf.pdf1' , ['order' => $order , 'orderDetails' => $orderDetails]);

        return $pdf->stream('invoice.pdf');
    }


    public function exportPdf2(string $id){
        $order = Order::find($id);
        if(!$order){
            return  new ReturnResponseResource([
                'code' => 404 ,
                'message' => "Record not found!"
            ] , 404);
        }
        $orderDetails = $order->orderDetails;



        $pdf = PDF::loadView('pdf.pdf2');
        return $pdf->stream('document2.pdf');
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
            DB::raw('SUM(quantity_right) as quantity_right') ,
            DB::raw('SUM(quantity_left) as quantity_left'),
        )->groupBy('profile_type_id')->where('order_id' , $order->id)->get();

        $windowColors = OrderDetail::select('window_color_id' ,
            DB::raw('SUM(height) as total_height') ,
            DB::raw('SUM(width) as total_width') ,
            DB::raw('SUM(quantity) as total_quantity') ,
            DB::raw('SUM(quantity_right) as quantity_right') ,
            DB::raw('SUM(quantity_left) as quantity_left'),
        )->groupBy('window_color_id')->where('order_id' , $order->id)->get();

        $pdf = PDF::loadView('pdf.pdf3' , ['orderDetails' => $orderDetails , 'profiles' => $profiles , 'windowColors' => $windowColors]);

        return $pdf->stream('document3.pdf');
    }
    public function exportPdf4(){

        $orders = [1 , 2 , 3 , 4 ,5 , 6 ,7,8 ,9 ,10];
        $pdf = PDF::loadView('pdf.pdf4'  , ['orders' => $orders]);
        return $pdf->stream('document4.pdf');
    }

}
