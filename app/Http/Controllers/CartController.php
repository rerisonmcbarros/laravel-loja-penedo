<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\addItemCartRequest;

class CartController extends Controller
{
    public function index()
    {
        Session::regenerate();  
        $cart = new Cart();

        return view('cart.form', [
            'title' => 'Penedo | Carrinho de Compras',
            'cart' => $cart ?? [],
        ]);
    }

    public function addItem(addItemCartRequest $request)
    {
        try {

            $product = Product::query()->where('code', '=', $request->get('product_code'))->first();

            if (empty($product)) {
                throw new Exception('Produto não encontrado em estoque!');
            }

            if ($product->storage == 0 || $product->storage < $request->get('quantity')) {
                throw new Exception('Não foi possível adicionar o item, estoque do produto insuficiente!');
            }

            $cart = new Cart();
            $cart->addItem($product, $request->get('quantity'));

            $message = 'Produto adicionado ao Carrinho de Compras!';

        } catch (PDOException $e) {
            $message = 'Erro, ao adicionar produto ao Carrinho de Compras!';    
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        
        Session::flash('message', $message);

        return redirect()->route('cart.index');
    }

    public function removeItem($id)
    {
        try {
            $cart = new Cart();

            if (!$cart->hasItem($id)) {
                throw new Exception('Erro, item não encontrado no carrinho de compras');
            }

            $cart->removeItem($id);
        } catch (Exception $e) {
            $message = $e->getMessage();
            Session::flash('message', $message);
        }

        return redirect()->route('cart.index');
    }
}
