<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #000;
        }

        thead tr {
            background-color: #015730;
            color: white;
        }

        tfoot tr {
            background-color: #015730;
            color: white;
        }

        address {
            margin-top: 10px;
            font-style: normal;
        }
    </style>
</head>

<body>
    <h2>Laporan Kategori: {{ ucfirst($category) }}</h2>
    <p>Periode: {{ $start_date }} s/d {{ $end_date }}</p>

    <strong>From</strong>
    <address>
        {{ $admin->name }}<br>
        Phone: {{ $admin->phone_num }}<br>
        Email: {{ $admin->email }}
    </address>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if ($category === 'order')
                    <th>Nama Sampah</th>
                    <th>Type</th>
                    <th>Total Berat</th>
                @elseif ($category === 'withdraw')
                    <th>Bank</th>
                    <th>Total Withdraw</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if ($category === 'order')
                        <td>{{ $item->trash_name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ number_format($item->total_weight, 0, ',', '.') }}</td>
                    @elseif ($category === 'withdraw')
                        <td>{{ $item->bank }}</td>
                        <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        @if ($data->isNotEmpty())
            <tfoot>
                <tr>
                    @if ($category === 'order')
                        <td colspan="3" style="text-align: right;"><strong>Total Berat:</strong></td>
                        <td><strong>{{ number_format($data->sum('total_weight'), 0, ',', '.') }}</strong></td>
                    @elseif ($category === 'withdraw')
                        <td colspan="2" style="text-align: right;"><strong>Total Withdraw:</strong></td>
                        <td><strong>Rp {{ number_format($data->sum('total_amount'), 0, ',', '.') }}</strong></td>
                    @endif
                </tr>
            </tfoot>
        @endif
    </table>
</body>

</html>
