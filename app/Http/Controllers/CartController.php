<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // Add Product to cart
    public function addToCart(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'quantity' => 'required|numeric',
            'size' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'session_id' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Failed to add product to cart",
                'errors' => $validate->errors(),
            ], 400);
        }
        // check if product exists in the cart already
        $cartItem = CartItem::where('product_id', $request->product_id)->first();
        if ($cartItem) {
            // Update quantity if product exists
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => $request->id ?? null,
                'session_id' => $request->session_id ?? null,
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity,
            ]);
        }


        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cartItem
        ], 200);
    }

    // View all product in the cart
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'session_id' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Failed to fetch cart items",
                'errors' => $validate->errors(),
            ], 400);
        }
        $cartInfo = CartItem::with('product')->where(function ($query) use ($request) {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            } else {
                $query->where('session_id', $request->session_id);
            }
        })->get();
        return response()->json([
            'message' => 'Cart items fetched successfully!',
            'cart_items' => $cartInfo
        ], 200);
    }
    // Remove product from cart
    public function removeFromCart(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'session_id' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Failed to delete cart item",
                'errors' => $validate->errors(),
            ], 400);
        }
        $cartItem = CartItem::where('id', $id)->where(function ($query) use ($request) {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            } else {
                $query->where('session_id', $request->session_id);
            }
        })->first();
        if (!$cartItem) {
            return response()->json([
                'message' => 'Cart item not found!',
            ], 404);
        }
        $cartItem->delete();
        return response()->json([
            'message' => 'Cart item removed successfully!',
        ], 200);
    }
}
