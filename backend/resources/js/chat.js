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
