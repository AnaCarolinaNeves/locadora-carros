<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CarroController extends Controller
{
    /**
     * Lista os carros (com filtros).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');       // busca por placa
        $modeloId = $request->get('modelo_id');
        $status = $request->get('status');

        $query = Carro::with('modelo.marca');

        if ($search) {
            $query->where('placa', 'like', "%{$search}%");
        }

        if ($modeloId) {
            $query->where('modelo_id', $modeloId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $carros = $query->orderBy('placa')->paginate(10)->withQueryString();
        $modelos = Modelo::with('marca')->orderBy('nome')->get();

        $statusOptions = [
            'disponivel' => 'Disponível',
            'alugado'    => 'Alugado',
            'manutencao' => 'Manutenção',
        ];

        return view('carros.index', compact('carros', 'modelos', 'statusOptions', 'search', 'modeloId', 'status'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        $modelos = Modelo::with('marca')->orderBy('nome')->get();

        $statusOptions = [
            'disponivel' => 'Disponível',
            'alugado'    => 'Alugado',
            'manutencao' => 'Manutenção',
        ];

        return view('carros.create', compact('modelos', 'statusOptions'));
    }

    /**
     * Salva novo carro.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'modelo_id' => ['required', 'exists:modelos,id'],
            'placa'     => ['required', 'string', 'max:20', 'unique:carros,placa'],
            'cor'       => ['nullable', 'string', 'max:50'],
            'km'        => ['nullable', 'integer', 'min:0'],
            'status'    => ['required', 'in:disponivel,alugado,manutencao'],
        ]);

        Carro::create($data);

        return redirect()
            ->route('carros.index')
            ->with('success', 'Carro cadastrado com sucesso.');
    }

    /**
     * Detalhe de um carro.
     */
    public function show(Carro $carro)
    {
        $carro->load('modelo.marca');

        return view('carros.show', compact('carro'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(Carro $carro)
    {
        $modelos = Modelo::with('marca')->orderBy('nome')->get();

        $statusOptions = [
            'disponivel' => 'Disponível',
            'alugado'    => 'Alugado',
            'manutencao' => 'Manutenção',
        ];

        return view('carros.edit', compact('carro', 'modelos', 'statusOptions'));
    }

    /**
     * Atualiza carro.
     */
    public function update(Request $request, Carro $carro)
    {
        $data = $request->validate([
            'modelo_id' => ['required', 'exists:modelos,id'],
            'placa'     => ['required', 'string', 'max:20', 'unique:carros,placa,' . $carro->id],
            'cor'       => ['nullable', 'string', 'max:50'],
            'km'        => ['nullable', 'integer', 'min:0'],
            'status'    => ['required', 'in:disponivel,alugado,manutencao'],
        ]);

        $carro->update($data);

        return redirect()
            ->route('carros.index')
            ->with('success', 'Carro atualizado com sucesso.');
    }

    /**
     * Exclui carro.
     */
    public function destroy(Carro $carro)
    {
        try {
            $carro->delete();

            return redirect()
                ->route('carros.index')
                ->with('success', 'Carro excluído com sucesso.');
        } catch (QueryException $e) {
            return redirect()
                ->route('carros.index')
                ->with('error', 'Não é possível excluir este carro, pois existem registros vinculados.');
        }
    }
}