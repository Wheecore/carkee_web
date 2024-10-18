<option value="">--select--</option>
@foreach($vehicle_sizes as $dta)
    <option value="{{ $dta->name }}">{{ $dta->name }}</option>
@endforeach