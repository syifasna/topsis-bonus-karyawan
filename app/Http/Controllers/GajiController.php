<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\JenisGaji;
use App\Models\Gaji;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use PDF;
use Carbon\Carbon;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahun_bulan = $request->input('tahun_bulan', null);

        $gaji = Gaji::when($tahun_bulan, function($query) use ($tahun_bulan) {
            $query->where('bulan', $tahun_bulan)->latest()->paginate(5);
        })->get();

        return view('admin.gaji.index', compact('gaji', 'tahun_bulan'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Gaji $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji): View
    {
        $karyawan = Karyawan::all();
        $jenisGaji = JenisGaji::all(); 

        return view('admin.gaji.edit', compact('gaji','karyawan', 'jenisGaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        $validatedData = $request->validate([
            'jenis_gaji' => 'nullable|array',
            'jenis_gaji.*' => 'exists:jenisgaji,id',
            'jumlah_order' => 'nullable|array',
            'jumlah_order.*' => 'nullable|numeric|min:0',
            'nominal' => 'nullable|array',
            'nominal.*' => 'numeric|min:0',
            'gajipokok' => 'required|numeric|min:0',
        ]);

        // function to vipot jenis_jenisgaji
        $jenisGajiTerpilih = $validatedData['jenis_gaji'] ?? [];
        $jenisGajiList = JenisGaji::whereIn('id', $jenisGajiTerpilih)->get()->keyBy('id');

        $dataJenisGaji = [];
        $totalTambahan = 0;
        $totalPotongan = 0;

        foreach ($jenisGajiTerpilih as $jenis_id) {
            $jenisGaji = $jenisGajiList[$jenis_id] ?? null;

            if (!$jenisGaji) {
                continue; 
            }

            $jumlahOrder = $validatedData['jumlah_order'][$jenis_id] ?? 0; 

            if (in_array($jenisGaji->jenis, ['Komisi Tiktok', 'Komisi Shopee'])) {
                $dataJenisGaji[$jenis_id] = [
                    'nominal' => $jenisGaji->nominal, 
                    'jumlah_order' => $jumlahOrder, 
                ];
                $totalTambahan += $jumlahOrder * $jenisGaji->nominal; 
            } else {
                $nominal = $validatedData['nominal'][$jenis_id] ?? $jenisGaji->nominal;
                $dataJenisGaji[$jenis_id] = ['nominal' => $nominal];

                if ($jenisGaji->tipe === 'Potongan') {
                    $totalPotongan += $nominal;
                } else {
                    $totalTambahan += $nominal;
                }
            }
        }
        $gaji->jenisGaji()->sync($dataJenisGaji);

        $totalGaji = $validatedData['gajipokok'] + $totalTambahan - $totalPotongan;
        $terbilang = $totalGaji > 0 ? $this->terbilang($totalGaji) : 'Nol Rupiah';
        $gaji->update([
            'gajipokok' => $validatedData['gajipokok'],
            'total' => $totalGaji,
            'terbilang' => $terbilang,
        ]);

        return redirect()->route('gaji.index')->with('success', 'Data Gaji Berhasil Diperbarui.');
    }

    public function slipGaji(Gaji $gaji)
    {
        $gaji->load('jenisGaji', 'karyawan', 'absensi');

        $penghasilan = $gaji->jenisGaji->where('tipe', 'Penghasilan');
        $potongan = $gaji->jenisGaji->where('tipe', 'Potongan');

        $absensi = $gaji->absensi;

        $izin = $absensi ? $absensi->izin : 0;
        $sakit = $absensi ? $absensi->sakit : 0;

        $totalHariKerja = 25;
        $gajiPerHari = $gaji->gajipokok / $totalHariKerja;

        // Potongan izin dan sakit
        $potongan_izin = $izin * $gajiPerHari;
        $potongan_sakit = $sakit * $gajiPerHari;

        $gajiFinal = $gaji->total;

        $periode = Carbon::createFromFormat('Y-m', $gaji->bulan)->translatedFormat('F Y');
        $data = compact('gaji', 'penghasilan', 'potongan', 'izin', 'sakit', 'potongan_izin', 'potongan_sakit', 'gajiFinal', 'periode');

        // Set PDF ke format landscape
        $pdf = Pdf::loadView('admin.gaji.slipgaji', $data)
                ->setPaper('a4', 'landscape');

        return $pdf->stream('slip-gaji-' . $gaji->karyawan->nama . '-' . $periode . '.pdf');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gaji $gaji): RedirectResponse
    {
        $gaji->delete();
           
        return redirect()->route('gaji.index')
                        ->with('success','Data Gaji Berhasil Dihapus');
    }

    private function terbilang($angka) {
        $angka = abs($angka);
        $bilangan = [
            "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam",
            "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
        ];
        
        if ($angka < 12) {
            return " " . $bilangan[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            return $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            return " Seratus" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return " Seribu" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
        } else {
            return "Angka terlalu besar";
        }
    }
}