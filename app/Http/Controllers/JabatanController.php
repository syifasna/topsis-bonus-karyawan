<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\JabatanStoreRequest;
use App\Http\Requests\JabatanUpdateRequest;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jabatan = Jabatan::latest()->paginate(5);
          
        return view('admin.jabatan.index', compact('jabatan'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JabatanStoreRequest $request): RedirectResponse
    {
        Jabatan::create($request->validated());
           
        return redirect()->route('jabatan.index')
                         ->with('success', 'Data Jabatan Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan): View
    {
        return view('admin.jabatan.edit',compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JabatanUpdateRequest $request, Jabatan $jabatan): RedirectResponse
    {
        $jabatan->update($request->validated());
          
        return redirect()->route('jabatan.index')
                        ->with('success','Data Jabatan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan): RedirectResponse
    {
        $jabatan->delete();
           
        return redirect()->route('jabatan.index')
                        ->with('success','Data Jabatan Berhasil Dihapus');
    }
}
