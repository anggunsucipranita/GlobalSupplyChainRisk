<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortManagementController extends Controller
{
    public function index()
    {
        $ports = Port::latest()->get();

        return view(
            'admin.ports.index',
            compact('ports')
        );
    }

    public function create()
    {
        return view('admin.ports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'city' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required'
        ]);

        Port::create($request->all());

        return redirect()
            ->route('admin.ports')
            ->with('success', 'Port berhasil ditambahkan.');
    }

    public function edit(Port $port)
    {
        return view(
            'admin.ports.edit',
            compact('port')
        );
    }

    public function update(Request $request, Port $port)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'city' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required'
        ]);

        $port->update($request->all());

        return redirect()
            ->route('admin.ports')
            ->with('success', 'Port berhasil diperbarui.');
    }

    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()
            ->route('admin.ports')
            ->with('success', 'Port berhasil dihapus.');
    }
}