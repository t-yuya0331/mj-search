@extends('layouts.app')

@section('title','ChatList')

@section('content')
<div class="chat-container">
    @if($messages->isNotEmpty())
        <div class="chat-history">
            <div class="mt-5" id="chat_room">
                @foreach($messages as $message)
                    @if($message->sender == Auth::user()->id)
                        <div class="chat-message chat-message-right">
                            <div class="chat-bubble">
                                <p>{!! nl2br(e($message->message)) !!}</p>
                            </div>
                        </div>
                    @elseif($message->sender !== Auth::user()->id )
                        <div class="chat-message chat-message-left">
                            <div class="chat-bubble">
                                <p>{!! nl2br(e($message->message)) !!}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <div class="chat-input">
        <form id="chat_form" >
            @csrf
                <div class="row justify-content-center">
                    <div class="col-auto ">
                        <textarea name="message" id="message"></textarea>
                        <input type="hidden" name="receiver" id="receiver" value="{{ $chat_user->id }}">
                        <input type="hidden" name="sender" id="sender" value="{{ Auth::user()->id }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" id="btn_send">送信</button>
                    </div>
                </div>
        </form>
    </div>
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
            var html = '';
                if (response.sender == "{{ Auth::user()->id }}") {
                    html += '<div class="chat-message chat-message-right">';
                } else {
                    html += '<div class="chat-message chat-message-left">';
                }
                html += '<div class="chat-bubble">';
                html += '<p>' + response.message.replace(/\n/g, "<br>") + '</p>';
                html += '</div>';
                html += '</div>';

                $("#chat_room").append(html);
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
@endsection
