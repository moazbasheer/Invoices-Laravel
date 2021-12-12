<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
class InvoicesReport extends Controller
{
    public function index() {
        return view('invoices.invoices_report');
    }

    public function search_invoices(Request $req) {
        if($req->rdio == 1) {
            if ($req->type && $req->start_at =='' && $req->end_at =='') {
                if($req->type == 'الكل') {
                    $invoices = Invoice::get();
                } else {
                    $invoices = Invoice::where('status','=',$req->type)->get();
                }
                $type = $req->type;
                return view('invoices.invoices_report',compact('type', 'invoices'));
            } else {
                
               $start_at = date($req->start_at);
               $end_at = date($req->end_at);
               $type = $req->type;
               if($type == 'الكل') {
                $invoices = Invoice::whereBetween('invoice_date',[$start_at, $end_at])->get();
               } else {
                $invoices = Invoice::whereBetween('invoice_date',[$start_at, $end_at])->where('status','=',$req->type)->get();
               }
               return view('invoices.invoices_report',compact('type','start_at','end_at','invoices'));
               
             }
        } else {
            $invoices = Invoice::where('invoice_number', $req->invoice_number)
                                ->get();
            return view('invoices.invoices_report', compact('invoices'));
        }
    }
}
