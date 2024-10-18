<option value="">--Select--</option>
@foreach ($datas as $data)
    <option value="{{ $data->id }}">{{ $data->name }}</option>
@endforeach

<body>
    <div class="container-fluid">
        <section>
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </section>
        <footer></footer>
    </div>
</body>
