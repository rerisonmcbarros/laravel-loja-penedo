<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::all();
        $products = Product::orderBy('description')->paginate(15);

        return view('product.list', [
            'title' => 'Penedo | Lista de Produtos',
            'products' => $products ?? [],
            'categories' => $categories ?? [],
            'selected' => null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $categories = Category::all();

        return view('product.createForm', [
            'title' => 'Penedo | Cadastrar Produto',
            'categories' => $categories ?? [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $product = new Product();
            $product->category_id = $request->get('category_id');
            $product->code = $request->get('code');
            $product->description = $request->get('description');
            $product->purchase_price = $request->get('purchase_price');
            $product->sale_price = $request->get('sale_price');
            $product->storage = $request->get('storage');
            $product->save();

            DB::commit();
            Session::flash('message', 'Produto cadastrado com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, Não foi possível cadastrar o produto');
            DB::rollBack();
        }

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $product = Product::query()->where('id', $id)->with('category')->firstOrFail();
        $categories = Category::all();

        return view('product.editForm', [
            'title' => 'Penedo | Editar Produto',
            'product' => $product ?? null,
            'categories' => $categories ?? [],
        ]);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $product->category_id = $request->get('category_id');
            $product->code = $request->get('code');
            $product->description = $request->get('description');
            $product->purchase_price = $request->get('purchase_price');
            $product->sale_price = $request->get('sale_price');
            $product->storage = $request->get('storage');
            $product->save();

            DB::commit();
            Session::flash('message', 'Produto atualizado com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, Não foi possível editar o produto');
            DB::rollBack();
        }

        return redirect()->route('products.edit', ['product' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();
            Session::flash('message', 'Produto removido com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível remover o produto');
            DB::rollBack();
        }

        return redirect()->route('products.index');
    }

    public function findByCategory(Request $request): View|RedirectResponse
    {
        $categories = Category::all();

        if (empty($request->get('categoria'))) {
            return redirect()->route('products.index');
        }

        $category = Category::query()->where('code', '=', $request->get('categoria'))->first();
        
        if (empty($category)) {
            Session::flash('message', 'A categoria informada não foi encontrada');
            return redirect()->route('products.index');
        }

        $products = (new Product())->query()->where('category_id', $category->id)->with('category')->paginate(15);

        if (empty($products) || empty($products->items())) {
            Session::flash('message', 'Nenhum produto encontrado para a categoria informada');
            return redirect()->route('products.index');
        }
        
        $products->appends(['categoria' => $request->get('categoria')]);

        $selected = $category->id;
        $message = "Produtos encontrados com a categoria {$category->name}";
    
        return view('product.list', [
            'title' => 'Penedo | Lista de Produtos',
            'products' => $products ?? [],
            'categories' => $categories ?? [],
            'selected' => $selected ?? null,
            'message' => $message ?? null,
        ]);
    }
}
