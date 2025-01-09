@foreach ($errors->all() as $message)
    <div class="alert alert-danger mb-1" role="alert">
        {{ $message }}
    </div>
@endforeach
@if (session('error'))
    <div class="alert alert-danger alert-dismissible show fade">
        {!! session('error') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success alert-dismissible show fade">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
