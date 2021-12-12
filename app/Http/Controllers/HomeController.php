<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_all = Invoice::count();
        $count_invoices_paid = Invoice::where('Value_Status', 1)->count();
        $count_invoices_not_paid = Invoice::where('Value_Status', 2)->count();
        $count_invoices_partially = Invoice::where('Value_Status', 3)->count();

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 350, 'height' => 200])
        ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                "label" => "الفواتير غير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$count_invoices_not_paid / $count_all * 100]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$count_invoices_paid / $count_all * 100]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$count_invoices_partially / $count_all * 100]
            ],


        ])
        ->options([]);
        $chartjs2 = app()->chartjs
         ->name('pieChartTest')
         ->type('pie')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
         ->datasets([
             [
                 'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                 'data' => [
                     $count_invoices_not_paid / $count_all * 100,
                     $count_invoices_paid / $count_all * 100,
                     $count_invoices_partially / $count_all * 100
                 ]
             ]
         ])
         ->options([]);

        return view('home', compact('chartjs', 'chartjs2'));
    }
}
