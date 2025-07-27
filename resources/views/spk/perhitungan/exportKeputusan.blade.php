<!DOCTYPE html>
<html>

<head>
    <title>Hasil Keputusan Bonus Karyawan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        h4 {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h2>Hasil Keputusan Rangking Karyawan</h2>

    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Karyawan</th>
                <th>Preferensi</th>
                <th>Bonus Tambahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preferensi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['karyawan']->nama }}</td>
                    <td>{{ number_format($item['preferensi'], 4) }}</td>
                    <td>Rp{{ number_format($item['bonus'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Kesimpulan : </h4>
    <ol>
        <li>Seluruh karyawan berhak menerima bonus sebesar Rp3.000.000 karena telah memenuhi kriteria minimal (masa
            kerja 3 tahun ke atas).</li>
        <li>Namun, berdasarkan perhitungan metode TOPSIS, terdapat urutan preferensi yang bisa menjadi acuan untuk
            memberi bonus tambahan secara adil dan terukur.</li>
    </ol>
    <br><br><br>

    <hr>
    <h2>Berikut adalah Rekap Hasil Perhitungan Sistem Pendukung Keputusan</h2>
    <h1>Penentuan Bonus Karyawan dengan Metode TOPSIS</h1>

    <h4>Matriks Keputusan</h4>
    <table>
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriterias as $kriteria)
                    <th>{{ $kriteria->nkriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($matriks as $index => $baris)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    @foreach ($baris as $nilai)
                        <td>{{ number_format($nilai, 4) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <h4>Matriks Normalisasi</h4>
    <table>
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriterias as $kriteria)
                    <th>{{ $kriteria->nkriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($normalisasi as $index => $baris)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    @foreach ($baris as $nilai)
                        <td>{{ number_format($nilai, 4) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <h4>Matriks Normalisasi Terbobot</h4>
    <table>
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriterias as $kriteria)
                    <th>{{ $kriteria->nkriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($normalisasiTerbobot as $index => $baris)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    @foreach ($baris as $nilai)
                        <td>{{ number_format($nilai, 4) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <h4>Solusi Ideal Positif (+) dan Negatif (-)</h4>
    <table>
        <thead>
            <tr>
                <th></th>
                @foreach ($kriterias as $kriteria)
                    <th>{{ $kriteria->nkriteria }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Positif (+)</td>
                @foreach ($idealPositif as $nilai)
                    <td>{{ number_format($nilai, 4) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Negatif (-)</td>
                @foreach ($idealNegatif as $nilai)
                    <td>{{ number_format($nilai, 4) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <br><br>

    <h4>Jarak Solusi Ideal</h4>
    <table>
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>D+</th>
                <th>D-</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jarak as $index => $j)
                <tr>
                    <td>A{{ $index + 1 }}</td>
                    <td>{{ number_format($j['d_plus'], 4) }}</td>
                    <td>{{ number_format($j['d_minus'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <h4>Nilai Preferensi dan Ranking</h4>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Alternatif</th>
                <th>Preferensi (V)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preferensi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>A{{ $item['index'] + 1 }}</td>
                    <td>{{ number_format($item['preferensi'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
