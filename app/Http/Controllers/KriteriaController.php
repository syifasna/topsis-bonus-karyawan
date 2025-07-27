<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kriteria = Kriteria::paginate(5);
          
        return view('spk.kriteria.index', compact('kriteria'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('spk.kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Kriteria::create($request->all());
           
        return redirect()->route('kriteria.index')
                         ->with('success', 'Data Kriteria Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriteria): View
    {
        return view('spk.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriteria): RedirectResponse
    {
        $kriteria->update($request->all());
          
        return redirect()->route('kriteria.index')
                        ->with('success','Data Kriteria Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria): RedirectResponse
    {
        $kriteria->delete();
           
        return redirect()->route('kriteria.index')
                        ->with('success','Data Kriteria Berhasil Dihapus');
    }
}
