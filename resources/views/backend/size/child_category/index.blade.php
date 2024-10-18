@extends('backend.layouts.app')
@section('title', translate('Tyre Size Child Category'))
@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Tyre Size Child Category') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_size_cats" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search"
                                    name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type name & Enter') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Category Name') }}</th>
                                <th>{{ translate('Sub Category Name') }}</th>
                                <th>{{ translate('Name') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $data)
                                <?php
                                $main = DB::table('size_categories')
                                    ->where('id', $data->size_category_id)
                                    ->first();
                                $sub = DB::table('size_sub_categories')
                                    ->where('id', $data->size_sub_category_id)
                                    ->first();
                                ?>
                                @if ($main && $sub)
                                    <tr>
                                        <td>{{ $key + 1 + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                                        <td>
                                            {{ $main->name }}
                                        </td>
                                        <td>
                                            {{ $sub ? $sub->name : '' }}
                                        </td>
                                        <td>{{ $data->getTranslation('name') }}</td>

                                        <td class="text-right">
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('size.child.category.edit', ['id' => $data->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="{{ route('size.child.category.destroy', $data->id) }}"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $datas->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New Tyre Size Child Category') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('size.child.category.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="category">{{ translate('Category') }}</label>
                            <select name="cat_id" id="cat_id" class="form-control" onchange="size_subcats_ajax()" required>
                                <option value="">--Select--</option>
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">{{ translate('Subcategory') }}</label>
                            <select name="sub_cat_id" id="sub_cat_id" class="form-control" required>
                                <option value="">--Select--</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Name') }}</label>
                            <input type="text" placeholder="{{ translate('Name') }}" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function size_subcats_ajax() {
            var cat_id = $('#cat_id').val();
            $.ajax({
                url: "{{ url('admin/get-size-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('#sub_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }
    </script>
@endsection
