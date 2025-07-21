<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Chat</title>
    <link rel="stylesheet" href="{{ asset('assets/css/indexdriver.css') }}">
</head>
<body>
    {{-- <div class="back-section px-1 py-5 mb-2"
        style="height:50px; border-bottom:1px solid rgb(255, 255, 255); padding:10px; background-color:#0f2900;">

        <a href="{{ $pickupId ? url('/driver/pickup/' . $pickupId) : url('/driver/pickup') }}" class="back-link d-flex align-items-center gap-2"
        style="color:rgb(255, 255, 255); font-weight: normal; text-decoration: none; padding:5px; height:100%;">

            <img src="{{ asset('assets/img/panah.png') }}"
                alt="Back"
                style="width:18px; height:20px; object-fit: contain;">

            <span style="line-height: 1; font-size: 16px;">Kembali</span>
        </a>
    </div> --}}

    @php
        $pickupId = request('pickup_id');
    @endphp

    <div class="back-section px-1 py-5 mb-2"
        style="height:50px; border-bottom:1px solid rgb(255, 255, 255); padding:10px; background-color:#0f2900;">

        <a href="{{ $pickupId ? url('/driver/pickup/' . $pickupId) : route('driver.chat.list') }}"
            class="back-link d-flex align-items-center gap-2"
            style="color:rgb(255, 255, 255); font-weight: normal; text-decoration: none; padding:5px; height:100%;">

            <img src="{{ asset('assets/img/panah.png') }}"
                alt="Back"
                style="width:18px; height:20px; object-fit: contain;">

            <span style="line-height: 1; font-size: 16px;">Kembali</span>
        </a>
    </div>

    <div class="chat-messages" id="chat-messages">
        @foreach($messages as $message)
            @php
                $isSent = $message->user_id == Auth::id();
            @endphp

            @if(!$isSent)
                <div class="sender-name">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile">
                    {{ $message->user->name ?? 'Pelanggan' }}
                </div>
            @endif

            <div class="message {{ $isSent ? 'sent' : 'received' }}">
                <div class="message-content">
                    <p class="pp">{{ $message->detail_chat }}</p>
                    <span class="message-time">{{ $message->date_time->format('H.i') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="chat-input-container">
        <form id="chat-form" class="chat-input-form">
            @csrf
            <input type="hidden" name="chat_id" value="{{ $chat->chat_id }}">
            <input type="text" name="message" class="chat-input" placeholder="Ketik pesan..." autocomplete="off">
            <button type="submit" class="send-button">Kirim</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const chat_id = {{ $chat->chat_id }};
        const currentUser = {{ Auth::id() }};

        $(document).ready(function () {
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);

            $('#chat-form').on('submit', function (e) {
                e.preventDefault();
                const messageInput = $('.chat-input');
                const message = messageInput.val().trim();

                if (message) {
                    $.ajax({
                        url: '{{ route("driver.chat.send") }}',
                        method: 'POST',
                        data: $(this).serialize(),
                        beforeSend: function () {
                            $('#chat-messages').append(`
                                <div class="message sent">
                                    <div class="message-content">
                                        <p>${message}</p>
                                        <span class="message-time">...</span>
                                    </div>
                                </div>
                            `);
                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                            messageInput.val('');
                        },
                        success: function () {
                            fetchMessages();
                        },
                        error: function () {
                            alert('Gagal mengirim pesan');
                        }
                    });
                }
            });

            setInterval(fetchMessages, 3000);

            function fetchMessages() {
                $.get('{{ route("chat.messages") }}', { chat_id: chat_id }, function (response) {
                    const messagesContainer = $('#chat-messages');
                    const shouldScroll = messagesContainer.scrollTop() + messagesContainer.innerHeight() >= messagesContainer[0].scrollHeight - 50;

                    messagesContainer.html('');

                    response.forEach(function (message) {
                        const isSent = message.user_id == currentUser;
                        const messageClass = isSent ? 'sent' : 'received';

                        const time = new Date(message.date_time).toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        }).replace(':', '.');


                        if (!isSent && message.user) {
                            messagesContainer.append(`
                                <div class="sender-name">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile">
                                    ${message.user.name}
                                </div>
                            `);
                        }

                        messagesContainer.append(`
                            <div class="message ${messageClass}">
                                <div class="message-content">
                                    <p class="pp">${message.detail_chat}</p>
                                    <span class="message-time">${time}</span>
                                </div>
                            </div>
                        `);

                    });

                    if (shouldScroll) {
                        messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
                    }
                });
            }
        });
    </script>
</body>
</html>
