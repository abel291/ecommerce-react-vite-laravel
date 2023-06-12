@if (session()->has('errors'))
    @foreach (session()->get('errors') as $error)
        <div class="alert alert-success">
            {{ $error[0] }}
        </div>
    @endforeach
@endif
