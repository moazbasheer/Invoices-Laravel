<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:المنتجات', 
        ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', 
        ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف منتج', 
        ['only' => ['destroy']]);
        $this->middleware('permission:تعديل منتج', 
        ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('section')->get();
        $sections = Section::get();
        return view('products.products', compact('products', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'section_id' => 'required',
            'description' => 'required'
        ], [
            'product_name.required' => "اسم المنتج مطلوب",
            "description.required" => 'الوصف مطلوب',
            "section_id.required" => 'اسم القسم مطلوب'
        ]);
        Product::create([
            'Product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Section::where('section_name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);

        $Products->update([
            'Product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::find($request->pro_id)->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
