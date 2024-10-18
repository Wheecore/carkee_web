<option value="">--select--</option>
@foreach($lists as $list)
    <?php
    $details = \App\Models\CarDetail::where('model_id', $list->model_id)->first();
    ?>
    <option value="{{ $details->id }}">{{ $details->name }}</option>
@endforeach