<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $categories = Category::paginate(15);
        } catch (Exception $e) {
            $message = "Erro, não foi possível obter a lista de categorias";
        }

        return view('category.list', [
            'title' => 'Penedo | Lista de Categorias',
            'categories' => $categories ?? [],
            'message' => $message ?? null,
        ]);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('category.createForm', [
            'title' => ' Penedo | Cadastrar Categoria',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $category = new Category();
            $category->code = $request->get('code');
            $category->name = $request->get('name');
            $category->save();

            $message = 'Categoria cadastrada com sucesso';
            DB::commit();
        } catch (Exception $e) {
            $message = 'Erro, não foi possível cadastrar a categoria';
            DB::rollBack();
        }
        
        Session::flash('message', $message);

        return redirect()->route('categories.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        try {
            $category = Category::query()->find($id);

            if (empty($category)) {
                Session::flash('message', 'A categoria informada não foi encontrada');
                return redirect()->route('categories.index');
            }

        } catch (Exception $e) {
           Session::flash('message', 'Erro, não foi possível editar a categoria');
           return redirect()->route('categories.index');
        }

        return view('category.editForm', [
            'title' => 'Penedo | Editar Categoria',
            'category' => $category ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $category = Category::query()->find($id);
            $category->name = $request->get('name');
            $category->save();

            $message = 'Categoria atualizada com sucesso';

            DB::commit();
        } catch (Exception $e) {
            $message = 'Erro, Não foi possível atualizar a categoria';
            DB::rollBack();    
        }

        Session::flash('message', $message);

        return redirect()->route('categories.edit', ['category' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {   
        try {
            DB::beginTransaction();
            $category = Category::find($id);

            if (empty($category)) {
                Session::flash('message', 'A categoria informada não foi encontrada');
                return redirect()->route('categories.index');
            }

            $category->delete();

            Session::flash('message', 'Categoria removida com sucesso!');
            DB::commit();
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível remover a categoria');
            DB::rollBack();
        }

        return redirect()->route('categories.index');
    }
}
