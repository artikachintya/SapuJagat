
@extends('pengguna.partials.pengguna')

@section('title', __('chat.title'))

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/indexpengguna.css') }}">
    <main class="app-main container mt-0 mb-0 pb-0">
        <div class="chat-container">

            <div class="back-section px-1 py-3 mb-2" style="border-bottom:1px solid rgb(237, 237, 237);">
                <a href="{{ route('pengguna.pelacakan.index')}}" class="back-link" style="color:black; font-weight: normal;">
                    <img src="{{ asset('assets/img/panah.png') }}" alt="Back" class="back-arrow" style="width:18px;height:18px;">
                    {{ __('chat.common.back') }}
                </a>
            </div>

            <div class="messages-wrapper" id="messages-wrapper">
                @foreach($messages as $message)
                    @if($message->user_id == Auth::id())
                        <div class="user-message">
                            <div class="message-content-user">
                                    <p class="p">{{ $message->detail_chat }}</p>
                                    <span class="message-time">{{ $message->date_time->format('H.i') }}</span>

                            </div>
                        </div>
                    @else
                        <div class="driver-message">
                            <div class="message-content">
                                {{-- <img src="{{ asset('assets/img/profile.jpg') }}" alt="Foto Profil" class="profile-img"> --}}
                                {{-- <img src="{{ $message->user->profile_pic }}" alt="Foto Profil" class="profile-img"> --}}
                                <img src="{{ $message->user->profile_pic ? asset('storage/' . $message->user->profile_pic) : asset('assets/img/default-profile.webp') }}" alt="Foto Profil" class="profile-img">

                                <div class="message-bubble">
                                    <div class="message-info">
                                        <span class="sender-name">{{ $message->user->name }}</span>
                                    </div>
                                    <p class="message-text">{{ $message->detail_chat }}</p>
                                    <span class="message-time">{{ $message->date_time->format('H.i') }}</span>
                                </div>
                            </div>
                        </div>
                     @endif

                @endforeach
            </div>

            <div class="input-section">
                <form id="chat-form" class="chat-form">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $chat->chat_id }}">
                   <input type="text" name="message" class="message-input" placeholder="{{ __('chat.common.message_placeholder') }}">
<button type="submit" class="send-button">{{ __('chat.common.send') }}</button>

                </form>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            const chat_id = {{ $chat->chat_id }};
            $(document).ready(function() {
                $('#messages-wrapper').scrollTop($('#messages-wrapper')[0].scrollHeight);

                $('#chat-form').on('submit', function(e) {
                    e.preventDefault();
                    const message = $('.message-input').val().trim();

                    if(message) {
                        $.ajax({
                            url: '{{ route("pengguna.chat.send") }}',
                            method: 'POST',
                            data: $(this).serialize(),
                            success: function() {
                                $('.message-input').val('');
                                fetchMessages();
                            }
                        });
                    }
                });

                setInterval(fetchMessages, 3000);

                function fetchMessages() {
                    // agar scroll bisa
                    const wrapper = $('#messages-wrapper');
                    const isNearBottom = wrapper[0].scrollHeight - wrapper.scrollTop() - wrapper.outerHeight() < 100;

                    $.get('{{ route("chat.messages") }}', { chat_id: chat_id }, function(response) {
                        // $('#messages-wrapper').html('');
                        const oldScrollHeight = wrapper[0].scrollHeight;
                        wrapper.html('');

                        response.forEach(function(message) {
                            const isUser = message.user_id == {{ Auth::id() }};
                            const time = new Date(message.date_time).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            }).replace(':', '.');

                            if(isUser) {
                                wrapper.append(`
                                    <div class="user-message">
                                        <div class="message-content-user">
                                                <p class="p">${message.detail_chat}</p>
                                                <span class="message-time">${time}</span>
                                        </div>
                                    </div>
                                `);
                            } else {
                            // wrapper.append(`
                            //     <div class="driver-message">
                            //         <div class="message-content">
                            //             <img src="${message.user.profile_pic}" alt="Foto Profil" class="profile-img">
                            //             <div class="message-bubble">
                            //                 <div class="message-info">
                            //                     <span class="sender-name">${message.user.name}</span>
                            //                 </div>
                            //                 <p class="message-text">${message.detail_chat}</p>
                            //                 <span class="message-time">${time}</span>
                            //             </div>
                            //         </div>
                            //     </div>
                            // `);
                            const profilePic = message.user.profile_pic
                                ? `/storage/${message.user.profile_pic}`
                                : `/assets/img/default-profile.webp`;

                            wrapper.append(`
                                <div class="driver-message">
                                    <div class="message-content">
                                        <img src="${profilePic}" alt="Foto Profil" class="profile-img">
                                        <div class="message-bubble">
                                            <div class="message-info">
                                                <span class="sender-name">${message.user.name}</span>
                                            </div>
                                            <p class="message-text">${message.detail_chat}</p>
                                            <span class="message-time">${time}</span>
                                        </div>
                                    </div>
                                </div>
                            `);

                            }
                        });

                        if (isNearBottom) {
                            wrapper.scrollTop(wrapper[0].scrollHeight);
                        }
                    });
                }
            });
        </script>
@endsection
