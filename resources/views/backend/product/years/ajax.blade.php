<option value="">--select--</option>
@foreach($years as $year)
    <option value="{{ $year->id }}">{{ $year->name }}</option>
@endforeach