<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function checkout()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = $this->cart->items();
        $total = $this->cart->total();
        $user  = auth()->user();

        return view('orders.checkout', compact('items', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city'    => 'required|string|max:100',
            'shipping_state'   => 'required|string|max:100',
            'shipping_zip'     => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);

        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $this->cart->total();
        $items = $this->cart->items();

        DB::transaction(function () use ($request, $total, $items, &$order) {
            $order = Order::create([
                'user_id'          => auth()->id(),
                'status'           => Order::STATUS_PENDING,
                'subtotal'         => $total['subtotal'],
                'tax'              => $total['tax'],
                'shipping'         => $total['shipping'],
                'total'            => $total['total'],
                'shipping_name'    => $request->shipping_name,
                'shipping_email'   => $request->shipping_email,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'shipping_state'   => $request->shipping_state,
                'shipping_zip'     => $request->shipping_zip,
                'shipping_country' => $request->shipping_country,
                'notes'            => $request->notes,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id'   => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price'        => $item['product']->current_price,
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // Reduce stock
                $item['product']->decrement('stock', $item['quantity']);
            }
        });

        $this->cart->clear();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }
}
