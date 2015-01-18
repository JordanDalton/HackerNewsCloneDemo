<script type="text/javascript">
    $('a[id^="{{ $selector }}"]').on('click', function(event)
    {
        event.preventDefault();

        var $this = $(this);

        // The url where the request will be sent.
        //
        var target_url = $(this).data('target-url');

        $.ajax({
            'type' : 'POST',
            'url'  : target_url,
            'data' : {
                'now'   : $.now(),
                '_token': '{{ csrf_token() }}'
            },
            beforeSend: function(xhr)
            {
                {{-- If the user is not logged in then pop up a modal window. --}}
                @if( ! Auth::check())
                    $('#loginRequiredModal').modal('show');
                    xhr.abort();
                @endif
            }
        }).done(function(response)
        {
            // Hide the vote up button.
            //
            $this.toggleClass('btn-success').text('Thank you for voting.');
        });
    });
</script>