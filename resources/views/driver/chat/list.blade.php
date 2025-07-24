@extends('driver.partials.driver')

@section('title', __('list_chat.title'))

@push('styles')
<link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
<style>
    .chat-card {
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .lihat-chat-btn {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 8px;
    }
</style>
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0"><b>{{ __('list_chat.header.title') }}</b></h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="container my-4">
                <div class="card card-light mb-4">
                    <div class="card-header">
                        <div class="card-title">
                            <b>{{ __('list_chat.header.greeting', ['name' => Auth::check() ? Auth::user()->name : 'Driver']) }}</b>
                        </div>
                    </div>

                    <div class="card-body row p-5">
                        <div class="col-md-12">
                            @forelse ($chats as $chat)
                                <div class="row align-items-center chat-card">
                                    <div class="col-12 col-md-8 mb-2 mb-md-0">
                                        <div class="text-success fw-semibold">
                                            {{ __('list_chat.labels.user_name') }}: {{ $chat->user->name }}
                                        </div>
                                        @if ($chat->updated_at)
                                            <div class="text-muted">
                                                {{ __('list_chat.labels.last_update') }}: {{ $chat->updated_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        {{-- <a href="{{ route('driver.chat', ['chat_id' => $chat->chat_id]) }}"
                                            class="btn btn-outline-success lihat-chat-btn w-100 w-md-auto mt-2 mt-md-0">
                                            {{ __('list_chat.labels.view_chat') }}
                                        </a> --}}
                                        <a href="{{ URL::signedRoute('driver.chat', ['chat_id' => $chat->chat_id]) }}"
                                            class="btn btn-outline-success lihat-chat-btn w-100 w-md-auto mt-2 mt-md-0">
                                            {{ __('list_chat.labels.view_chat') }}
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted my-4">
                                    <p>{{ __('list_chat.labels.no_chats') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection
