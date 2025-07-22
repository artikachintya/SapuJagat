@extends('admin.partials.admin')

@section('title', __('trash_archive.title'))

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-sm">
                    <a href="{{ route('admin.jenis-sampah.index') }}" class="btn btn-danger">
                        {{ __('trash_archive.page.back_button') }}
                    </a>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('trash_archive.breadcrumb.home') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('trash_archive.breadcrumb.current') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">{{ __('trash_archive.page.title') }}</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ __('trash_archive.alerts.success', ['message' => session('success')]) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <table class="table table-striped align-middle">
                        <colgroup>
                            <col style="width: 5%;">
                            <col style="width: 20%;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 30%;">
                        </colgroup>

                        <thead>
                            <tr>
                                <th>{{ __('trash_archive.table.headers.id') }}</th>
                                <th>{{ __('trash_archive.table.headers.name') }}</th>
                                <th>{{ __('trash_archive.table.headers.type') }}</th>
                                <th>{{ __('trash_archive.table.headers.price') }}</th>
                                <th>{{ __('trash_archive.table.headers.max_weight') }}</th>
                                <th>{{ __('trash_archive.table.headers.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trashes as $trash)
                                <tr>
                                    <td>{{ $trash->trash_id }}</td>
                                    <td>{{ $trash->name }}</td>
                                    <td>{{ $trash->type }}</td>
                                    <td>{{ $trash->price_per_kg }}</td>
                                    <td>{{ $trash->max_weight }} kg</td>
                                    <td style="width: 1%; white-space: nowrap;">
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="{{ route('admin.jenis-sampah.restore', $trash->trash_id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-arrow-clockwise"></i> {{ __('trash_archive.table.actions.restore') }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.jenis-sampah.force-delete', $trash->trash_id) }}" onsubmit="return confirm('{{ __('trash_archive.table.actions.delete_confirm') }}')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash3"></i> {{ __('trash_archive.table.actions.force_delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-white">
                                        {{ __('trash_archive.table.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
