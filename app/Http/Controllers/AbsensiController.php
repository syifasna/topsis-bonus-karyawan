<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Gaji;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahun_bulan = $request->input('tahun_bulan', null);

        $absensi = Absensi::when($tahun_bulan, function($query) use ($tahun_bulan) {
            $query->where('bulan', $tahun_bulan)->latest()->paginate(5);
        })->get();

        return view('admin.absensi.index', compact('absensi', 'tahun_bulan'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tahun_bulan = $request->input('tahun_bulan', null);
        $karyawan = Karyawan::all(); 
        return view('admin.absensi.create', compact('tahun_bulan', 'karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tahun_bulan' => 'required|date_format:Y-m', 
            'masuk' => 'required|integer',
            'izin' => 'nullable|integer',
            'sakit' => 'nullable|integer'
        ]);
     
        // absen
        $absensi = new Absensi();
        $absensi->karyawan_id = $validatedData['karyawan_id'];
        $absensi->bulan = $validatedData['tahun_bulan']; 
        $absensi->masuk = $validatedData['masuk'];
        $absensi->izin = $validatedData['izin'] ?? 0; 
        $absensi->sakit = $validatedData['sakit'] ?? 0; 
        $absensi->save();
     
        // proses hitung gaji otomatis
        $karyawan = Karyawan::findOrFail($validatedData['karyawan_id']);
        $gajiPokok = $karyawan->jabatan->gajipokok;
     
        // get gaji harian
        $totalHariKerja = 26;
        $gajiPerHari = $gajiPokok / $totalHariKerja;
     
        //potongan absen
        $potongan = ($validatedData['izin'] + $validatedData['sakit']) * $gajiPerHari;
        $gajiFinal = $gajiPokok - $potongan;

        $terbilang = $this->terbilang($gajiFinal);
     
        // gaji
        Gaji::create([
            'bulan' => $validatedData['tahun_bulan'],
            'karyawan_id' => $validatedData['karyawan_id'],
            'gajipokok' => $gajiFinal,
            'absensi_id' => $absensi->id,
            'total' => $gajiFinal,
            'terbilang' => $terbilang,
        ]);
     
        return redirect()->route('absensi.index')->with('success', 'Data Absensi Berhasil Ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi): View
    {
        $karyawan = Karyawan::all();
        return view('admin.absensi.edit', compact('absensi','karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validatedData = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'masuk' => 'required|integer',
            'izin' => 'nullable|integer',
            'sakit' => 'nullable|integer',
        ]);

        // Update absensi
        $absensi->karyawan_id = $validatedData['karyawan_id'];
        $absensi->masuk = $validatedData['masuk'];
        $absensi->izin = $validatedData['izin'] ?? 0; 
        $absensi->sakit = $validatedData['sakit'] ?? 0; 
        $absensi->save();

        // update gaji
        $karyawan = Karyawan::findOrFail($validatedData['karyawan_id']);
        $gajiPokok = $karyawan->jabatan->gajipokok;
        $totalHariKerja = 25;
        $gajiPerHari = $gajiPokok / $totalHariKerja;
        
        // Potongan izin dan sakit
        $potongan = ($validatedData['izin'] + $validatedData['sakit']) * $gajiPerHari;
        $gajiFinal = $gajiPokok - $potongan;
        $terbilang = $this->terbilang($gajiFinal);

        $gaji = Gaji::where('bulan', $absensi->bulan)
                    ->where('karyawan_id', $validatedData['karyawan_id'])
                    ->first();

        if ($gaji) {
            $gaji->update([
                'gajipokok' => $gajiFinal,
                'total' => $gajiFinal,
                'terbilang' => $terbilang,
            ]);
        } else {
            Gaji::create([
                'bulan' => $absensi->bulan,
                'karyawan_id' => $validatedData['karyawan_id'],
                'gajipokok' => $gajiFinal,
                'absensi_id' => $absensi->id,
                'total' => $gajiFinal,
                'terbilang' => $terbilang,
            ]);
        }

        return redirect()->route('absensi.index')->with('success', 'Data Absensi Berhasil Diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();
           
        return redirect()->route('absensi.index')
                        ->with('success','Data Absensi Berhasil Dihapus');
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
