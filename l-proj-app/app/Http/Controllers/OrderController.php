<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function get_orders()
    {
        $user = auth()->id();
        $orders = Order::Cart::where('user_id', $user)->get();
        return response()->json($orders);
    }

    public function place_order(Request $request)
    {
        $total = $request->total;
        $user = auth()->id();
        
        $items = Item::join('carts', 'items.id', '=', 'carts.item_id')
            ->where('carts.user_id', $user)
            ->select('items.*', 'carts.amount as cart_amount')
            ->orderBy('id', 'asc')
            ->get();

        if ($items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot create order: Cart is empty'
                ], 400);
            }

        $order = Order::create([
                'user_id' => $user,
                'total' => $total,
                'status' => 'pending'
            ]);

        $orderItems = [];
        foreach ($items as $cartItem) {
            $unitPrice = $cartItem->price;
            $totalPrice = $cartItem->cart_amount * $unitPrice;

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->id,
                'amount' => $cartItem->cart_amount
            ]);

            $orderItems[] = $orderItem;
        }

        Cart::where('user_id', $user)->delete();

        return response()->json($order);
    }
}