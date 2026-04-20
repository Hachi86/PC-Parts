<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function items(): Collection
    {
        $cart     = Session::get(self::SESSION_KEY, []);
        $ids      = array_keys($cart);
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');

        return collect($cart)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);
            if (!$product) return null;

            return [
                'product'  => $product,
                'quantity' => $quantity,
                'subtotal' => $product->current_price * $quantity,
            ];
        })->filter()->values();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;
        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = Session::get(self::SESSION_KEY, []);
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    public function remove(int $productId): void
    {
        $cart = Session::get(self::SESSION_KEY, []);
        unset($cart[$productId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return array_sum(Session::get(self::SESSION_KEY, []));
    }

    public function subtotal(): float
    {
        return $this->items()->sum('subtotal');
    }

    public function tax(float $rate = 0.20): float
    {
        return round($this->subtotal() * $rate, 2);
    }

    public function shipping(): float
    {
        return $this->subtotal() >= 100 ? 0.0 : 9.99;
    }

    public function total(): array
    {
        $subtotal = $this->subtotal();
        $tax      = $this->tax();
        $shipping = $this->shipping();

        return [
            'subtotal' => $subtotal,
            'tax'      => $tax,
            'shipping' => $shipping,
            'total'    => $subtotal + $tax + $shipping,
        ];
    }

    public function isEmpty(): bool
    {
        return empty(Session::get(self::SESSION_KEY, []));
    }
}
