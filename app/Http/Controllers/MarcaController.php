<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MarcaController extends Controller
{
    /**
     * Lista todas as marcas.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Marca::query();

        if ($search) {
            $query->where('nome', 'like', "%{$search}%");
        }

        $marcas = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('marcas.index', compact('marcas', 'search'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Salva nova marca.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Marca::create($data);

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca criada com sucesso.');
    }

    /**
     * Detalhe de uma marca.
     */
    public function show(Marca $marca)
    {
        return view('marcas.show', compact('marca'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Atualiza marca.
     */
    public function update(Request $request, Marca $marca)
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $marca->update($data);

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca atualizada com sucesso.');
    }

    /**
     * Exclui marca
     */
    public function destroy(Marca $marca)
    {
        try {
            $marca->delete();

            return redirect()
                ->route('marcas.index')
                ->with('success', 'Marca excluída com sucesso.');
        } catch (QueryException $e) {
            return redirect()
                ->route('marcas.index')
                ->with('error', 'Não é possível excluir esta marca, pois existem registros vinculados.');
        }
    }
}