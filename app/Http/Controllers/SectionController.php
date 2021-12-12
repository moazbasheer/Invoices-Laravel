<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Auth;
class SectionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:الاقسام', 
        ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', 
        ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف قسم', 
        ['only' => ['destroy']]);
        $this->middleware('permission:تعديل قسم', 
        ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();
        return view('sections.sections', compact('sections'));
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
        $exists = Section::where('section_name', $request->section_name)->exists();
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required'
        ],[
            'section_name.required' => 'اسم القسم مطلوب',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال الملاحظات'
        ]);
        
        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name
        ]);
        session()->flash('Add', 'تم تسجيل القسم بنجاح');
    
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required'
        ],[
            'section_name.required' => 'اسم القسم مطلوب',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال الملاحظات'
        ]);
        
        $section = Section::find($request->id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        session()->flash('edit', ' تم التعديل بنجاح');
    
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return back();
    }
}
