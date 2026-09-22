<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('status', '!=', Order::STATUS_CANCELLED)->sum('total'),
            'total_products'  => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders'  => Order::where('status', Order::STATUS_PENDING)->count(),
            'low_stock'       => Product::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'out_of_stock'    => Product::where('stock', 0)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $topProducts = DB::table('order_items')
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as revenue'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $monthlySales = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total')
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->whereYear('created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'monthlySales'));
    }
}
