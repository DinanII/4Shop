<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order_rule;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('active', true)->get();
        $categories = Category::all();
        return view('products.index')
                ->with(compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show')
                ->with(compact('product'));
    }

    public function order(Product $product, Request $request)
    {
        $rule = new Order_rule();
        $rule->product = $product;
        $rule->type = $request->type;
        $rule->size = $request->size;

        $request->session()->push('cart', $rule);
        return redirect()->route('cart');
    }
}
