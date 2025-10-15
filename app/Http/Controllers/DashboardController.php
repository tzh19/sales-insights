<?php

namespace App\Http\Controllers;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // Sales over time (monthly)
        $salesOverTime = Sale::select(
            DB::raw('DATE_FORMAT(sale_date, "%b,%y") as month'),
            DB::raw('SUM(revenue) as total_revenue')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Top 5 products
        $topProducts = Sale::select(
            'product_id',
            DB::raw('SUM(revenue) as total_revenue')
        )
        ->groupBy('product_id')
        ->orderByDesc('total_revenue')
        ->take(5)
        ->with('product:id,name,category')
        ->get();

        // Sales by Region
        $salesByRegion = Sale::select(
            'region_id',
            DB::raw('SUM(revenue) as total_revenue')
        )
        ->groupBy('region_id')
        ->with('region:id,name')
        ->get();

        return view('dashboard', [
            'salesOverTime' => $salesOverTime,
            'topProducts' => $topProducts,
            'salesByRegion' => $salesByRegion
        ]);

    }
}
