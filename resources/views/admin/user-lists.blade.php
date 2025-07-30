@extends('admin.partials.admin')

@section('title', __('response_admin.title'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@push('styles')
<style>
    #laporanTable {
        --bs-table-bg: #026733;
        --bs-table-color: #ffffff;
        --bs-table-striped-bg: #006837;
        --bs-table-striped-color: #ffffff;
        --bs-table-hover-bg: #075c31;
        --bs-table-hover-color: #ffffff;
        --bs-table-border-color: #01733d;
    }

    #laporanTable thead th {
        background-color: #02341c;
        color: #ffffff;
    }

    #laporanTable td {
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: #004d25;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#laporanTable');
    });
</script>
@endpush

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="app-content-header">
            <div class="row page-title">
                <div class="col-sm mt-3 mb-0">
                    <h3>{{ 'Block and Activate Page' }}</h3>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ __('response_admin.alerts.success', ['message' => session('success')]) }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mt-1">
            <div class="card-header text-white" style="background-color: #0e6b3b">
                <h5 class="card-title">{{ 'User Lists' }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="laporanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{'id'}}</th>
                                <th>{{'name'}}</th>
                                <th>{{'phone num'}}</th>
                                <th>{{'status'}}</th>
                                <th>{{'action'}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="modalLabel{{ $user->user_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="modalLabel{{ $user->user_id }}">
                                                    {{ __('response_admin.modal.title', ['id' => $user->user_id]) }}
                                                </h5>
                                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                <p><strong>{{ 'id user' }}:</strong> {{ $user->user_id }}</p>
                                                <p><strong>{{ 'name' }}:</strong> {{ $user->name }}</p>
                                                <p><strong>{{ 'number' }}:</strong> {{ $user->phone_num }}</p>
                                                <p><strong>{{ 'status' }}:</strong> {{ $user->status == 0 ? 'Active' : 'Blocked' }}</p>
                                                @if ($user->profile_pic)
                                                    <p><strong>{{ __('response_admin.modal.fields.photo') }}:</strong></p>
                                                    <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Foto Bukti" class="img-fluid mb-3 rounded shadow" style="max-height: 300px;"
                                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/default.png') }}';">
                                                @endif
                                            </div>
                                            <form action="{{ route('admin.user-lists.update', $user->user_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $user->status == 0 ? 1 : 0 }}">
                                                <button type="submit" class="btn {{ $user->status == 0 ? 'btn-danger' : 'btn-success' }}">
                                                    {{ $user->status == 0 ? 'Block' : 'Unblock' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone_num }}</td>
                                <td>{{ $user->status == 0 ? 'Active' : 'Blocked' }}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background-color: #E5F5E0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $user->user_id }}">
                                        {{ $user->status == 0 ? 'Block' : 'Unblock' }}
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background-color: #E5F5E0"
                                            data-bs-toggle="log"
                                            data-bs-target="#detaillogagamtercinta{{ $user->user_id }}">
                                        buat agam tercinta
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
