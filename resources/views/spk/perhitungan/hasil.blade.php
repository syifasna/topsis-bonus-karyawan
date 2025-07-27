@extends('layouts.apps')

@section('content')
    <div class="container mt-4">

        <div class="card p-5">
            <h4>Matriks Keputusan</h4>
            <table class="table table mt-4" style="text-align: center">
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
        </div>
        

        <div class="card p-5 mt-5">
            <h4>Matriks Normalisasi</h4>
            <table class="table table mt-4" style="text-align: center">
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

            <h4 class="mt-5">Matriks Normalisasi Terbobot</h4>
            <table class="table table mt-4" style="text-align: center">
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
        </div>

        <div class="card p-5 mt-5">
            <h4>Solusi Ideal Positif (+) dan Negatif (-)</h4>
            <table class="table table mt-4" style="text-align: center">
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

            <h4 class="mt-5">Jarak Solusi Ideal</h4>
            <table class="table table mt-3" style="text-align: center">
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
        </div>

        <div class="card p-5 mt-5">
            <h4>Nilai Preferensi dan Ranking</h4>
            <table class="table table mt-4" style="text-align: center">
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
        </div>

    </div>
@endsection
