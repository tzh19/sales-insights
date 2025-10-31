<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function summary()
    {
        $topMonth = Sale::select(
            DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month'),
            DB::raw('SUM(quantity) as total_sales')
        )
            ->groupBy('month')
            ->orderByDesc('total_sales')
            ->first();

        $topProduct = Sale::with('product')
            ->whereMonth('sale_date', date('m', strtotime($topMonth->month)))
            ->whereYear('sale_date', date('Y', strtotime($topMonth->month)))
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->first();

        $topRegion = Sale::with('region')
            ->whereMonth('sale_date', date('m', strtotime($topMonth->month)))
            ->whereYear('sale_date', date('Y', strtotime($topMonth->month)))
            ->select('region_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('region_id')
            ->orderByDesc('total_sales')
            ->first();

        return [
            'month' => $this->formatMonth($topMonth->month),
            'total_sales' => $topMonth->total_sales,
            'top_product' => $topProduct->product->name ?? null,
            'top_region' => $topRegion->region->name ?? null,
        ];
    }

    public function getSalesByCategory()
    {
        return Sale::select(
            'products.category',
            DB::raw('SUM(sales.revenue) as total_revenue')
        )
        ->join('products', 'sales.product_id', '=', 'products.id')
        ->groupBy('products.category')
        ->get();
    }

    public function getSalesByRegion()
    {
        return
        Sale::select(
            'region_id',
            DB::raw('SUM(revenue) as total_revenue')
        )
        ->groupBy('region_id')
        ->with('region:id,name')
        ->get();
    }

    public function getTopProducts($qty = 5)
    {
        return Sale::select(
            'product_id',
            DB::raw('SUM(revenue) as total_revenue')
        )
               ->groupBy('product_id')
               ->orderByDesc('total_revenue')
               ->take($qty)
               ->with('product:id,name,category')
               ->get();
    }

    public function getSalesOverTime()
    {
        return Sale::select(
            DB::raw('DATE_FORMAT(sale_date, "%b,%y") as month'),
            DB::raw('SUM(revenue) as total_revenue')
        )
               ->groupBy('month')
               ->orderBy('month')
               ->get();
    }

    private function formatMonth($month)
    {
        return Carbon::createFromFormat('Y-m', $month)
        ->format('F, Y');
    }
}
