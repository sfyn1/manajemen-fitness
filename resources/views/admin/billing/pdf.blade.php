<!DOCTYPE html>
<html>
<head>
    <title>Laporan Membership</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e0e0e0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>GINTUNG MASTER FITNESS</h2>
        <p>Laporan Pendapatan Membership</p>
        <small>Tanggal Cetak: {{ date('d F Y') }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Member</th>
                <th>Paket</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->invoice_number }}</td>
                <td>{{ $trx->user->name ?? 'User Terhapus' }}</td>
                <td>
                    @foreach($trx->items as $item)
                        {{ $item->name }}<br>
                    @endforeach
                </td>
                <td class="text-right">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>