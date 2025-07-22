<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ __('print_pdf.title') }}</title>
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
    <h2>{{ __('print_pdf.header.report_category', ['category' => ucfirst($category)]) }}</h2>
    <p>{{ __('print_pdf.header.period', ['start_date' => $start_date, 'end_date' => $end_date]) }}</p>

    <strong>{{ __('print_pdf.header.from') }}</strong>
    <address>
        {{ $admin->name }}<br>
        {{ __('print_pdf.contact_info.phone', ['phone' => $admin->phone_num]) }}<br>
        {{ __('print_pdf.contact_info.email', ['email' => $admin->email]) }}
    </address>

    <table>
        <thead>
            <tr>
                <th>{{ __('print_pdf.table.no') }}</th>
                @if ($category === 'order')
                    <th>{{ __('print_pdf.table.columns.order.trash_name') }}</th>
                    <th>{{ __('print_pdf.table.columns.order.type') }}</th>
                    <th>{{ __('print_pdf.table.columns.order.total_weight') }}</th>
                @elseif ($category === 'withdraw')
                    <th>{{ __('print_pdf.table.columns.withdraw.bank') }}</th>
                    <th>{{ __('print_pdf.table.columns.withdraw.total_amount') }}</th>
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
                        <td colspan="3" style="text-align: right;">
                            <strong>{{ __('print_pdf.table.footer.order.total_label') }}</strong>
                        </td>
                        <td>
                            <strong>
                                {{ __('print_pdf.table.footer.order.total_value', ['total' => number_format($data->sum('total_weight'), 0, ',', '.')]) }}
                            </strong>
                        </td>
                    @elseif ($category === 'withdraw')
                        <td colspan="2" style="text-align: right;">
                            <strong>{{ __('print_pdf.table.footer.withdraw.total_label') }}</strong>
                        </td>
                        <td>
                            <strong>
                                {{ __('print_pdf.table.footer.withdraw.total_value', ['total' => number_format($data->sum('total_amount'), 0, ',', '.')]) }}
                            </strong>
                        </td>
                    @endif
                </tr>
            </tfoot>
        @endif
    </table>
</body>

</html>
