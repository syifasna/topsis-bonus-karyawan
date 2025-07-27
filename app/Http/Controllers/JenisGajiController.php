<?php

namespace App\Http\Controllers;

use App\Models\JenisGaji;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\JenisGajiStoreRequest;
use App\Http\Requests\JenisGajiUpdateRequest;

class JenisGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jenisgaji = JenisGaji::latest()->paginate(5);
          
        return view('admin.jenis.index', compact('jenisgaji'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisGajiStoreRequest $request): RedirectResponse
    {
        JenisGaji::create($request->validated());
           
        return redirect()->route('jenisgaji.index')
                         ->with('success', 'Data Jenis Gaji Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisGaji $jenisGaji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisGaji $jenisgaji): View
    {
        return view('admin.jenis.edit',compact('jenisgaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisGajiUpdateRequest $request, JenisGaji $jenisgaji): RedirectResponse
    {
        $jenisgaji->update($request->validated());
          
        return redirect()->route('jenisgaji.index')
                        ->with('success','Data Jenis Gaji Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisGaji $jenisgaji): RedirectResponse
    {
        $jenisgaji->delete();
           
        return redirect()->route('jenisgaji.index')
                        ->with('success','Data Jenis Gaji Berhasil Dihapus');
    }
}
