<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Aquí puedes obtener los clientes de la base de datos
        // $customers = Customer::all();
        // return view('customers.index', compact('customers'));
        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar y guardar el cliente
        // Customer::create($request->all());
        return redirect()->route('customers.index')
                         ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $customer = Customer::findOrFail($id);
        // return view('customers.show', compact('customer'));
        return view('customers.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $customer = Customer::findOrFail($id);
        // return view('customers.edit', compact('customer'));
        return view('customers.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $customer = Customer::findOrFail($id);
        // $customer->update($request->all());
        return redirect()->route('customers.index')
                         ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $customer = Customer::findOrFail($id);
        // $customer->delete();
        return redirect()->route('customers.index')
                         ->with('success', 'Customer deleted successfully.');
    }
}
