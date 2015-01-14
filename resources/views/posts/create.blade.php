@extends($layout)

@section('pageTitle')
    Submit | @parent
@stop

@section('content')
<!-- .container -->
<div class="container">
    <!-- .row -->
    <div class="row">
        <!-- .col-lg-12 -->
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Submit Post</h1>
                <p>Leave url blank to submit a question for discussion. If there is no url, the text (if any) will appear at the top of the thread.</p>
                <p>If you would like to show your site off start your title with <code>{{ Config::get('settings.show_title_prefix') }}</code> or you can <a id="prefixShowTitle" class="underlined">click here</a> and we'll add it for you.</p>
            </div>

                {{-- Display message when a post is successfully submitted. --}}
                @if( Session::has('post_added'))
                    <div class="alert alert-success">
                        You post was successfully added.
                    </div>
                @endif

                @include('layouts.partials.errors')

                {!! Form::model( $post ) !!}
                    @include('posts._fields')
                    <!-- Submit Form -->
                    <div class="form-group">
                        {!! Form::button('submit', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                    </div>
                {!! Form::close() !!}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
@stop

{{-- Embed javascript into the footer of the page. --}}
@section('footer_embedded_js')
    <script type="text/javascript">
        $('#prefixShowTitle').on('click', function(event)
        {
            event.preventDefault();

            // Get the current value of the title field.
            //
            var get_title_value = $('#title').val();

            // Capture the show_title_prefix from the config/settings.php file.
            //
            var show_title_prefix = '{{ Config::get("settings.show_title_prefix") }}';

            // Now prefix the existing title as long as it is not already prefixed.
            //
            if( ! get_title_value.match("^" + show_title_prefix))
            {
                $('#title').val( show_title_prefix + get_title_value ).focus();
            }
        });
    </script>
@stop