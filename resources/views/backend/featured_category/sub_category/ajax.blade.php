<label for="name">
    {{ translate('Sub Category') }}
</label>
<select class="form-control aiz-selectpicker" name="featured_sub_cat_id" id="featured_sub_cat_id">

    <option value="">--Select--</option>
    @foreach ($datas as $data)
        <option value="{{ $data->id }}">{{ $data->name }}</option>
    @endforeach
</select>
