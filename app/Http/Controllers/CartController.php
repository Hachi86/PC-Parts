<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index()
    {
        $items = $this->cart->items();
        $total = $this->cart->total();
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'integer|min:1|max:99']);

        if (!$product->isInStock()) {
            return back()->with('error', 'This product is out of stock.');
        }

        $qty = $request->get('quantity', 1);

        if ($qty > $product->stock) {
            return back()->with('error', "Only {$product->stock} units available.");
        }

        $this->cart->add($product, $qty);

        return back()->with('success', "\"{$product->name}\" added to cart!");
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $qty = $request->quantity;

        if ($qty > $product->stock) {
            return back()->with('error', "Only {$product->stock} units available.");
        }

        $this->cart->update($product->id, $qty);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product->id);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cart->clear();
        return back()->with('success', 'Cart cleared.');
    }
}
