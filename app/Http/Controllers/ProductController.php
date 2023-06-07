<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('categoria')) {
            return $this->findByCategory($request);
        }

        try {
            $categories = Category::all();
            $products = Product::query()->where('id', '>', 0)->with('category')->paginate(15);
        } catch (Exception $e) {
            $message = 'Erro, não foi possíver listar os produtos';
            Session::flash('message', $message);
        }

        return view('product.list', [
            'title' => 'Penedo | Lista de Produtos',
            'products' => $products ?? [],
            'categories' => $categories ?? [],
            'selected' => $selected ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::all();
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível acessar o recurso de cadastro de produto!');
            return redirect()->route('products.index');
        }

        return view('product.createForm', [
            'title' => 'Penedo | Cadastrar Produto',
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $categories = Category::all();

            $product = new Product();
            $product->category_id = $request->get('category_id');
            $product->code = $request->get('code');
            $product->description = $request->get('description');
            $product->purchase_price = $request->get('purchase_price');
            $product->sale_price = $request->get('sale_price');
            $product->storage = $request->get('storage');
            $product->save();

            $message = 'Produto cadastrado com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = 'Error, Não foi possível cadastrar o produto!';
            DB::rollBack();
        }

        Session::flash('message', $message);

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::query()->where('id', $id)->with('category')->first();
            $categories = Category::all();

            if (empty($product)) {
                throw new Exception('Erro, o produto informado não foi encontrado!');
            }

        } catch (Exception $e) {
            $message = $e->getMessage();
            Session::flash('message', $message);
            return redirect()->route('products.index');
        }

        return view('product.editForm', [
            'title' => 'Penedo | Editar Produto',
            'product' => $product ?? null,
            'categories' => $categories ?? [],
            'selected' => $product->category->id ?? null,
        ]);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => ['required'],
            'code' => ['required', Rule::unique('products', 'code')->ignore($id), 'numeric', 'max:255'],
            'description' => ['required', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'storage' => ['required', 'integer'],
        ], [
            'required' => 'O campo :attribute não pode ser vazio.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'numeric' => 'O campo :attribute deve ser um valor numérico.',
            'integer' => 'O campo :attribute deve ser um valor numérico inteiro',
            'code.unique' => 'Já existe um produto com este :attribute.',
        ], [
            'category_id' => 'categoria',
            'code' => 'código',
            'description' => 'descrição',
            'purchase_price' => 'preço de compra',
            'sale_price' => 'preço de venda',
            'storage' => 'quantidade',
        ]);

        try {
            DB::beginTransaction();
            $product = Product::query()->find($id);
            $product->category_id = $request->get('category_id');
            $product->code = $request->get('code');
            $product->description = $request->get('description');
            $product->purchase_price = $request->get('purchase_price');
            $product->sale_price = $request->get('sale_price');
            $product->storage = $request->get('storage');
            $product->save();

            $message = 'Produto atualizado com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = 'Error, Não foi possível editar o produto!';
            $message = $e->getMessage();
            DB::rollBack();
        }

        Session::flash('message', $message);

        return redirect()->route('products.edit', ['product' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);

            if (empty($product)) {
                throw new Exception('Erro, o produto informado não foi encontrado!');
            }

            $product->delete();

            $message = 'Produto removido com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = $e->getMessage();
            DB::rollBack();
        }

        Session::flash('message', $message);

        return redirect()->route('products.index');
    }

    public function findByCategory(Request $request)
    {
        try {

            $categories = Category::all();
            $category = Category::query()->where('code', '=', $request->get('categoria'))->first();

            if (empty($category)) {
                throw new Exception('Erro, a categoria informada não foi encontrada!');
            }

            $products = (new Product())->query()->where('category_id', $category->id)->with('category')->paginate(15);

            if (empty($products) || empty($products->items())) {
                throw new Exception('Nenhum produto encontrado para a categoria informada.');
            }
            
            $products->appends(['categoria' => $request->get('categoria')]);

            $selected = $category->id;
            $message = "Produtos encontrados com a categoria {$category->name}";

        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return view('product.list', [
            'title' => 'Penedo | Lista de Produtos',
            'products' => $products ?? [],
            'categories' => $categories ?? [],
            'selected' => $selected ?? null,
            'message' => $message,
        ]);
    }
}
