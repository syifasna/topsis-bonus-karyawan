@extends('layouts.apps')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4>Input Nilai Alternatif</h4>
                <h2>({{ $perhitungan->alternatif->alternatif }}) {{ $perhitungan->karyawan->nama }}</h2>
                <a class="btn btn-dark btn-sm" href="{{ route('perhitungan.index') }}">Kembali</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2 mt-3">
                <div class="container">
                    <form action="{{ route('perhitungan.nilai.store', $perhitungan->id) }}" method="POST">
                        @csrf

                        @php
                            $nilaiSebelumnya =
                                $perhitungan->relationLoaded('nilaiPerhitungan') && $perhitungan->nilaiPerhitungan
                                    ? $perhitungan->nilaiPerhitungan->pluck('nilai', 'kriteria_id')
                                    : collect();

                        @endphp


                        {{-- Kriteria 2 --}}
                        <label class="mt-3"><strong>Kualitas Karakter</strong></label>
                        <div class="alert border-success text-success small" style="font-size:11px" role="alert">
                            Kualitas Karakter dinilai dari tingkat <b>ketelitian, inisiatif, dan kemampuan kerja sama</b>. Semakin tinggi ketiganya ditunjukkan secara konsisten, maka penilaian cenderung masuk dalam kategori <b>Sangat Baik</b>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach (['Sangat Baik' => 5, 'Baik' => 4, 'Cukup' => 3, 'Kurang' => 2, 'Sangat Kurang' => 1] as $label => $val)
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input" type="radio" name="karakter"
                                        value="{{ $val }}"
                                        {{ ($nilaiSebelumnya[2] ?? '') == $val ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Kriteria 3 --}}
                        <label class="mt-5"><strong>Tanggung Jawab</strong></label>
                        <div class="alert border-success text-success small" style="font-size:11px" role="alert">
                            Tanggung Jawab mencakup <b>kepatuhan terhadap SOP, komitmen terhadap pekerjaan, dan konsistensi dalam performa.</b> Semakin konsisten dan patuh terhadap aturan kerja, maka nilainya cenderung mendekati kategori <b>Sangat Baik.</b>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach (['Sangat Baik' => 5, 'Baik' => 4, 'Cukup' => 3, 'Kurang' => 2, 'Sangat Kurang' => 1] as $label => $val)
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input" type="radio" name="tanggung_jawab"
                                        value="{{ $val }}"
                                        {{ ($nilaiSebelumnya[3] ?? '') == $val ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>



                        <button type="submit" class="btn btn-success mt-3">Simpan Nilai</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
