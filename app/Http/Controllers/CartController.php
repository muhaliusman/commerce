<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cart');
    }

    /**
     * Get total data in cart cachew
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductsInCart()
    {
        $dataInCart = Cache::get('cart') ?? [];
        $prodIds = array_column($dataInCart, 'product_id');

        // get the latest product prices. the price is taken from the latest not from the data when the product is loaded into the cart
        $products = Product::select('id', 'price', 'name')
            ->whereIn('id', $prodIds)
            ->get()
            ->toArray();

        foreach($dataInCart as $index => $item) {
            foreach($products as $product) {
                if ($product['id'] == $item['product_id']) {
                    $dataInCart[$index]['price'] = $product['price'];
                    $dataInCart[$index]['name'] = $product['name'];
                    continue;
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'products' => $dataInCart
        ], Response::HTTP_OK);
    }

    /**
     * Get total data in cart cachew
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotal()
    {
        $dataInCart = Cache::get('cart');
        $totalInCart = $dataInCart ? count($dataInCart) : 0;

        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'total' => $totalInCart
        ], Response::HTTP_OK);
    }

    /**
     * Store a product to cart
     *
     * $cache = [
     *      [
     *          product_id => 1
     *          qty => 3
     *          'discount_id' => 2
     *          'discount_code' => COVID19
     *          'discount_percentage' => 100
     *      ]
     * ]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = $request->product;

        $product = Product::findOrFail($productId);
        // use global cache because there is no auth feature
        $cart = Cache::get('cart') ?? [];
        // search product in cart
        $idxProd = array_search($product->id, array_column($cart, 'product_id'));
        if ($idxProd === false) {
            $cart[] = [
                'product_id' => $product->id,
                'qty' => 1,
                'discount_id' => null,
                'discount_code' => null,
                'discount_percentage' => 0
            ];
        } else {
            $cart[$idxProd]['qty'] += 1;
        }

        Cache::forever('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product successfully stored in cart'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update product qty in cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function updateQty(Request $request, $productId)
    {
        $cart = Cache::get('cart') ?? [];
        $newQty = $request->qty ?? 0;
        if (!is_numeric($newQty)) {
            return response()->json([
                'success' => true,
                'message' => 'QTY must a numeric value'
            ], Response::HTTP_BAD_REQUEST);
        }
        // search product in cart
        $idxProd = array_search($productId, array_column($cart, 'product_id'));
        if ($idxProd === false) {
            return response()->json([
                'success' => true,
                'message' => 'Product not available in the cart'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            $cart[$idxProd]['qty'] = $newQty;
        }

        Cache::forever('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Qty of product successfully updated'
        ], Response::HTTP_OK);
    }

    /**
     * Update product qty in cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function updateDiscount(Request $request, $productId)
    {
        $cart = Cache::get('cart') ?? [];
        $discountCode = $request->discount_code ?? 0;
        if (!$discount = Discount::where('discount_code', $discountCode)->first()) {
            return response()->json([
                'success' => true,
                'message' => 'Discount code not found'
            ], Response::HTTP_BAD_REQUEST);
        }
        // search product in cart
        $idxProd = array_search($productId, array_column($cart, 'product_id'));
        if ($idxProd === false) {
            return response()->json([
                'success' => true,
                'message' => 'Product not available in the cart'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            $cart[$idxProd]['discount_id'] = $discount->id;
            $cart[$idxProd]['discount_code'] = $discount->discount_code;
            $cart[$idxProd]['discount_percentage'] = $discount->discount_percentage;
        }

        Cache::forever('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Discount code successfully applied'
        ], Response::HTTP_OK);
    }

    /**
     * Remove product from cart
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $cart = Cache::get('cart') ?? [];
        // search product in cart
        $idxProd = array_search($productId, array_column($cart, 'product_id'));
        if ($idxProd === false) {
            return response()->json([
                'success' => true,
                'message' => 'Product not available in the cart'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            unset($cart[$idxProd]);
            $cart = array_values($cart);
        }

        Cache::forever('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product successfully deleted from cart'
        ], Response::HTTP_CREATED);
    }
}
