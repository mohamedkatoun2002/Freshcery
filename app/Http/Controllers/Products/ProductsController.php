<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Models\Product\Cart;
use App\Models\Product\Order;


class ProductsController extends Controller
{
    //singleCategory
    public function singleCategory($id)
    {
        $products = Product::select()->orderBy('id', 'desc')->where('category_id', $id)->get();
        return view('products.singlecategory', compact('products'));
    }


    //singleProduct
    public function singleProduct($id)
    {
        $id = (int) $id;
        $product = Product::find($id);

        // if (!$product) {
        //     return redirect()->back()->with('error', 'Product not found');
        // }

        // Retrieve related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->get();

        if (isset(auth::user()->id)) {
            $CheckInCart = Cart::where('pro_id', $id)->where('user_id', Auth::user()->id)->count();

            return view('products.singleproduct', compact('product', 'relatedProducts', 'CheckInCart'));
        } else {
            return view('products.singleproduct', compact('product', 'relatedProducts'));
        }
    }


    //shop
    public function shop()
    {
        $categories = Category::select()->orderBy('id', 'desc')->get();

        $mostWanted = Product::select()->orderBy('name', 'desc')->limit(5)->get();

        $vegetables = Product::select()->where('item_id', 2)->orderBy('id', 'desc')->limit(5)->get();

        $meats = Product::select()->where('item_id', 4)->orderBy('id', 'desc')->limit(5)->get();

        $fishes = Product::select()->where('item_id', 1)->orderBy('id', 'desc')->limit(5)->get();

        $fruits = Product::select()->where('item_id', 3)->orderBy('id', 'desc')->limit(5)->get();

        return view('products.shop', compact('categories', 'mostWanted', 'vegetables', 'meats', 'fishes', 'fruits'));
    }


    //addToCart
    public function addToCart(Request $request)
    {
        $addCart = Cart::create([
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'image' => $request->image,
            'pro_id' => $request->pro_id,
            'user_id' => Auth::user()->id,
            'subtotal' => $request->price * $request->qty,
        ]);


        if ($addCart) {
            return Redirect::route("single.product", $request->pro_id)->with(['success' => 'Product added to cart successfully']);
        }
    }


    //cart
    public function cart()
    {
        $cartProducts = Cart::select()->where('user_id', Auth::user()->id)->get();

        $subtotal = Cart::select()->where('user_id', Auth::user()->id)->sum('subtotal');

        return view('products.cart', compact('cartProducts', 'subtotal'));
    }


    //deleteCart
    public function deleteCart($id)
    {
        $id = (int) $id;
        $deleteCart = Cart::where('id', $id)->delete();
        if ($deleteCart) {
            return redirect()->back()->with('delete', 'Product deleted from cart successfully');
        }
    }


    //prepareCheckout
    public function prepareCheckout(Request $request)
    {
        $price = $request->price;

        $value = Session::put('value', $price);

        $newPrice = Session::get($value);

        if ($newPrice > 0) {
            return Redirect::route("products.checkout");
        }
    }


    //checkout
    public function checkout()
    {
        $cartItems = Cart::select()->where('user_id', Auth::user()->id)->get();
        $checkSubtotal = Cart::select()->where('user_id', Auth::user()->id)->sum('subtotal');
        return view('products.checkout', compact('cartItems', 'checkSubtotal'));
    }


    //checkoutProcess
    public function checkoutProcess(Request $request)
    {
        $checkout = Order::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'town' => $request->town,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'email' => $request->email,
            'phone' => $request->phone,
            'price' => $request->price,
            'user_id' => $request->user_id,
            'order_notes' => $request->order_notes,
        ]);

        $value = Session::put('value', $request->price);

        $newPrice = Session::get($value);

        if ($checkout) {
            return Redirect::route("products.pay");
        }
    }


    //payWithPayPal
    public function payWithPayPal()
    {
        return view('products.payment');
    }

    //success
    public function success()
    {
        $deleteItemFromCart = Cart::where('user_id', Auth::user()->id);
        $deleteItemFromCart->delete();

        if ($deleteItemFromCart) {
            Session::forget('value');
            return view('products.success');
        }
    }
}
