<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ClienteController extends Controller
{
    /**
     * Lista clientes com filtro por nome/documento.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Cliente::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%");
            });
        }

        $clientes = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes', 'search'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Salva novo cliente.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:50', 'unique:clientes,documento'],
            'email'     => ['nullable', 'email', 'max:255'],
            'telefone'  => ['nullable', 'string', 'max:50'],
        ]);

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }

    /**
     * Detalhes de um cliente.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:50', 'unique:clientes,documento,' . $cliente->id],
            'email'     => ['nullable', 'email', 'max:255'],
            'telefone'  => ['nullable', 'string', 'max:50'],
        ]);

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Exclui cliente.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();

            return redirect()
                ->route('clientes.index')
                ->with('success', 'Cliente excluído com sucesso.');
        } catch (QueryException $e) {
            return redirect()
                ->route('clientes.index')
                ->with('error', 'Não é possível excluir este cliente, pois existem registros vinculados.');
        }
    }
}