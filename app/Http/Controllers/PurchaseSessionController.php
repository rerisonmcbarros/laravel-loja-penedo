<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemPurchaseRequest;
use App\Models\PurchaseItemSessionHandler;
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
        return view('purchase.addItemsForm', [
            'title' => 'Penedo | Registrar Compra',
            'purchase' => $purchase
        ]);
    }

    public function addItem(AddItemPurchaseRequest $request): RedirectResponse
    {
        $itemHandler = new PurchaseItemSessionHandler();

        $itemHandler->setCode($request->get('code'));
        $itemHandler->setDescription($request->get('description'));
        $itemHandler->setPrice($request->get('price'));
        $itemHandler->setQuantity($request->get('quantity'));

        $purchaseHandler = new PurchaseSessionHandler();
        $purchaseHandler->addItem($itemHandler);

        Session::flash('message', 'Item adicionado com sucesso');

        return redirect()->route('purchases.createItems');
    }

    public function removeItem($code): RedirectResponse
    {
        $purchaseHandler = new PurchaseSessionHandler();
        if (!$purchaseHandler->hasItem($code)) {
            Session::flash('Erro, não foi possível remover, item não encontrado');
            return redirect()->route('purchases.createItems');
        }

        $purchaseHandler->removeItem($code);

        Session::flash('message', 'Item removido com sucesso');

        return redirect()->route('purchases.createItems');
    }
}
