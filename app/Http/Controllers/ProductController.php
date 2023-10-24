<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order_rule;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('active', true)->get();
        $categories = Category::all();
        return view('products.index')
                ->with(compact('products'))
                ->with(compact('categories'));
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

        $request->session()->save('cart', $rule);
        return redirect()->route('cart');
    }

    public function tocategory($category) {

        $products = Product::where('category_id', '=', $category)->get();
        $categories = Category::all();

        return view('products.sorted')
            ->with('category', $category)
            ->with('categories', $categories)
            ->with('products', $products);
    }


}
