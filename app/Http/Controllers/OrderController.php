<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_rule;
use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\Size;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cart(Request $request)
    {
        $cart = $this->getCart();
        if(!$cart) return redirect()->route('shop');
        return view('orders.cart')
                ->with(compact('cart'));
    }

    public function remove($key, Request $request)
    {
        $cart = session('cart');
        unset($cart[$key]);
        session(['cart' => $cart]);
        return redirect()->route('cart');
    }

    public function order()
    {
        $cart = $this->getCart();
        return view('orders.order')
                ->with(compact('cart'));
    }

    public function pay(Request $request)
    {
        $request->session()->reflash();
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $order = new Order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->speltak = $request->speltak;
        $order->save();

        $amount = 0;
        foreach($this->getCart() as $rule)
        {
            $order_rule = new Order_rule();
            $order_rule->order_id = $order->id;
            $order_rule->product = $rule->product->title;
            $order_rule->type = $rule->type->title;
            $order_rule->description = $rule->type->description;
            $order_rule->size = $rule->size->title;
            $order_rule->price = $rule->product->price;
            $order_rule->save();
            $amount += $rule->product->price;
        }

        $order->amount = $amount;
        $order->slug = sprintf("%02d%03d", rand(10,99), $order->id);
        $order->save();

        $request->session()->pull('cart');
        return redirect()->route('ideal.pay', $order);
    }

    public function show(Order $order, $slug)
    {
        if($order->slug != $slug) return redirect()->route('shop');
        return view('orders.show')
            ->with(compact('order'));
    }

    public function cancel(Order $order, $slug)
    {
        if($order->slug != $slug) return redirect()->route('shop');
        $order->delete();

        session()->flash('status', ['success', 'Bestelling geannuleerd!']);
        return redirect()->route('shop');
    }


    private function getCart()
    {
        $cart = session('cart');
        if(empty($cart)) {
            return false;
        } 
        foreach ($cart as $key => $rule)
        {
            if(!($cart[$key]->type instanceof Type))
            {
                $cart[$key]->type = Type::find($cart[$key]->type);
            }
            if(!($cart[$key]->size instanceof Size))
            {
                $cart[$key]->size = Size::find($cart[$key]->size);
            }
        }

        return $cart;
    }
}
