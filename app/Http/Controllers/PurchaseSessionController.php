<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemPurchaseRequest;
use App\Models\PurchaseItemSessionHandler;
use Exception;
use App\Models\PurchaseSessionHandler;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class PurchaseSessionController extends Controller
{
    public function create(): View
    {
        Session::regenerate();
        $purchase = new PurchaseSessionHandler();
        return view('purchase.createForm', [
            'title' => 'Penedo | Registrar Compra',
            'purchase' => $purchase
        ]);
    }

    public function addItem(AddItemPurchaseRequest $request): RedirectResponse
    {
        try {

            $itemHandler = new PurchaseItemSessionHandler();

            $itemHandler->setCode($request->get('code'));
            $itemHandler->setDescription($request->get('description'));
            $itemHandler->setPrice($request->get('price'));
            $itemHandler->setQuantity($request->get('quantity'));

            $purchaseHandler = new PurchaseSessionHandler();

            $purchaseHandler->addItem($itemHandler);

            $message = 'Item adicionado com sucesso';
            
        } catch (Exception $e) {
            $message = 'Erro, Não foi possível adicionar o item à compra';
        }

        Session::flash('message', $message);

        return redirect()->route('purchases.create');
    }

    public function removeItem($code): RedirectResponse
    {
        try {
            $purchaseHandler = new PurchaseSessionHandler();
            if (!$purchaseHandler->hasItem($code)) {
                throw new Exception('Erro, não foi possível remover, item não encontrado');
            }

            $purchaseHandler->removeItem($code);

            $message = 'Item removido com sucesso';

        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        Session::flash('message', $message);

        return redirect()->route('purchases.create');
    }
}
