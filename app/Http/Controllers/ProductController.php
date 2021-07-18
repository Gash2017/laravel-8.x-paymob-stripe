<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('products.index',compact('products'));
    }

    public function addToCart(Product $product)
    {
        if(session()->has('cart'))
        {
            $cart  = new Cart(session()->get('cart'));

        }
        else
        {
            $cart = new Cart();

        }
        $cart->add($product);
         //dd($cart);
         session()->put('cart', $cart);
         return redirect()->route('products')->with('success', 'Product was added');
    }
    public function showCart() {

        if (session()->has('cart')) {
            $cart = new Cart(session()->get('cart'));
        } else {
            $cart = null;
        }

        return view('cart.show', compact('cart'));
    }

    public function checkout($amount)
    {

        return view('cart.checkout', compact('amount'));

    }

    public function checkout1()
    {

        return redirect()->route( 'pay' );

    }

    public function charge(Request $request) {

        //dd($request->stripeToken);
        $charge = Stripe::charges()->create([
            'currency' => 'USD',
            'source' => $request->stripeToken,
            'amount'   => $request->amount,
            'description' => ' Test from laravel new app'
        ]);

        $chargeId = $charge['id'];

        if ($chargeId) {
            // save order in orders table ...

            auth()->user()->orders()->create([
                'cart' => serialize( session()->get('cart'))
            ]);
            // clearn cart

            session()->forget('cart');
            return redirect()->route('store')->with('success', " Payment was done. Thanks");
        } else {
            return redirect()->back();
        }
    }    public function create()
    {


    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);

        $cart = new Cart(session()->get('cart'));
        $cart->updateQty($product->id, $request->qty);
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $cart = new Cart( session()->get('cart'));
        $cart->remove($product->id);

        if( $cart->totalQty <= 0 ) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Product was removed');
    }
}