<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\Section;
use App\Models\Product;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use Notification;
use Auth;
use Storage;
use Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::get();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = Invoice::latest()->first()->id;
        Invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->pic;
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            $request->pic->move(public_path('Attachments/' . $invoice_number), $file_name);
        }
        $user = User::first();
        Notification::send($user, new AddInvoice($invoice_id));
        session()->flash('Add', 'تم تسجيل الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {   
        $invoice = Invoice::find($req->invoice_id);
        if($req->page_id == 2) {
            $invoice->delete();
        } else {
            Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number);
            $invoice->forceDelete();
        }
        
        return redirect()->route('invoices.index');
    }

    public function getProducts($id) {
        $products = Product::where('section_id', $id)->pluck('Product_name', 'id');
        return json_encode($products);
    }

    public function print($id) {
        $invoices = Invoice::find($id);
        return view('invoices.print_invoice', compact('invoices'));
    }

    public function export() {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

}

