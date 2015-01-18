{{-- Make the user aware of any search filters being applied to the results. --}}
@if( Input::get('criteria'))
    <div class="alert alert-warning">
        Results are being filtered by the <code>{{ Input::get('criteria') }}</code> criteria. To clear this criteria <a class="underlined" href="{{ Request::url() }}">click here</a>.
    </div>
@endif

{{-- Search Form --}}
{!! Form::open(['class' => 'form-inline', 'method' => 'GET']) !!}
<!-- Search Form Input -->
<div class="form-group {{ hasError('search', $errors) }}">
    <div class="col-md-10">
        {!! Form::text('criteria', Input::get('criteria', null), ['class' => 'form-control', 'placeholder' => 'Enter search criteria']) !!}
    </div>
</div>
{{-- Submit Form Button --}}
<div class="form-group">
    <div class="col-md-2">
        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
    </div>
</div>
{!! Form::close() !!}