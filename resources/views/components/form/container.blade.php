@props(['routeName' => 'path-needed', 'method' => '', 'className' => '', 'enctype' => null])

<form action="{{ route($routeName) }}" method="{{ $method ?: 'POST' }}" class="{{ $className }}" @if($enctype) enctype="{{ $enctype }}" @endif>
    @csrf

    {{ $slot }}
</form>