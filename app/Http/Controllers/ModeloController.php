<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ModeloController extends Controller
{
    /**
     * Lista os modelos (com filtro e relação com marcas).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $marcaId = $request->get('marca_id');

        $query = Modelo::with('marca');

        if ($search) {
            $query->where('nome', 'like', "%{$search}%");
        }

        if ($marcaId) {
            $query->where('marca_id', $marcaId);
        }

        $modelos = $query->orderBy('nome')->paginate(10)->withQueryString();
        $marcas = Marca::orderBy('nome')->get();

        return view('modelos.index', compact('modelos', 'marcas', 'search', 'marcaId'));
    }

    /**
     * Formulário de criação de modelo.
     */
    public function create()
    {
        $marcas = Marca::orderBy('nome')->get();

        return view('modelos.create', compact('marcas'));
    }

    /**
     * Salva novo modelo.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'marca_id' => ['required', 'exists:marcas,id'],
            'nome'     => ['required', 'string', 'max:255'],
            'ano'      => ['nullable', 'integer'],
        ]);

        Modelo::create($data);

        return redirect()
            ->route('modelos.index')
            ->with('success', 'Modelo criado com sucesso.');
    }

    /**
     * detalhe de um modelo.
     */
    public function show(Modelo $modelo)
    {
        $modelo->load('marca');

        return view('modelos.show', compact('modelo'));
    }

    /**
     * Formulário de edição de modelo.
     */
    public function edit(Modelo $modelo)
    {
        $marcas = Marca::orderBy('nome')->get();

        return view('modelos.edit', compact('modelo', 'marcas'));
    }

    /**
     * Atualiza modelo.
     */
    public function update(Request $request, Modelo $modelo)
    {
        $data = $request->validate([
            'marca_id' => ['required', 'exists:marcas,id'],
            'nome'     => ['required', 'string', 'max:255'],
            'ano'      => ['nullable', 'integer'],
        ]);

        $modelo->update($data);

        return redirect()
            ->route('modelos.index')
            ->with('success', 'Modelo atualizado com sucesso.');
    }

    /**
     * Exclui modelo.
     */
    public function destroy(Modelo $modelo)
    {
        try {
            $modelo->delete();

            return redirect()
                ->route('modelos.index')
                ->with('success', 'Modelo excluído com sucesso.');
        } catch (QueryException $e) {
            return redirect()
                ->route('modelos.index')
                ->with('error', 'Não é possível excluir este modelo, pois existem registros vinculados.');
        }
    }
}