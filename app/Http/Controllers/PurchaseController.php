<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PurchaseSessionHandler;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\GetPurchasesByPeriodRequest;

class PurchaseController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        try {
            $purchases = Purchase::orderByDesc('id')->paginate(15);
        } catch (Exception $e) {
            $message = 'Erro, não foi possível obter a lista de Compras';
        }
        return view('purchase.list', [
            'title' => 'Penedo | Lista de Compras',
            'purchases' => $purchases ?? [],
            'message' => $message ?? null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        try {
     
            $purchaseSessionHandler = new PurchaseSessionHandler();

            if (empty($purchaseSessionHandler->getItems())) {
                Session::flash('message', 'Não é possível registrar uma compra sem itens');
                return redirect()->route('purchases.create');
            }

            DB::beginTransaction();
            $purchase = new Purchase();
            $purchase->supplier = $request->get('supplier');
            $purchase->invoice = $request->get('invoice');
            $purchase->description = $request->get('purchase_description');
            $purchase->total_value = $purchaseSessionHandler->getTotal();
            $purchase->save();
            
            foreach ($purchaseSessionHandler->getItems() as $item) {
                $purchaseItem = new PurchaseItem();
                $purchaseItem->purchase_id = $purchase->id;
                $purchaseItem->code = $item->getCode();
                $purchaseItem->description = $item->getDescription();
                $purchaseItem->price = $item->getPrice();
                $purchaseItem->quantity = $item->getQuantity();
                $purchaseItem->save();
            }

            Session::flash('message', 'Compra registrada com sucesso');
            $purchaseSessionHandler->reset();
            DB::commit();

        } catch (Exception $e) { 
            Session::flash('message', 'Erro, Não foi possível fazer o registro de compra');
            DB::rollBack();
            return redirect()->route('purchases.create'); 
        }
        
        return redirect()->route('purchases.create'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse|View
    {
        try {
            $purchase = Purchase::query()->where('id', $id)->with('items')->first();
            if (empty($purchase)) {
                Session::flash('message','Não foi possível mostrar os detalhes, compra não encontrada');
                return redirect()->route('purchases.index');
            }

        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível mostrar os detalhes da compra');
            return redirect()->route('purchases.index');
        }

        return view('purchase.details', [
            'title' => 'Penedo | Detalhes da Compra',
            'purchase' => $purchase
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $purchase = Purchase::find($id);

            if (empty($purchase)) {
                Session::flash('message', 'Não foi possível remover, compra não encontrada');
                return redirect()->route('purchases.index');
            }
            DB::beginTransaction();
            
            $purchase->delete();

            Session::flash('message', 'Registro de compra removido com sucesso');

            DB::commit();
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível remover registro');
            return redirect()->route('purchases.index');
        } 
        
        return redirect()->route('purchases.index');
    }
    
    public function getPurchasesByPeriod(GetPurchasesByPeriodRequest $request): RedirectResponse|View
    {
        try {
            $purchases = Purchase::query()
            ->whereDate('created_at', '>=', $request->get('data_inicio'))
            ->whereDate('created_at', '<=', $request->get('data_fim'))
            ->orderByDesc('created_at')->paginate(15);

            if ($purchases->total() < 1) {
                Session::flash('message', 'Nenhuma compra encontrada para o período informado');
                return redirect()->route('purchases.index');
            }

            $purchases->appends([
                'data_inicio' => $request->get('data_inicio'),
                'data_fim' => $request->get('data_fim'),
            ]);

            $message = "Compras encontradas para o período informado";
        } catch (Exception $e) {
           Session::flash('message', 'Erro, não foi possível realizar a solicitação');
           return redirect()->route('purchases.index');
        }

        return view('purchase.list', [
            'title' => 'Penedo | Compras por Período',
            'purchases' => $purchases ?? [],
            'message' => $message ?? null
        ]);
    }
}
