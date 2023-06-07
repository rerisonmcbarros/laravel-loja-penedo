<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $categories = Category::query()->where('id', '>', 0)->paginate();
        } catch (Exception $e) {
            $message = "Erro, não foi possível listar as categorias";
            Session::flash('message', $message);
        }

        return view('category.list', [
            'title' => 'Penedo | Lista de Categorias',
            'categories' => $categories ?? [],
        ]);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.createForm', [
            'title' => ' Penedo | Cadastrar Categoria',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $category = new Category();
            $category->code = $request->get('code');
            $category->name = $request->get('name');
            $category->save();

            $message = 'Categoria cadastrada com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = 'Erro, não foi possível cadastrar a categoria.';
            DB::rollBack();
        }
        
        Session::flash('message', $message);

        return redirect()->route('categories.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::query()->find($id);

            if (empty($category)) {
                throw new Exception('Erro, A categoria informada não foi encontrada');
            }

        } catch (Exception $e) {
           $message = $e->getMessage();
           Session::flash('message', $message);
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => [
                'required',
                'numeric',
                Rule::unique('categories', 'code')->ignore($id),
            ],
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
            ],
        ], [
            'code' => [
                'required' => 'O campo :attribute não pode ser vazio.',
                'numeric' => 'O campo :attribute deve ser um valor numérico.',
                'unique' => 'Já existe uma categoria com este :attribute.'
            ],
            'name' => [
                'required' => 'O campo :attribute não pode ser vazio.',
                'min' => 'O campo :attribute deve ter no mínimo 2 caracteres.',
                'max' => 'O campo :attribute deve ter no mínimo 255 caracteres.',
                'unique' => 'Já existe uma categoria com este :attribute.'
            ],
        ], [
            'code' => 'código',
            'name' => 'nome',
        ]);

        try {
            DB::beginTransaction();
            
            $category = Category::query()->find($id);
            $category->name = $request->get('name');
            $category->save();
            $message = 'Categoria atualizada com sucesso!';

            DB::commit();
        } catch (Exception $e) {
            $message = 'Não foi possível atualizar a categoria';
            DB::rollBack();    
        }

        Session::flash('message', $message);

        return redirect()->route('categories.edit', ['category' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        try {
            DB::beginTransaction();
            $category = Category::find($id);

            if (empty($category)) {
                throw new Exception('Erro, A categoria informada não foi encontrada.');
            }

            $category->delete();

            $message = 'Categoria removida com sucesso!';
            DB::commit();
        } catch (Exception $e) {
            $message = $e->getMessage(); 
            DB::rollBack();
        }

        Session::flash('message', $message);
        
        return redirect()->route('categories.index');
    }
}
