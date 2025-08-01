@extends('pengguna.partials.pengguna')

@section('title', 'Histori Penukaran')


@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <style>
        .star-rating {
            font-size: 24px;
            margin: 10px 0;
        }

        .star-rating i {
            color: #616161;
            /* Warna default bintang kosong */
            cursor: pointer;
            transition: color 0.2s;
            padding: 0 2px;
        }

        .star-rating i.selected,
        .star-rating i:hover,
        .star-rating i:hover~i {
            color: #FFD700;
            /* Warna kuning emas */
            text-shadow: 0 0 2px rgba(255, 215, 0, 0.5);
        }

        .star-rating i.fa-star {
            color: #FFD700;
            /* Warna untuk bintang terisi */
        }

        .star-rating i.fa-star-o {
            color: #616161;
            /* Warna untuk bintang kosong */
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 95%;
            margin: 0 auto;
        }

        @media (max-width: 576px) {
            .lihat-detail-btn {
                font-size: 14px;
                padding: 8px 12px;
            }

            .modal-content {
                padding: 15px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/histori-user.js') }}"></script>
@endpush


@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0"><b>{{ __('history_user.header') }}</b></h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="container my-4">
                    <div class="card card-light mb-4">
                        <div class="card-header">
                            <div class="card-title">
                                <b>
                                    @if (session('success'))
                                        {{ session('success') }}
                                    @else
                                        {{ __('history_user.greeting', ['name' => Auth::check() ? Auth::user()->name : 'Pengguna']) }}
                                    @endif
                                </b>
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                @if ($orderlist->count())
                                    @foreach ($orderlist as $order)
                                        @php
                                            // Status badge logic
                                            // dd($order->approval);
                                            if (!isset($order->approval)) {
                                                $badgeClass = 'bg-secondary';
                                                $label = __('history_user.status.no_approval');
                                            } else {
                                                $status = $order->approval->approval_status;

                                                if (is_null($status)) {
                                                    $badgeClass = 'bg-secondary';
                                                    $label = __('history_user.status.in_process');
                                                } elseif ($status === 1) {
                                                    $badgeClass = 'bg-success';
                                                    $label = __('history_user.status.approved');
                                                } elseif ($status === 0) {
                                                    $badgeClass = 'bg-danger';
                                                    $label = __('history_user.status.rejected');
                                                } else {
                                                    $badgeClass = 'bg-warning text-dark';
                                                    $label = __('history_user.status.unknown');
                                                }
                                            }

                                            // Create trash summary text
                                            $trashSummary = $order->details->map(function($detail) {
                                                return $detail->quantity . 'kg ' . $detail->trash->name;
                                            })->implode(', ');

                                            // Create HTML table for modal
                                            $htmlSummary = '<table class="table table-bordered text-sm"><thead><tr>
                                                <th>' . __('history_user.table.no') . '</th>
                                                <th>' . __('history_user.table.trash_name') . '</th>
                                                <th>' . __('history_user.table.quantity') . '</th>
                                                <th>' . __('history_user.table.price_per_kg') . '</th>
                                                <th>' . __('history_user.table.total') . '</th>
                                            </tr></thead><tbody>';

                                            $total = 0;
                                            foreach ($order->details as $index => $detail) {
                                                $qty = $detail->quantity;
                                                $price = $detail->trash->price_per_kg;
                                                $subtotal = $qty * $price;
                                                $total += $subtotal;
                                                $htmlSummary .= "<tr>
                                                    <td>" . ($index + 1) . "</td>
                                                    <td>{$detail->trash->name}</td>
                                                    <td>{$qty}</td>
                                                    <td>Rp. " . number_format($price, 0, ',', '.') . "</td>
                                                    <td>Rp. " . number_format($subtotal, 0, ',', '.') . "</td>
                                                </tr>";
                                            }

                                            $htmlSummary .= "<tr><td colspan='4'><b>" . __('history_user.table.total_earned') . "</b></td>
                                                <td><b>Rp. " . number_format($total, 0, ',', '.') . '</b></td></tr>';
                                            $htmlSummary .= '</tbody></table>';
                                        @endphp

                                        <div class="mb-3 p-3 rounded" style="background-color: #f9fdf9; border: 1px solid #d4ecd4;">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="fw-semibold text-success">
                                                        @if ($order->approval && $order->approval->approval_status === 1)
                                                            Rp{{ number_format($total, 0, ',', '.') }}
                                                        @else
                                                            Rp0
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-8 mb-2 mb-md-0">
                                                    <div class="text-muted">
                                                        {{ \Carbon\Carbon::parse($order->date_time_request)->translatedFormat('l, d M Y') }}
                                                    </div>
                                                    <div class="text-success fw-semibold text-truncate" style="max-width: 100%;" title="{{ $trashSummary }}">
                                                        {{ $trashSummary }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 text-md-end">
                                                    <button class="btn btn-outline-success lihat-detail-btn w-100 w-md-auto mt-2 mt-md-0"
                                                        data-date="{{ \Carbon\Carbon::parse($order->date_time_request)->translatedFormat('l, d M Y') }}"
                                                        data-address="{{ $order->user->info->address }}, {{ $order->user->info->city }}, {{ $order->user->info->province }}, {{ $order->user->info->postal_code }}"
                                                        data-driver="{{ $order->pickup->user->name ?? __('history_user.status.waiting_driver') }}"
                                                        data-summary="{!! htmlspecialchars($htmlSummary) !!}"
                                                        data-order-id="{{ $order->order_id }}"
                                                        data-user-id="{{ auth()->id() }}">
                                                        {{ __('history_user.view_details') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted my-4">
                                        <p>{{ __('history_user.no_history') }}</p>
                                    </div>
                                @endif
                            </div>

                            @if ($orderlist->count())
                                {{-- Modal Detail --}}
                                <div id="historiModal" class="modal-overlay" style="display: none;">
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge" id="modal-status-badge"></span><br>
                                                <strong>{{ __('history_user.modal.date') }} <span id="modal-date"></span></strong><br>
                                                <strong>{{ __('history_user.modal.address') }} <span id="modal-address"></span></strong><br>
                                                <strong>{{ __('history_user.modal.driver') }} <span id="modal-driver"></span></strong><br>
                                            </div>
                                            <button class="close-btn btn btn-sm btn-light" style="font-size: 1.25rem; line-height: 1; padding: 0 10px;">&times;</button>
                                        </div>
                                        <div>
                                            <h6>{{ __('history_user.modal.summary') }}</h6>
                                            <div class="bg-light p-2 mb-2" id="modal-summary"></div>
                                        </div>
                                        <div class="mb-2">
                                            {{-- <h6>{{ __('history_user.modal.rating') }}</h6>
                                            <div id="rating-stars" class="star-rating">
                                                <i class="far fa-star" data-value="1"></i>
                                                <i class="far fa-star" data-value="2"></i>
                                                <i class="far fa-star" data-value="3"></i>
                                                <i class="far fa-star" data-value="4"></i>
                                                <i class="far fa-star" data-value="5"></i>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
