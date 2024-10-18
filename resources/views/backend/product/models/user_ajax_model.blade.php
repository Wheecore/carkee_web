<option value="">--select--</option>
@foreach($lists as $list)
    <?php
    $model = \App\Models\CarModel::where('brand_id', $list->brand_id)->first();
    ?>
    <option value="{{ $model->id }}">{{ $model->name }}</option>
@endforeach