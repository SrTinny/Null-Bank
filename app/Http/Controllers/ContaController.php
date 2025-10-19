<?php
namespace App\Http\Controllers;

use App\Models\Conta;
use App\Http\Requests\StoreContaRequest;

class ContaController extends Controller
{
    public function index()
    {
        $contas = Conta::paginate(15);
        return view('contas.index', compact('contas'));
    }

    public function create()
    {
        return view('contas.create');
    }

    public function store(StoreContaRequest $request)
    {
        Conta::create($request->validated());
        return redirect()->route('contas.index')->with('success', 'Conta criada');
    }

    public function show(Conta $conta)
    {
        return view('contas.show', compact('conta'));
    }

    public function edit(Conta $conta)
    {
        return view('contas.edit', compact('conta'));
    }

    public function update(StoreContaRequest $request, Conta $conta)
    {
        $conta->update($request->validated());
        return redirect()->route('contas.show', $conta)->with('success', 'Conta atualizada');
    }

    public function destroy(Conta $conta)
    {
        $conta->delete();
        return redirect()->route('contas.index')->with('success', 'Conta removida');
    }
}
