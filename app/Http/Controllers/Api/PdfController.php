<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{

    public function exportPdf1(){

//        return view('pdf.pdf1');
        $pdf = Pdf::loadView('pdf.pdf1');
        return $pdf->download('invoice.pdf');
    }
    public function exportPdf2(){
        $pdf = PDF::loadView('pdf2');
        return $pdf->str('document2.pdf');
    }
    public function exportPdf3(){
        $pdf = PDF::loadView('pdf3');
        return $pdf->download('document3.pdf');
    }
    public function exportPdf4(){
        $pdf = PDF::loadView('pdf4');
        return $pdf->download('document4.pdf');
    }

}
