{{--<option value="">--select--</option>--}}
@foreach($years as $year)
@php
$years = App\Models\CarType::where('year_id', $year)->get();
@endphp
@foreach($years as $year)
<option value="{{ $year->id }}">{{ $year->name }}</option>
@endforeach
@endforeach
