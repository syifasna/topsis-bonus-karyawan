<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Alternatif;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\KaryawanStoreRequest;
use App\Http\Requests\KaryawanUpdateRequest;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $karyawan = Karyawan::latest()->paginate(5);
          
        return view('admin.karyawan.index', compact('karyawan'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jabatan = Jabatan::all();
        return view('admin.karyawan.create', compact('jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KaryawanStoreRequest $request): RedirectResponse
    {
        $karyawan = Karyawan::create($request->validated());

        $jumlahAlternatif = Alternatif::count() + 1;
        $kodeAlternatif = 'A' . $jumlahAlternatif;

        $tglKerja = Carbon::parse($karyawan->tglkerja);
        $sekarang = Carbon::now();
        $lamaKerja = $tglKerja->diffInYears($sekarang);

        if ($lamaKerja >= 3) {
            Alternatif::create([
                'karyawan_id' => $karyawan->id,
                'alternatif' => $kodeAlternatif,
            ]);
        }
           
        return redirect()->route('karyawan.index')
                         ->with('success', 'Data Karyawan Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan): View
    {
        $jabatan = Jabatan::all();
        return view('admin.karyawan.edit', compact('karyawan','jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KaryawanUpdateRequest $request, Karyawan $karyawan): RedirectResponse
    {
        $karyawan->update($request->validated());
          
        return redirect()->route('karyawan.index')
                        ->with('success','Data Karyawan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan): RedirectResponse
    {
        $karyawan->delete();
           
        return redirect()->route('karyawan.index')
                        ->with('success','Data Karyawan Berhasil Dihapus');
    }
}
