<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\GetSalesByPeriodSaleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sales = Sale::orderByDesc('created_at')->paginate(15);
        
        return view('sale.list', [
            'title' => 'Penedo | Lista de Vendas',
            'sales' => $sales ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $cart = new Cart();

        if (empty($cart->getItems())) {
            Session::flash('message', 'Não é possível regitrar venda com o carrinho vazio');
            return redirect()->route('cart.index');
        }

        return view('sale.createForm', [
            'title' => 'Penedo | Finalizar Venda',
            'cart' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request): RedirectResponse
    {
        $cart = new Cart();

        if (empty($cart->getItems())) {
            return redirect()->route('cart.index');
        }

        try {
            DB::beginTransaction();
            $sale = new Sale();
            $sale->client_data = $request->get('client_data');
            $sale->total_value = $cart->getTotal();
            $sale->discount = $request->get('discount');
            $sale->payment = $request->get('payment');
            $sale->setTotalValueWithDiscount();
            $sale->save();

            if (!empty($cart->getItems())) {
                foreach ($cart->getItems() as $item) {
                    $saleItem = new SaleItem();
                    $saleItem->sale_id = $sale->id;
                    $saleItem->product_code = $item->getProduct()->code;
                    $saleItem->product_description = $item->getProduct()->description;
                    $saleItem->item_price = $item->getProduct()->sale_price;
                    $saleItem->quantity = $item->getQuantity();
                    $saleItem->save();

                    $item->getProduct()->reduceStorage($item->getQuantity());

                    unset($saleItem);
                }
            }

            DB::commit();

            $cart->reset();
            Session::flash('message', 'Venda Registrada com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, falha ao registrar venda');
            DB::rollBack();
        }

        return redirect()->route('sales.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $sale = Sale::query()->with('items')->findOrFail($id);

        return view('sale.details', [
            'title' => 'Penedo | Detalhes da Venda',
            'sale' => $sale ?? null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $sale = Sale::query()->findOrFail($id);

        try {
            DB::beginTransaction();
            
            $sale->delete();
           
            DB::commit();
            Session::flash('message', 'Venda removida com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, falha ao remover registro de venda');
            DB::rollBack();
        }

        return redirect()->route('sales.index');
    }

    public function getSalesByPeriod(GetSalesByPeriodSaleRequest $request): View|RedirectResponse
    {
        $sales = Sale::query()
        ->whereDate('created_at', '>=', $request->get('data_inicio'))
        ->whereDate('created_at', '<=', $request->get('data_fim'))
        ->orderByDesc('created_at')->paginate(15);

        if ($sales->total() < 1) {
            Session::flash('message', 'Nenhuma venda encontrada para o período informado');
            return redirect()->route('sales.index');
        }

        $sales->appends([
            'data_inicio' => $request->get('data_inicio'),
            'data_fim' => $request->get('data_fim'),
        ]);

        $message = "Vendas encontradas para o período informado";

        return view('sale.list', [
            'title' => 'Penedo | Vendas por Período',
            'sales' => $sales ?? [],
            'message' => $message ?? null
        ]);
    }
}
