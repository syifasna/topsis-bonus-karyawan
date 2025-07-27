@extends('layouts.aps')

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4>Ubah Data Gaji</h4>
                <div class="d-md-flex justify-content-md-end">
                    <a class="btn btn-dark btn-sm" href="{{ route('gaji.index') }}">Kembali</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2 mt-3">
                <div class="table-responsive p-0">
                    <div class="container">
                        <form action="{{ route('gaji.update', $gaji->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="month" name="tahun_bulan" value="{{ $gaji->bulan }}" hidden>

                            <div class="mb-3">
                                <label for="karyawan_id" class="form-label"><strong>Nama Lengkap</strong></label>
                                <input class="form-control @error('karyawan_id') is-invalid @enderror" type="text"
                                    name="karyawan_id" value="{{ $gaji->karyawan->nama }}" id="karyawan_id" readonly>
                                @error('karyawan_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <label><strong>Jenis Gaji</strong></label>
                            @php
                                $jenisTerpilih = $gaji->jenisGaji ? $gaji->jenisGaji->pluck('id')->toArray() : [];
                            @endphp
                            @foreach ($jenisGaji as $jenis)
                            <div class="container">
                                <div class="mb-2">
                                    <input 
                                        type="checkbox" 
                                        name="jenis_gaji[]" 
                                        value="{{ $jenis->id }}"
                                        id="checkbox-{{ $jenis->id }}" 
                                        data-tipe="{{ $jenis->tipe }}"
                                        data-jenis="{{ $jenis->jenis }}" {{ in_array($jenis->id, $jenisTerpilih) ? 'checked' : '' }}
                                        onclick="toggleInputFields(this, '{{ $jenis->id }}')"
                                    >
                                    <label for="checkbox-{{ $jenis->id }}">{{ $jenis->jenis }}({{ $jenis->tipe }})</label>

                                    @if (in_array($jenis->jenis, ['Komisi Tiktok', 'Komisi Shopee']))
                                        <input 
                                            type="number" 
                                            name="jumlah_order[{{ $jenis->id }}]"
                                            id="jumlah-order-{{ $jenis->id }}"
                                            class="form-control mt-2 jumlah-order-input" 
                                            placeholder="Masukkan jumlah order"
                                            value="{{ $gaji->jenisGaji->where('id', $jenis->id)->first()->pivot->jumlah_order ?? '' }}"
                                            data-nominal="{{ $jenis->nominal }}"
                                            style="{{ in_array($jenis->id, $jenisTerpilih) ? '' : 'display: none;' }}"
                                            oninput="updateTotal()"
                                        >
                                    @else
                                        <input 
                                            type="number" 
                                            name="nominal[{{ $jenis->id }}]"
                                            id="nominal-{{ $jenis->id }}" 
                                            class="form-control mt-2 nominal-input"
                                            value="{{ $gaji->jenisGaji->where('id', $jenis->id)->first()->pivot->nominal ?? $jenis->nominal }}"
                                            style="{{ in_array($jenis->id, $jenisTerpilih) ? '' : 'display: none;' }}"
                                            oninput="updateTotal()"
                                        >
                                    @endif
                                </div>
                            </div>
                            @endforeach

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gajipokok" class="form-label"><strong>Gaji</strong></label>
                                        <input type="number" name="gajipokok" id="gajipokok" value="{{ $gaji->gajipokok }}"
                                            class="form-control" oninput="updateTotal()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="total" class="form-label"><strong>Total Gaji</strong></label>
                                        <input type="text" id="total" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>                            
                            <button type="submit" class="btn btn-success">Ubah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateTotal(); 
        });

        function toggleInputFields(checkbox, id) {
            let jenis = checkbox.getAttribute("data-jenis");
            let nominalInput = document.getElementById('nominal-' + id);
            let orderInput = document.getElementById('jumlah-order-' + id);

            if (checkbox.checked) {
                if (jenis === "Komisi Tiktok" || jenis === "Komisi Shopee") {
                    orderInput.style.display = 'block';
                } else {
                    nominalInput.style.display = 'block';
                }
            } else {
                if (jenis === "Komisi Tiktok" || jenis === "Komisi Shopee") {
                    orderInput.style.display = 'none';
                    orderInput.value = ''; 
                } else {
                    nominalInput.style.display = 'none';
                }
            }
            updateTotal();
        }

        function updateTotal() {
            let total = parseFloat(document.getElementById('gajipokok').value) || 0;

            document.querySelectorAll(".nominal-input").forEach(input => {
                let checkbox = document.getElementById('checkbox-' + input.name.match(/\d+/)[0]);
                let tipe = checkbox.getAttribute("data-tipe");
                if (checkbox.checked) {
                    let nominal = parseFloat(input.value) || 0;
                    total += (tipe === "Potongan") ? -nominal : nominal;
                }
            });

            document.querySelectorAll(".jumlah-order-input").forEach(input => {
                let checkbox = document.getElementById('checkbox-' + input.name.match(/\d+/)[0]);
                let nominalPerOrder = parseFloat(input.getAttribute("data-nominal")) ||
                0; 
                let jumlahOrder = parseFloat(input.value) || 0;

                if (checkbox.checked) {
                    total += jumlahOrder * nominalPerOrder;
                }
            });

            document.getElementById('total').value = "Rp " + total.toLocaleString('id-ID');
        }
    </script>
@endsection
