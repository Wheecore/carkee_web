<option value="">--select--</option>
@foreach($models as $model)
    <option value="{{ $model->id }}">{{ $model->name }}</option>
@endforeach