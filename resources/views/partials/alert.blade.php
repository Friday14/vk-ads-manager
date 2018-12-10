@if(session()->has('message'))
    <div class="col-md-12">
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
@endif

@if(!$errors->isEmpty())
    <div class="col-md-12">
        <div class="alert alert-danger" role="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif