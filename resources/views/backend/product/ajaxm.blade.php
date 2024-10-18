{{--<option value="">--select--</option>--}}
@if($brands)
@foreach($brands as $brand)
@php
$models = App\Models\CarModel::where('brand_id', $brand)->get();
@endphp
@if(count($models)>0)
@foreach($models as $model)
<option value="{{ $model->id }}">{{ $model->name }}</option>
@endforeach
@endif
@endforeach
@endif
