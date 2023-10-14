<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order_rule;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('active', true)->get();
        $categories = Category::all();
        return view('products.index')
                ->with(compact('categories'))
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

        $request->session()->save('cart', $rule); // 2023-10-13: "push" method is replaced with "save", this should also call push-method under the hood
        return redirect()->route('cart');
    }

    public function indexSorted($category) {

        $catId = (int)$category;
        $categories = Category::all();
        $products = Product::where('category_id', '=', $catId);
        return view('categories.index')
            ->with(compact('categories'))
            ->with(compact('products'));
    }
}
