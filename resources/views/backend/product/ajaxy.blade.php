{{--<option value="">--select--</option>--}}
@foreach($details as $detail)
@php
$types = App\Models\CarYear::where('details_id', $detail)->get();
@endphp
@foreach($types as $type)
<option value="{{ $type->id }}">{{ $type->name }}</option>
@endforeach
@endforeach
