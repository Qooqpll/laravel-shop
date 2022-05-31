<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket(Request $request)
    {
        $order = null;
        $orderId = session('orderId');

        if (!is_null($orderId)) {

            $order = Order::findOrFail($orderId);

        }

        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');

        if (is_null($orderId)) {

            redirect()->route('index');

        }

        $order = Order::find($orderId);
        $success = $order->saveOrder($request->name, $request->phone);

        if($success) {

            session()->flash('success', 'Ваш заказ принят в обработку');

        } else {

            session()->flash('warning ', 'Произошла ошибка');

        }

        Order::eraseOrderSum();

        return redirect()->route('index');
    }

    public function basketPlace()
    {
        $orderId = session('orderId');

        if (is_null($orderId)) {

            redirect()->route('index');

        } else {

            $order = Order::find($orderId);

        }

        return view('order', compact('order'));
    }

    public function basketAdd(Request $request, $productId = null)
    {

        $orderId = session('orderId');

        if (is_null($orderId)) {

            $order = Order::create();
            session(['orderId' => $order->id]);

        } else {

            $order = Order::find($orderId);

        }

        if ($order->products->contains($productId)) {

            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();

        } else {

            $order->products()->attach($productId);

        }

        if(Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }

        $product = Product::find($productId);

        Order::changeFullSum($product->price);

        session()->flash('success', 'Товар добавлен ' . $product->name);

        return redirect()->route('basket');
    }

    public function basketRemove($productId = null)
    {
        $orderId = session('orderId');

        if (is_null($orderId)) {

            return redirect()->route('basket');

        }

        $order = Order::find($orderId);

        if ($order->products->contains($productId)) {

            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;

            if ($pivotRow->count < 2) {

                $order->products()->detach($productId);

            } else {

                $pivotRow->count--;
                $pivotRow->update();

            }
        }

        $product = Product::find($productId);

        Order::changeFullSum(-$product->price);

        session()->flash('warning', 'Товар удалён ' . $product->name );

        return redirect()->route('basket');
    }
}