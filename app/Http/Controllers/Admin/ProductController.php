<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;




class ProductController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.products.index')
                ->with(compact('products'))
                ->with(compact('categories'));

                
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return view('admin.products.create')                
                    ->with(compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'active' => 'required|boolean',
            'leiding' => 'required|boolean',
            'image' => 'nullable|image',
            'description' => 'nullable'
        ]);

        $product = new Product();
        $product->title = $request->title; 
        $product->price = $request->price;
        $product->active = $request->active;
        $product->leiding = $request->leiding;
        $product->description = $request->description;
        $product->category_id = $request->category;
        if($request->hasFile('image'))
        {
            $product->image = $request->image->store('img');
        }
        $product->save();
        return redirect()->route('admin.products.types', $product);
    }

    public function types(Product $product)
    {
        return view('admin.products.types')
                ->with(compact('product'));
    }

    public function types_create(Product $product)
    {
        return view('admin.products.types_create')
                ->with(compact('product'));
    }

    public function types_store(Product $product, Request $request)
    {
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'required',
            'sizes' => 'required'
        ]);
        
        $type = new Type();
        $type->title = $request->title;
        $type->description = $request->description;
        $product->types()->save($type);

        $sizes = collect(explode(',', $request->sizes))
        ->map(function($size){
            return strtoupper(trim($size));
        })
        ->reject(function($size){
            return (empty($size) || is_null($size));
        })
        ->each(function($size) use($type){
            $type->sizes()->create([
                'title' => $size
            ]);
        });

        return redirect()->route('admin.products.types', $product);

    }

    public function types_delete(Product $product, Type $type)
    {
        $type->delete();
        return redirect()->route('admin.products.types', $product);
    }    

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit')
                ->with(compact('product'))
                ->with(compact('categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate(request(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'discount'=>'required|numeric',
            'active' => 'required|boolean',
            'leiding' => 'required|boolean',
            'image' => 'nullable|image',
            'description' => 'nullable'
        ]);

        $product->title = $request->title; 
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->active = $request->active;
        $product->leiding = $request->leiding;
        $product->description = $request->description;
        $product->category_id = $request->category;
        if($request->hasFile('image'))
        {
            $product->image = $request->image->store('img');
        }
        $product->save();
        return redirect()->route('admin.products.index', $product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}
