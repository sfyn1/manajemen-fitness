<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji - {{ $payout->payout_number }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .meta-table { width: 100%; margin-bottom: 20px; }
        .meta-table td { padding: 5px; }
        .amount-box { border: 2px dashed #000; padding: 15px; text-align: center; margin-top: 30px; font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">GINTUNG MASTER FITNESS</div>
        <div>SLIP PEMBAYARAN GAJI COACH</div>
    </div>

    <table class="meta-table">
        <tr>
            <td width="150"><strong>Nomor Slip</strong></td>
            <td>: {{ $payout->payout_number }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Coach</strong></td>
            <td>: {{ $payout->coach->name }}</td>
        </tr>
        <tr>
            <td><strong>Periode Gaji</strong></td>
            <td>: {{ \Carbon\Carbon::create(null, $payout->month)->translatedFormat('F') }} {{ $payout->year }}</td>
        </tr>
    </table>

    <h3>Rincian:</h3>
    <ul>
        <li>Total Sesi Latihan yang Selesai: <strong>{{ $payout->total_sessions }} Sesi</strong></li>
        <li>Status Jadwal: <strong>Completed</strong></li>
    </ul>

    <div class="amount-box">
        Total Diterima: Rp {{ number_format($payout->total_amount, 0, ',', '.') }}
    </div>

    <br><br><br>
    <table width="100%">
        <tr>
            <td align="center">Diterima Oleh,</td>
            <td align="center">Keuangan,</td>
        </tr>
        <tr>
            <td height="80"></td>
            <td></td>
        </tr>
        <tr>
            <td align="center">({{ $payout->coach->name }})</td>
            <td align="center">(Admin)</td>
        </tr>
    </table>
</body>
</html>