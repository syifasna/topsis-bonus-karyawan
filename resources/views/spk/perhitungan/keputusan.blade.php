@extends('layouts.apps')

@section('content')
    <div class="container mt-4">

        <div class="card p-5">
            <a href="{{ route('perhitungan.keputusan.export.pdf') }}" class="btn btn-danger mb-4">📄 Export PDF</a>

            <h4>Hasil Keputusan Rangking</h4>
            <table class="table table mt-4" style="text-align: center">
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Karyawan</th>
                        <th>Preferensi (V)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($preferensi as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['karyawan']->nama }}</td>
                            <td>{{ number_format($item['preferensi'], 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card p-5 mt-5" style="background-color:#FCC737 ;">
            <h4>✅ Kesimpulan</h4>
            <p class="text-white">Seluruh karyawan berhak menerima bonus sebesar Rp3.000.000 karena telah memenuhi kriteria minimal (masa kerja 3 tahun ke atas).</p>
            <p class="text-white">Namun, berdasarkan perhitungan metode TOPSIS, terdapat urutan preferensi yang bisa menjadi acuan untuk memberi bonus tambahan secara adil dan terukur.</p>
        </div>

        <div class="card p-5 mt-5">
            <h4>Saran Pemberian Bonus</h4>
            <table class="table table-bordered mt-4" style="text-align: center">
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
        </div>


    </div>
@endsection
