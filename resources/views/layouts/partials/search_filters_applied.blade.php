{{-- Make the user aware of any search filters being applied to the results. --}}
@if( Input::get($searchGroup))
<div role="alert" class="alert alert-warning alert-dismissible fade in">
    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4>Results are being filtered.</h4>
    <p>The following search parameters are being applied:</p>
    <ul style="margin:10px 0">
        @foreach( Input::get($searchGroup) as $key => $value )
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
    <p><a class="btn btn-default" href="{{ Request::url() }}">Clear Search Parameters</a></p>
</div>
@endif