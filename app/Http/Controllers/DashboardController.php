<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sale = new Sale();

        // Sales over time (monthly)
        $salesOverTime = $sale->getSalesOverTime();

        // Top 5 products
        $topProducts = $sale->getTopProducts();

        // Sales by Region
        $salesByRegion = $sale->getSalesByRegion();

        // Sales by Category
        $salesByCategory = $sale->getSalesByCategory();

        return view('dashboard', [
            'salesOverTime' => $salesOverTime,
            'topProducts' => $topProducts,
            'salesByRegion' => $salesByRegion,
            'salesByCategory' => $salesByCategory,
        ]);

    }
}
