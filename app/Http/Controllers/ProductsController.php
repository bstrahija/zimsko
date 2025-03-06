<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Team;
use App\Services\Helpers;
use App\Services\Leaderboards;
use App\Stats\Stats;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    public function order(Order $order, Request $request)
    {
        $orders = $request->input('orders', []);
        // dump($order->toArray());
        // dump($order->orderItems->toArray());
        // dump($request->all());
        // dd($orders);

        return view('products.show', compact('order'));
    }

    public function createOrder(Request $request)
    {
        return back()->with('success', 'Poruka je poslana!');
    }

    public function orders()
    {
        $products = Product::all();
        $summary  = [];
        $orders   = Order::orderBy('first_name')
            ->with(['orderItems', 'orderItems.product'])
            ->where('status', 'confirmed')
            ->orWhere('status', 'completed')
            ->get();

        foreach ($products as $product) {
            $items = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->where('status', 'confirmed')
                        ->orWhere('status', 'completed');
                })
                ->with('order')
                ->get()
                ->groupBy('variation')
                ->map(function ($group) {
                    return $group->sum('quantity');
                });

            $summary['product_' . $product->id] = [
                'product' => $product,
                'items'   => $items
            ];
        }

        // Let's also get number of votes for teams
        $votes = Order::select('team_id', \DB::raw('count(*) as count'))
            ->with('team')
            ->whereNotNull('team_id')
            ->where(function ($query) {
                $query->where('status', 'confirmed')
                    ->orWhere('status', 'completed');
            })
            ->groupBy('team_id')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'count' => $order->count,
                    'title' => $order->team->title,
                    'team_id' => $order->team_id,
                    'team' => $order->team
                ];
            });

        return view('products.orders', [
            'orders'  => $orders,
            'summary' => $summary,
            'votes'   => $votes
        ]);
    }
}
