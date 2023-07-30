<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AddItemCartRequest;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(): View
    {
        Session::regenerate();  
        $cart = new Cart();

        return view('cart.form', [
            'title' => 'Penedo | Carrinho de Compras',
            'cart' => $cart ?? [],
        ]);
    }

    public function addItem(AddItemCartRequest $request): RedirectResponse
    {
        $product = Product::query()->where('code', '=', $request->get('product_code'))->first();

        if (empty($product)) {
            Session::flash('message', 'Produto não encontrado em estoque');
            return redirect()->route('cart.index');
        }

        if ($product->storage == 0 || $product->storage < $request->get('quantity')) {
            Session::flash('message', 'Não foi possível adicionar o item, estoque do produto insuficiente');
            return redirect()->route('cart.index');
        }

        $cart = new Cart();
        $cart->addItem($product, $request->get('quantity'));

        Session::flash('message', 'Produto adicionado ao Carrinho de Compras');

        return redirect()->route('cart.index');
    }

    public function removeItem($id): RedirectResponse
    {
        $cart = new Cart();

        if (!$cart->hasItem($id)) {
            Session::flash('message', 'Item não encontrado no carrinho de compras');
            return redirect()->route('cart.index');
        }

        $cart->removeItem($id);
        Session::flash('message','Item removido do carrinho');

        return redirect()->route('cart.index');
    }
}
