<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::paginate(15);
        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Cliente::create($data);
    return redirect()->route('clientes.index')->with('success', 'Cliente criado');
    }

    public function show(Cliente $cliente): View
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(StoreClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $data = $request->validated();
        $cliente->update($data);
    return redirect()->route('clientes.show', $cliente)->with('success', 'Cliente atualizado');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();
    return redirect()->route('clientes.index')->with('success', 'Cliente removido');
    }
}
