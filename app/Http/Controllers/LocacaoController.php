<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Models\Cliente;
use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class LocacaoController extends Controller
{
    /**
     * Lista locações com filtros básicos.
     */
    public function index(Request $request)
    {
        $search = $request->get('search'); // nome do cliente ou placa
        $status = $request->get('status');

        $query = Locacao::with(['cliente', 'carro.modelo.marca']);

        if ($search) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            })->orWhereHas('carro', function ($q) use ($search) {
                $q->where('placa', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $locacoes = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $statusOptions = [
            'aberta'      => 'Aberta',
            'finalizada'  => 'Finalizada',
            'cancelada'   => 'Cancelada',
        ];

        return view('locacoes.index', compact('locacoes', 'status', 'statusOptions', 'search'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $carros = Carro::with('modelo.marca')
            ->where('status', 'disponivel')
            ->orderBy('placa')
            ->get();

        $statusOptions = [
            'aberta'      => 'Aberta',
            'finalizada'  => 'Finalizada',
            'cancelada'   => 'Cancelada',
        ];

        return view('locacoes.create', compact('clientes', 'carros', 'statusOptions'));
    }

    /**
     * Salva nova locação.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'              => ['required', 'exists:clientes,id'],
            'carro_id'                => ['required', 'exists:carros,id'],
            'data_retirada'           => ['required', 'date'],
            'data_devolucao_prevista' => ['required', 'date', 'after_or_equal:data_retirada'],
            'valor_diaria'            => ['required', 'numeric', 'min:0'],
            'status'                  => ['required', 'in:aberta,finalizada,cancelada'],
        ]);
        
        // Verifica se já existe uma locação aberta para este carro
        $carroJaAlugado = Locacao::where('carro_id', $data['carro_id'])
            ->where('status', 'aberta')
            ->exists();

        if ($carroJaAlugado && $data['status'] === 'aberta') {
            return back()
                ->withErrors(['carro_id' => 'Este carro já está em uma locação aberta.'])
                ->withInput();
        }

        // Calcula valor_total básico: dias * valor_diaria
        $data['valor_total'] = $this->calcularValorTotal(
            $data['data_retirada'],
            $data['data_devolucao_prevista'],
            $data['valor_diaria']
        );

        $locacao = Locacao::create($data);

        // Atualizar status do carro se locação aberta/finalizada
        $carro = Carro::findOrFail($data['carro_id']);
        if ($data['status'] === 'aberta') {
            $carro->update(['status' => 'alugado']);
        }

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação criada com sucesso.');
    }

    /**
     * Detalhes de uma locação.
     */
    public function show(Locacao $locacao)
    {
        $locacao->load(['cliente', 'carro.modelo.marca']);

        return view('locacoes.show', compact('locacao'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(Locacao $locacao)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $carros = Carro::with('modelo.marca')->orderBy('placa')->get();

        $statusOptions = [
            'aberta'      => 'Aberta',
            'finalizada'  => 'Finalizada',
            'cancelada'   => 'Cancelada',
        ];

        return view('locacoes.edit', compact('locacao', 'clientes', 'carros', 'statusOptions'));
    }

    /**
     * Atualiza uma locação.
     */
    public function update(Request $request, Locacao $locacao)
    {
        $data = $request->validate([
            'cliente_id'              => ['required', 'exists:clientes,id'],
            'carro_id'                => ['required', 'exists:carros,id'],
            'data_retirada'           => ['required', 'date'],
            'data_devolucao_prevista' => ['required', 'date', 'after_or_equal:data_retirada'],
            'valor_diaria'            => ['required', 'numeric', 'min:0'],
            'status'                  => ['required', 'in:aberta,finalizada,cancelada'],
        ]);

        // Regra: não permitir carro em duas locações abertas
        $carroIdNovo = $data['carro_id'];
        $carroIdAntigo = $locacao->carro_id;

        $queryCarroAberto = Locacao::where('carro_id', $carroIdNovo)
            ->where('status', 'aberta')
            ->where('id', '!=', $locacao->id); // ignora a própria locação

        $carroJaAlugado = $queryCarroAberto->exists();

        if ($carroJaAlugado && $data['status'] === 'aberta') {
            return back()
                ->withErrors(['carro_id' => 'Este carro já está em uma locação aberta.'])
                ->withInput();
        }

        // Recalcula valor_total
        $data['valor_total'] = $this->calcularValorTotal(
            $data['data_retirada'],
            $data['data_devolucao_prevista'],
            $data['valor_diaria']
        );

        if ($locacao->carro_id != $data['carro_id']) {
            $carroAntigo = $locacao->carro;
            if ($carroAntigo && $carroAntigo->status === 'alugado') {
                $carroAntigo->update(['status' => 'disponivel']);
            }

            $carroNovo = Carro::findOrFail($data['carro_id']);
            if ($data['status'] === 'aberta') {
                $carroNovo->update(['status' => 'alugado']);
            }
        } else {
            $carro = $locacao->carro;
            if ($carro) {
                if ($data['status'] === 'aberta') {
                    $carro->update(['status' => 'alugado']);
                } elseif ($data['status'] === 'finalizada' || $data['status'] === 'cancelada') {
                    $carro->update(['status' => 'disponivel']);
                }
            }
        }

        $locacao->update($data);

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação atualizada com sucesso.');
    }

    /**
     * Exclui uma locação.
     */
    public function destroy(Locacao $locacao)
    {
        if ($locacao->status === 'finalizada') {
            return redirect()
                ->route('locacoes.index')
                ->with('error', 'Não é permitido excluir locações finalizadas.');
        }

        $carro = $locacao->carro;
        if ($carro && $carro->status === 'alugado') {
            $carro->update(['status' => 'disponivel']);
        }

        $locacao->delete();

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação excluída com sucesso.');
    }

    /**
     * Regra simples de cálculo de valor total.
     */
    protected function calcularValorTotal($dataRetirada, $dataDevolucaoPrevista, $valorDiaria)
    {
        $inicio = Carbon::parse($dataRetirada);
        $fim = Carbon::parse($dataDevolucaoPrevista);

        $dias = $inicio->diffInDays($fim);
        if ($dias === 0) {
            $dias = 1;
        }

        return $dias * $valorDiaria;
    }

    public function concluir(Locacao $locacao)
    {
        if ($locacao->status !== 'aberta') {
            return redirect()
                ->route('locacoes.index')
                ->with('error', 'Somente locações abertas podem ser concluídas.');
        }

        $data = [
            'status' => 'finalizada',
            'valor_diaria' => $locacao->valor_diaria,
            'data_retirada' => $locacao->data_retirada,
            'data_devolucao_prevista' => $locacao->data_devolucao_prevista,
        ];

        $data['valor_total'] = $this->calcularValorTotal(
            $data['data_retirada'],
            $data['data_devolucao_prevista'],
            $data['valor_diaria']
        );

        $locacao->update($data);

        $carro = $locacao->carro;
        if ($carro) {
            $carro->update(['status' => 'disponivel']);
        }

        return redirect()
            ->route('locacoes.index')
            ->with('success', 'Locação concluída com sucesso.');
    }
}