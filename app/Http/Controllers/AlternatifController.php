<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AlternatifController extends Controller
{
    public function index(): View
    {
        $alternatif = Alternatif::paginate(5);
          
        return view('spk.alternatif.index', compact('alternatif'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function edit(Alternatif $alternatif): View
    {
        return view('spk.alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, Alternatif $alternatif): RedirectResponse
    {
        $alternatif->update($request->all());
          
        return redirect()->route('alternatif.index')
                        ->with('success','Data Alternatif Berhasil Diubah');
    }

    public function destroy(Alternatif $alternatif): RedirectResponse
    {
        $alternatif->delete();
           
        return redirect()->route('alternatif.index')
                        ->with('success','Data Alternatif Berhasil Dihapus');
    }
}
