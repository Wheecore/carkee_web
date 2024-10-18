{{--<option value="">--select--</option>--}}
@foreach($models as $model)
@php
$details = App\Models\CarDetail::where('model_id', $model)->get();
@endphp
@foreach($details as $detail)
<option value="{{ $detail->id }}">{{ $detail->name }}</option>
@endforeach
@endforeach
