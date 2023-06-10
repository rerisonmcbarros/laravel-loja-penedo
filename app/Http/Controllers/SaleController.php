<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\getSalesByPeriodSaleRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sales = Sale::orderByDesc('created_at')->paginate(15);
        } catch (Exception $e) {
            $message = "Erro, não foi possível obter a lista de Vendas";
        }

        return view('sale.list', [
            'title' => 'Penedo | Lista de Vendas',
            'sales' => $sales ?? [],
            'message' => $message ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = new Cart();

        if (empty($cart->getItems())) {
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
    public function store(StoreSaleRequest $request)
    {
        try {
            $cart = new Cart();

            if (empty($cart->getItems())) {
                return redirect()->route('cart.index');
            }

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

            $cart->reset();
            $message = 'Venda Registrada com sucesso!';
            DB::commit();

        } catch (Exception $e) {
            $message = 'Erro, falha ao registrar venda!';
            DB::rollBack();
        }

        Session::flash('message', $message);

        return redirect()->route('cart.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $sale = Sale::query()->with('items')->find($id);

            if (empty($sale)) {
                throw new Exception('Não foi possível obter os detalhes da venda.');
            }

        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            return redirect()->route('sales.index');
        }

        return view('sale.details', [
            'title' => 'Penedo | Detalhes da Venda',
            'sale' => $sale ?? null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $sale = Sale::query()->find($id);

            if (empty($sale)) {
                throw new Exception('Não foi possível remover a venda da lista');
            }

            $sale->delete();
           
            $message = 'Venda removida com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = $e->getMessage();
            DB::rollBack();
        }

        Session::flash('message', $message);

        return redirect()->route('sales.index');
    }

    public function getSalesByPeriod(getSalesByPeriodSaleRequest $request)
    {
        try {
            $sales = Sale::query()
            ->whereDate('created_at', '>=', $request->get('data_inicio'))
            ->whereDate('created_at', '<=', $request->get('data_fim'))
            ->orderByDesc('created_at')->paginate(1);

            if (count($sales->items()) < 1) {
                throw new Exception('Nenhuma venda encontrada para o período informado');
            }

            $sales->appends([
                'data_inicio' => $request->get('data_inicio'),
                'data_fim' => $request->get('data_fim'),
            ]);

            $message = "Vendas encontradas para o período informado.";
        } catch (Exception $e) {
           Session::flash('message', $e->getMessage());
           return redirect()->route('sales.index');
        }

        return view('sale.list', [
            'title' => 'Penedo | Vendas por Período',
            'sales' => $sales ?? [],
            'message' => $message ?? null
        ]);
    }
}
