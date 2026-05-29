<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $payout->payout_number }}</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; text-align: center; text-decoration: underline; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 160px; }
        .salary-box { border: 1px solid #333; padding: 20px; text-align: center; margin-bottom: 20px; }
        .amount { font-size: 28px; font-weight: bold; }
        .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .detail-table th, .detail-table td { border: 1px solid #ccc; padding: 8px; }
        .detail-table th { background: #f5f5f5; }
        .badge-pt { background: #6f42c1; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
        .badge-group { background: #0d6efd; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
        .footer { margin-top: 50px; text-align: right; }
        .sign-area { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 200px; text-align: center; padding-top: 5px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">&larr; Kembali</button>
    </div>

    <div class="header">
        <div class="company-name">DURALUUX GYM</div>
        <div>Jl. Fitness Sehat No. 123</div>
    </div>

    <div class="title">
        SLIP GAJI &mdash;
        @if($payout->payout_type === 'monthly_salary')
            <span class="badge-pt">PERSONAL TRAINER</span>
        @else
            <span class="badge-group">GROUP CLASS COACH</span>
        @endif
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nomor Slip</td>
            <td>: {{ $payout->payout_number }}</td>
        </tr>
        <tr>
            <td class="label">Nama</td>
            <td>: {{ $payout->coach->name }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td>: {{ $payout->coach->coach_type_label }}</td>
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

    @if($payout->payout_type === 'monthly_salary')
    {{-- PERSONAL TRAINER --}}
    <table class="detail-table">
        <tr>
            <th>Komponen</th>
            <th class="text-right" style="text-align:right;">Jumlah</th>
        </tr>
        <tr>
            <td>Gaji Pokok Bulanan</td>
            <td style="text-align:right;">Rp {{ number_format($payout->base_salary, 0, ',', '.') }}</td>
        </tr>
        @if($payout->bonus > 0)
        <tr>
            <td>Bonus</td>
            <td style="text-align:right;">Rp {{ number_format($payout->bonus, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr style="font-weight:bold; background:#f9f9f9;">
            <td>TOTAL</td>
            <td style="text-align:right;">Rp {{ number_format($payout->total_amount, 0, ',', '.') }}</td>
        </tr>
    </table>
    @else
    {{-- GROUP COACH --}}
    <table class="detail-table">
        <tr>
            <th>Komponen</th>
            <th style="text-align:right;">Jumlah</th>
        </tr>
        <tr>
            <td>Total Sesi Diajarkan</td>
            <td style="text-align:right;">{{ $payout->total_sessions }} sesi</td>
        </tr>
        <tr>
            <td>Total Honorarium</td>
            <td style="text-align:right;">Rp {{ number_format($payout->total_amount, 0, ',', '.') }}</td>
        </tr>
    </table>
    @endif

    <div class="salary-box">
        <div>Jumlah Diterima</div>
        <div class="amount">Rp {{ number_format($payout->total_amount, 0, ',', '.') }}</div>
        @if($payout->notes)
        <div style="font-size:12px; color:#666; margin-top:5px;">Catatan: {{ $payout->notes }}</div>
        @endif
    </div>

    <div class="footer">
        <div>{{ date('d F Y') }}</div>
        <div class="sign-area">Manager Keuangan</div>
    </div>

</body>
</html>