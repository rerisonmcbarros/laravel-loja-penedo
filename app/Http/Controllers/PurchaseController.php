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
        $purchases = Purchase::orderByDesc('id')->paginate(15);

        return view('purchase.list', [
            'title' => 'Penedo | Lista de Compras',
            'purchases' => $purchases ?? [],
        ]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $purchaseSessionHandler = new PurchaseSessionHandler();
    
        if (empty($purchaseSessionHandler->getItems())) {
            Session::flash('message', 'Não é possível registrar uma compra sem itens');
            return redirect()->route('purchases.createItems');
        }

        return view('purchase.createForm', [
            'title' => 'Penedo | Registrar Compra',
            'purchase' => $purchaseSessionHandler
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        $purchaseSessionHandler = new PurchaseSessionHandler();

        if (empty($purchaseSessionHandler->getItems())) {
            Session::flash('message', 'Não é possível registrar uma compra sem itens');
            return redirect()->route('purchases.createItems');
        }

        try {
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

            DB::commit();
            
            Session::flash('message', 'Compra registrada com sucesso');
            $purchaseSessionHandler->reset();

        } catch (Exception $e) { 
            Session::flash('message', 'Erro, Não foi possível fazer o registro de compra');
            DB::rollBack();
            return redirect()->route('purchases.createItems'); 
        }
        
        return redirect()->route('purchases.createItems'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse|View
    {
        $purchase = Purchase::query()->where('id', $id)->with('items')->firstOrfail();

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
        $purchase = Purchase::query()->findOrFail($id);

        try {
            DB::beginTransaction();
            
            $purchase->delete();

            DB::commit();
            Session::flash('message', 'Registro de compra removido com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('message', 'Erro, não foi possível remover registro');
            return redirect()->route('purchases.index');
        } 
        
        return redirect()->route('purchases.index');
    }
    
    public function getPurchasesByPeriod(GetPurchasesByPeriodRequest $request): RedirectResponse|View
    {
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
        
        return view('purchase.list', [
            'title' => 'Penedo | Compras por Período',
            'purchases' => $purchases ?? [],
            'message' => $message ?? null
        ]);
    }
}
