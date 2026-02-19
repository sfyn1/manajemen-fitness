<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $payout->payout_number }}</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; text-align: center; text-decoration: underline; }
        
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 150px; }

        .salary-box { border: 1px solid #333; padding: 20px; text-align: center; margin-bottom: 40px; }
        .amount { font-size: 28px; font-weight: bold; color: #000; }
        
        .footer { margin-top: 50px; text-align: right; }
        .sign-area { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 200px; text-align: center; padding-top: 5px; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">&larr; Kembali</button>
    </div>

    <div class="header">
        <div class="company-name">DURALUX GYM</div>
        <div>Jl. Fitness Sehat No. 123, Jakarta Selatan</div>
    </div>

    <div class="title">SLIP GAJI COACH</div>

    <table class="info-table">
        <tr>
            <td class="label">Nomor Slip</td>
            <td>: {{ $payout->payout_number }}</td>
        </tr>
        <tr>
            <td class="label">Nama Coach</td>
            <td>: {{ $payout->coach->name }}</td>
        </tr>
        <tr>
            <td class="label">Periode</td>
            <td>: {{ \Carbon\Carbon::createFromDate($payout->year, $payout->month, 1)->translatedFormat('F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Bayar</td>
            <td>: {{ \Carbon\Carbon::parse($payout->paid_at)->format('d F Y, H:i') }}</td>
        </tr>
    </table>

    <div class="salary-box">
        <div>Total Honorarium ({{ $payout->total_sessions }} Sesi)</div>
        <div class="amount">Rp {{ number_format($payout->total_amount, 0, ',', '.') }}</div>
    </div>

    <div class="footer">
        <div>Jakarta, {{ date('d F Y') }}</div>
        <div class="sign-area">
            Manager Keuangan
        </div>
    </div>

</body>
</html>