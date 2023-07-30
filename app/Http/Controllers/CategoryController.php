<?php

namespace App\Http\Controllers;

use Exception;
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
        $categories = Category::orderBy('name')->paginate(15);

        return view('category.list', [
            'title' => 'Penedo | Lista de Categorias',
            'categories' => $categories ?? [],
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

            DB::commit();
            Session::flash('message', 'Categoria cadastrada com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'não foi possível cadastrar a categoria');
            DB::rollBack();
        }
        
        return redirect()->route('categories.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {  
        $category = Category::query()->findOrFail($id);
    
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
        $category = Category::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $category->name = $request->get('name');
            $category->save();

            DB::commit();
            Session::flash('message', 'Categoria atualizada com sucesso');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, Não foi possível atualizar a categoria');
            DB::rollBack();    
        }

        return redirect()->route('categories.edit', ['category' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {   
        $category = Category::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $category->delete();

            DB::commit();
            Session::flash('message', 'Categoria removida com sucesso!');
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível remover a categoria');
            DB::rollBack();
        }

        return redirect()->route('categories.index');
    }
}
