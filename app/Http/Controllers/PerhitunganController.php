<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Perhitungan;
use App\Models\NilaiPerhitungan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Absensi;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;

class PerhitunganController extends Controller
{
    public function index(): View
    {
        $alternatifs = Alternatif::with('karyawan')->get();
        $perhitungan = Perhitungan::all();

        return view('spk.perhitungan.index', compact('alternatifs', 'perhitungan'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'alternatif_id' => 'required|exists:alternatifs,id',
        ]);

        $sudahAda = Perhitungan::where('alternatif_id', $request->alternatif_id)->first();
        if (!$sudahAda) {
            Perhitungan::create([
                'karyawan_id' => $request->karyawan_id,
                'alternatif_id' => $request->alternatif_id,
            ]);
        }

        return redirect()->route('perhitungan.index')->with('success', 'Data perhitungan berhasil disimpan.');
    }

    public function formNilai($id)
    {
        $perhitungan = Perhitungan::with('nilaiPerhitungan')->findOrFail($id); // ← FIX
        $kriterias = Kriteria::all();

        return view('spk.perhitungan.create', compact('perhitungan', 'kriterias'));
    }


    public function simpanNilai(Request $request, $id)
    {
        $perhitungan = Perhitungan::findOrFail($id);

        // Hitung nilai Kehadiran (C1)
        $absensis = Absensi::where('karyawan_id', $perhitungan->karyawan_id)->get();

        $totalMasuk = $absensis->sum('masuk');
        $jumlahBulan = $absensis->count(); // Jumlah bulan yang tercatat

        $totalHariIdeal = $jumlahBulan * 26; // 26 hari kerja per bulan

        $persentase = $totalHariIdeal > 0 ? ($totalMasuk / $totalHariIdeal) * 100 : 0;

        if ($persentase >= 95) $nilaiKehadiran = 5;
        elseif ($persentase >= 90) $nilaiKehadiran = 4;
        elseif ($persentase >= 85) $nilaiKehadiran = 3;
        elseif ($persentase >= 80) $nilaiKehadiran = 2;
        else $nilaiKehadiran = 1;

        // Simpan / update nilai kehadiran (C1)
        NilaiPerhitungan::updateOrCreate(
            ['perhitungan_id' => $perhitungan->id, 'kriteria_id' => 1],
            ['nilai' => $nilaiKehadiran]
        );

        // Simpan / update Karakter (C2)
        if ($request->has('karakter')) {
            NilaiPerhitungan::updateOrCreate(
                ['perhitungan_id' => $perhitungan->id, 'kriteria_id' => 2],
                ['nilai' => $request->karakter]
            );
        }

        // Simpan / update Tanggung Jawab (C3)
        if ($request->has('tanggung_jawab')) {
            NilaiPerhitungan::updateOrCreate(
                ['perhitungan_id' => $perhitungan->id, 'kriteria_id' => 3],
                ['nilai' => $request->tanggung_jawab]
            );
        }

        return redirect()->route('perhitungan.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function edit($id)
    {
        $perhitungan = Perhitungan::with(['alternatif', 'karyawan', 'nilaiPerhitungan'])->findOrFail($id);

        return view('perhitungan.input', compact('perhitungan'));
    }

    public function hasil()
    {
        $perhitungans = Perhitungan::with('nilaiPerhitungan')->get();
        $kriterias = Kriteria::all();

        $matriks = [];
        foreach ($perhitungans as $perhitungan) {
            $nilai = [];
            foreach ($kriterias as $kriteria) {
                $nilaiKriteria = $perhitungan->nilaiPerhitungan->where('kriteria_id', $kriteria->id)->first();
                $nilai[] = $nilaiKriteria ? $nilaiKriteria->nilai : 0;
            }
            $matriks[] = $nilai;
        }

        // Normalisasi Matriks
        $pembagi = [];
        foreach ($kriterias as $k => $kriteria) {
            $total = 0;
            foreach ($matriks as $nilai) {
                $total += pow($nilai[$k], 2);
            }
            $pembagi[$k] = sqrt($total);
        }

        $normalisasi = [];
        foreach ($matriks as $nilai) {
            $row = [];
            foreach ($nilai as $k => $v) {
                $row[] = $pembagi[$k] != 0 ? $v / $pembagi[$k] : 0;
            }
            $normalisasi[] = $row;
        }

        // Normalisasi Terbobot
        $normalisasiTerbobot = [];
        foreach ($normalisasi as $row) {
            $weightedRow = [];
            foreach ($row as $k => $v) {
                $weightedRow[] = $v * $kriterias[$k]->bobot;
            }
            $normalisasiTerbobot[] = $weightedRow;
        }

        // Solusi Ideal
        $idealPositif = [];
        $idealNegatif = [];
        // foreach ($kriterias as $k => $kriteria) {
        //     $column = array_column($normalisasiTerbobot, $k);
        //     $idealPositif[$k] = max($column);
        //     $idealNegatif[$k] = min($column);
        // }
        foreach ($kriterias as $k => $kriteria) {
            $column = array_column($normalisasiTerbobot, $k);
            $idealPositif[$k] = !empty($column) ? max($column) : 0;
            $idealNegatif[$k] = !empty($column) ? min($column) : 0;
        }


        // Jarak Positif dan Negatif
        $jarak = [];
        foreach ($normalisasiTerbobot as $row) {
            $dPlus = $dMinus = 0;
            foreach ($row as $k => $v) {
                $dPlus += pow($v - $idealPositif[$k], 2);
                $dMinus += pow($v - $idealNegatif[$k], 2);
            }
            $jarak[] = [
                'd_plus' => sqrt($dPlus),
                'd_minus' => sqrt($dMinus),
            ];
        }

        // Preferensi
        $preferensi = [];
        foreach ($jarak as $index => $j) {
            $v = ($j['d_plus'] + $j['d_minus']) != 0 ? $j['d_minus'] / ($j['d_plus'] + $j['d_minus']) : 0;
            $preferensi[] = [
                'index' => $index,
                'preferensi' => $v,
            ];
        }

        usort($preferensi, function ($a, $b) {
            return $b['preferensi'] <=> $a['preferensi'];
        });

        return view('spk.perhitungan.hasil', compact('kriterias', 'matriks', 'normalisasi', 'normalisasiTerbobot', 'idealPositif', 'idealNegatif', 'jarak', 'preferensi'));
    }

    public function keputusan()
    {
        $perhitungans = Perhitungan::with('nilaiPerhitungan')->get();
        $kriterias = Kriteria::all();
        $karyawan = Karyawan::all();

        $matriks = [];
        foreach ($perhitungans as $perhitungan) {
            $nilai = [];
            foreach ($kriterias as $kriteria) {
                $nilaiKriteria = $perhitungan->nilaiPerhitungan->where('kriteria_id', $kriteria->id)->first();
                $nilai[] = $nilaiKriteria ? $nilaiKriteria->nilai : 0;
            }
            $matriks[] = $nilai;
        }

        // Normalisasi Matriks
        $pembagi = [];
        foreach ($kriterias as $k => $kriteria) {
            $total = 0;
            foreach ($matriks as $nilai) {
                $total += pow($nilai[$k], 2);
            }
            $pembagi[$k] = sqrt($total);
        }

        $normalisasi = [];
        foreach ($matriks as $nilai) {
            $row = [];
            foreach ($nilai as $k => $v) {
                $row[] = $pembagi[$k] != 0 ? $v / $pembagi[$k] : 0;
            }
            $normalisasi[] = $row;
        }

        // Normalisasi Terbobot
        $normalisasiTerbobot = [];
        foreach ($normalisasi as $row) {
            $weightedRow = [];
            foreach ($row as $k => $v) {
                $weightedRow[] = $v * $kriterias[$k]->bobot;
            }
            $normalisasiTerbobot[] = $weightedRow;
        }

        // Solusi Ideal
        $idealPositif = [];
        $idealNegatif = [];
        // foreach ($kriterias as $k => $kriteria) {
        //     $column = array_column($normalisasiTerbobot, $k);
        //     $idealPositif[$k] = max($column);
        //     $idealNegatif[$k] = min($column);
        // }
        foreach ($kriterias as $k => $kriteria) {
            $column = array_column($normalisasiTerbobot, $k);
            $idealPositif[$k] = !empty($column) ? max($column) : 0;
            $idealNegatif[$k] = !empty($column) ? min($column) : 0;
        }


        // Jarak Positif dan Negatif
        $jarak = [];
        foreach ($normalisasiTerbobot as $row) {
            $dPlus = $dMinus = 0;
            foreach ($row as $k => $v) {
                $dPlus += pow($v - $idealPositif[$k], 2);
                $dMinus += pow($v - $idealNegatif[$k], 2);
            }
            $jarak[] = [
                'd_plus' => sqrt($dPlus),
                'd_minus' => sqrt($dMinus),
            ];
        }

        // Preferensi
        // $preferensi = [];
        foreach ($jarak as $index => $j) {
            $v = ($j['d_plus'] + $j['d_minus']) != 0 ? $j['d_minus'] / ($j['d_plus'] + $j['d_minus']) : 0;

            $preferensi[] = [
                'index' => $index,
                'preferensi' => $v,
                'karyawan' => $perhitungans[$index]->karyawan,
            ];
        }


        usort($preferensi, function ($a, $b) {
            return $b['preferensi'] <=> $a['preferensi'];
        });

        $maxPreferensi = $preferensi[0]['preferensi'];
        $maxBonus = 3000000; // bonus maksimal untuk ranking 1

        foreach ($preferensi as &$item) {
            $item['bonus'] = ($maxPreferensi != 0)
                ? ($item['preferensi'] / $maxPreferensi) * $maxBonus
                : 0;
        }

        return view('spk.perhitungan.keputusan', compact('kriterias', 'matriks', 'normalisasi', 'normalisasiTerbobot', 'idealPositif', 'idealNegatif', 'jarak', 'preferensi'));
    }

    public function exportPDF()
    {
        $perhitungans = Perhitungan::with('nilaiPerhitungan')->get();
        $kriterias = Kriteria::all();

        // --- sama seperti fungsi keputusan ---
        $matriks = [];
        foreach ($perhitungans as $perhitungan) {
            $nilai = [];
            foreach ($kriterias as $kriteria) {
                $nilaiKriteria = $perhitungan->nilaiPerhitungan->where('kriteria_id', $kriteria->id)->first();
                $nilai[] = $nilaiKriteria ? $nilaiKriteria->nilai : 0;
            }
            $matriks[] = $nilai;
        }

        $pembagi = [];
        foreach ($kriterias as $k => $kriteria) {
            $total = 0;
            foreach ($matriks as $nilai) {
                $total += pow($nilai[$k], 2);
            }
            $pembagi[$k] = sqrt($total);
        }

        $normalisasi = [];
        foreach ($matriks as $nilai) {
            $row = [];
            foreach ($nilai as $k => $v) {
                $row[] = $pembagi[$k] != 0 ? $v / $pembagi[$k] : 0;
            }
            $normalisasi[] = $row;
        }

        $normalisasiTerbobot = [];
        foreach ($normalisasi as $row) {
            $weightedRow = [];
            foreach ($row as $k => $v) {
                $weightedRow[] = $v * $kriterias[$k]->bobot;
            }
            $normalisasiTerbobot[] = $weightedRow;
        }

        $idealPositif = [];
        $idealNegatif = [];
        // foreach ($kriterias as $k => $kriteria) {
        //     $column = array_column($normalisasiTerbobot, $k);
        //     $idealPositif[$k] = max($column);
        //     $idealNegatif[$k] = min($column);
        // }
        foreach ($kriterias as $k => $kriteria) {
            $column = array_column($normalisasiTerbobot, $k);
            $idealPositif[$k] = !empty($column) ? max($column) : 0;
            $idealNegatif[$k] = !empty($column) ? min($column) : 0;
        }


        $jarak = [];
        foreach ($normalisasiTerbobot as $row) {
            $dPlus = $dMinus = 0;
            foreach ($row as $k => $v) {
                $dPlus += pow($v - $idealPositif[$k], 2);
                $dMinus += pow($v - $idealNegatif[$k], 2);
            }
            $jarak[] = [
                'd_plus' => sqrt($dPlus),
                'd_minus' => sqrt($dMinus),
            ];
        }

        $preferensi = [];
        foreach ($jarak as $index => $j) {
            $v = ($j['d_plus'] + $j['d_minus']) != 0 ? $j['d_minus'] / ($j['d_plus'] + $j['d_minus']) : 0;
            $preferensi[] = [
                'index' => $index,
                'preferensi' => $v,
                'karyawan' => $perhitungans[$index]->karyawan,
            ];
        }

        usort($preferensi, function ($a, $b) {
            return $b['preferensi'] <=> $a['preferensi'];
        });

        // Bonus tambahan
        $maxPreferensi = $preferensi[0]['preferensi'];
        $maxBonus = 3000000;
        foreach ($preferensi as &$item) {
            $item['bonus'] = ($maxPreferensi != 0)
                ? ($item['preferensi'] / $maxPreferensi) * $maxBonus
                : 0;
        }

        $pdf = Pdf::loadView('spk.perhitungan.exportKeputusan', compact('kriterias', 'matriks', 'normalisasi', 'normalisasiTerbobot', 'idealPositif', 'idealNegatif', 'jarak', 'preferensi'));
        return $pdf->download('hasil_keputusan_bonus.pdf');
    }
}
