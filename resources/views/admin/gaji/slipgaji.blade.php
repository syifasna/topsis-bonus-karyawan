<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji {{ $gaji->karyawan->nama }} - {{ $periode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .slip-gaji {
            width: 80%;
            border: 1px solid #000;
            padding: 70px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-text {
            flex: 1;
        }
        .info img {
            width: 150px; 
            height: auto;
        }
        .penghasilan, .potongan {
            margin-bottom: 10px;
        }
        .penghasilan table, .potongan table {
            width: 100%;
            border-collapse: collapse;
        }
        .penghasilan th, .potongan th {
            text-align: left;
            padding: 5px;
        }
        .penghasilan td, .potongan td {
            padding: 5px;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .terbilang {
            font-style: italic;
            text-align: center;
            margin-top: 10px;
        }
        .nom {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="slip-gaji">
        <div class="header">Slip Gaji {{ $periode }}</div>
        <table width="100%">
            <tr>
                <td>
                    <p><strong>Nama :</strong> {{ $gaji->karyawan->nama }}</p>
                    <p><strong>Jabatan :</strong> {{ $gaji->karyawan->jabatan->jabatan }}</p>
                </td>
                <td style="text-align: right;">
                    <img src="{{ public_path('assets/img/logo-ct-dark.png') }}" width="150">
                </td>
            </tr>
        </table>        
        <hr>

        <div class="penghasilan">
            <table border="0">
                <tr>
                    <th colspan="2">PENGHASILAN</th>
                </tr>
                <tr>
                    <td>Gaji Pokok</td>
                    <td class="nom">@currency($gaji->karyawan->jabatan->gajipokok)</td>
                </tr>
                @foreach ($penghasilan as $item)
                <tr>
                    <td>{{ $item->jenis }}</td>
                    <td class="nom">@currency($item->pivot->nominal)</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="potongan">
            <table border="0">
                <tr>
                    <th colspan="3">POTONGAN</th>
                </tr>
                @if ($izin > 0)
                <tr>
                    <td>Izin</td>
                    <td style="text-align: right">{{ $izin }} hari</td>
                    <td class="nom">@currency($potongan_izin)</td>
                </tr>
                @endif
                @if ($sakit > 0)
                <tr>
                    <td>Sakit</td>
                    <td style="text-align: right">{{ $sakit }} hari</td>
                    <td class="nom">@currency($potongan_sakit)</td>
                </tr>
                @endif
                @foreach ($potongan as $item)
                <tr>
                    <td>{{ $item->jenis }}</td>
                    <td>-</td>
                    <td class="nom">@currency($item->pivot->nominal)</td>
                </tr>
                @endforeach
            </table>
        </div>        

        <div class="potongan">
            <table border="0">
                <tr>
                    <th colspan="2">TOTAL</th>
                    <td class="nom" style="font-weight: bold">@currency($gajiFinal)</td>
                </tr>
            </table>
        </div>

        <div class="terbilang">
            <p><b>Terbilang :</b> {{ ucfirst($gaji->terbilang) }} Rupiah</p>
        </div>
    </div>
</body>
</html>
