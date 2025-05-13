<?php

namespace App\Http\Controllers;

use App\Models\myCart; // ✅ 引入模型
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    // ✅ 添加购物车
    public function addCart()
    {
        $r = request();

        $add = myCart::create([
            'productID' => $r->productID,
            'quantity' => $r->quantity,
            'userID' => Auth::id(), // ✅ 已经过滤
            'dateAdd' => now(),
            'orderID' => null
        ]);

        return redirect()->route('myCart');
    }

    // ✅ 显示购物车
    public function view()
    {
        $cart = DB::table('my_carts')
            ->leftJoin('products', 'products.id', '=', 'my_carts.productID')
            ->select('my_carts.quantity as cartQty', 'my_carts.id as cid', 'products.*')
            ->where('my_carts.userID', '=', Auth::id())
            ->whereNull('my_carts.orderID') // ✅ 确保检查 NULL
            ->get();

        $this->cartItem();  // ✅ 正常调用
        return view('myCart')->with('cart', $cart);
    }

    // ✅ 购物车项目计数
    public function cartItem()
    {
        $cartItem = 0;

        $noItem = DB::table('my_carts')
            ->leftJoin('products', 'products.id', '=', 'my_carts.productID')
            ->select(DB::raw('COUNT(*) as count_item'))
            ->whereNull('my_carts.orderID') // ✅ 检查 NULL
            ->where('my_carts.userID', '=', Auth::id())
            ->groupBy('my_carts.userID')
            ->first();

        if ($noItem) {
            $cartItem = $noItem->count_item;
        }
        
        // ✅ 使用 Session::put
        Session::put('cartItem', $cartItem);
    }
}
