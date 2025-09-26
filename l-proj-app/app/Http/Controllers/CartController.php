<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function get_cart()
    {
        $user = auth()->id();
        $items = Item::join('carts', 'items.id', '=', 'carts.item_id')
            ->where('carts.user_id', $user)
            ->select('items.*', 'carts.amount as cart_amount')
            ->orderBy('id', 'asc')
            ->get();
        return response()->json($items);
    }

    public function add_to_cart(Request $request)
    {
        $item_id = $request->item_id;
        $user = auth()->id();
        try {
            if (!Cart::where('user_id', $user)->where('item_id', $item_id)->exists()) {
                $cart = Cart::create([
                    'user_id' => $user,
                    'item_id' => $item_id,
                    'amount' => 1,
                ]);
                return response()->json($item_id);
            }
            else
            {
                $updated = Cart::where('user_id', $user)->where('item_id', $item_id)->increment('amount');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error increasing amount: ' . $e->getMessage()
            ], 500);
        }
        return response()->json($item_id);
    }

    public function remove_from_cart(Request $request)
    {
        $item_id = $request->item_id;
        $user = auth()->id();
        try {
            if (Cart::where('user_id', $user)->where('item_id', $item_id)->exists()) {
                $updated = Cart::where('user_id', $user)->where('item_id', $item_id)->decrement('amount');
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error decreasing amount: ' . $e->getMessage()
            ], 500);
        }
        return response()->json($item_id);
    }

    public function delete_from_cart(Request $request)
    {
        $item_id = $request->item_id;
        $user = auth()->id();
        try {
            if (Cart::where('user_id', $user)->where('item_id', $item_id)->exists()) {
                $cart = Cart::where('user_id', $user)->where('item_id', $item_id)->delete();
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error decreasing amount: ' . $e->getMessage()
            ], 500);
        }
        return response()->json($item_id);
    }

    public function get_cart_amount($ID)
    {
        $user = auth()->id();
        $items = Cart::where('user_id', $user)->where('item_id', $ID)->select('carts.amount')->get();
        return response()->json($items);
    }
}