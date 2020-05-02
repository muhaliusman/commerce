<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = OrderItem::orderBy('created_at', 'asc')->get();

        return view('pages.orders', compact('orders'));
    }

    /**
     * Store data in cart to DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cache::get('cart');
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'No data in cart'
            ], Response::HTTP_BAD_REQUEST);
        }

        // store data to order item DB
        foreach($cart as $value) {
            if ($product = Product::find($value['product_id'])) {
                $totalPrice = $product->price * $value['qty'];
                $priceDisc = 0;
                if ($discount = Discount::find($value['discount_id'])) {
                    $priceDisc = $discount->discount_percentage / 100 * $totalPrice;
                }

                OrderItem::create([
                    'product_id' => $value['product_id'],
                    'discount_id' => $value['discount_id'],
                    'qty' => $value['qty'],
                    'price' => $product->price,
                    'discount_value' => $priceDisc
                ]);
            }
        }

        Cache::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Order successfully processed'
        ], Response::HTTP_CREATED);
    }
}
