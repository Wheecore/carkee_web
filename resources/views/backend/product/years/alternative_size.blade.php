<option value="">--select--</option>
@foreach($a_sizes as $dta)
    <option value="{{ $dta->id }}">{{ $dta->name }}</option>
@endforeach