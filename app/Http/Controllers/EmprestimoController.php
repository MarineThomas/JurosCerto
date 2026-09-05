<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Cliente;
use App\Services\JurosService;
use Illuminate\Http\Request;

class EmprestimoController extends Controller
{
    protected $jurosService;

    public function __construct(JurosService $jurosService)
    {
        $this->jurosService = $jurosService;
    }

    public function index(Request $request){
        $query = Emprestimo::with('cliente');

    if ($request->filled('mes')) {
        $query->whereMonth('data_inicio', $request->mes);
    }

    if ($request->filled('ano')) {
        $query->whereYear('data_inicio', $request->ano);
    }

    $emprestimos = $query->orderByRaw("FIELD(status, 'ativo', 'em_atraso', 'quitado')")
                         ->get();

    $anos = Emprestimo::selectRaw('YEAR(data_inicio) as ano')
                      ->distinct()
                      ->orderBy('ano', 'desc')
                      ->pluck('ano');

    return view('emprestimos.index', compact('emprestimos', 'anos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('emprestimos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'valor_principal' => 'required|numeric|min:1',
            'tipo_juros'      => 'required|in:simples,composto',
            'taxa_juros'      => 'required|numeric|min:0.01',
            'num_parcelas'    => 'required|integer|min:1',
            'data_inicio'     => 'required|date',
        ]);

        $emprestimo = Emprestimo::create($request->all());

        $parcelas = $this->jurosService->calcularParcelas(
            $request->valor_principal,
            $request->taxa_juros,
            $request->num_parcelas,
            $request->tipo_juros,
            $request->data_inicio
        );

        $emprestimo->parcelas()->createMany($parcelas);

        return redirect()->route('emprestimos.index')
            ->with('sucesso', 'Empréstimo registrado com sucesso!');
    }

    public function show(Emprestimo $emprestimo)
    {
        $emprestimo->load('cliente', 'parcelas');
        return view('emprestimos.show', compact('emprestimo'));
    }

    public function destroy(Emprestimo $emprestimo)
    {
        $emprestimo->delete();
        return redirect()->route('emprestimos.index')
            ->with('sucesso', 'Empréstimo excluído com sucesso!');
    }
}