
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <div class="mt-5" id="chat_room">
        @foreach($messages as $message)
            @if($message->sender == Auth::user()->id)
                <div class="receive" style="text-align: right;">
                    <p>{!! nl2br(e($message->message)) !!}</p>
                </div>
            @elseif($message->sender !== Auth::user()->id )
            <div class="send" style="text-align:left;">
                <p>{!! nl2br(e($message->message)) !!}</p>
            </div>
            @endif
        @endforeach
    </div>
    <div class="">
        <form id="chat_form" >
            @csrf
                {{-- <input type="text" name="message" id="message"> --}}
                <textarea name="message" id="message"></textarea>
                <input type="hidden" name="receiver" id="receiver" value="{{ $chat_user->id }}">
                <input type="hidden" name="sender" id="sender" value="{{ Auth::user()->id }}">
                <button type="submit" id="btn_send">送信</button>
        </form>
    </div>

<script>
    $(document).ready(function() {
    // Listen for form submission
    $('#chat_form').submit(function(event) {
        event.preventDefault();

        // Get form data
        var formData = {
            'message': $('textarea[name=message]').val(),
            'receiver': $('input[name=receiver]').val(),
            'sender': $('input[name=sender]').val()
        };

        // Send AJAX request to server
        $.ajax({
            type: 'POST',
            url: '{{ route("chat.store") }}',
            data: formData,
            dataType: 'json',
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            success: function(response) {
                console.log(response);
                $('textarea[name=message]').val('');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});

    window.Echo.channel('chat')
        .listen('.chat_event', function(data) {
            var message = data.message;
            var sender = data.sender;
            var html = '';
            if (sender == "{{ Auth::user()->id }}") {
                html += '<div class="receive" style="text-align: right;">';
            } else {
                html += '<div class="send" style="text-align: left;">';
            }
            html += '<p>' + message.replace(/\n/g, "<br>") + '</p>';
            html += '</div>';
            $("#chat_room").append(html);
        });
</script>

</body>
</html>
