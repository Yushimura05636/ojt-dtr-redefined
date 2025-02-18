@props(['routeName' => 'path-needed', 'method' => '', 'className' => ''])

<form action="{{ route($routeName) }}" method="{{ $method ?: 'POST' }}" class="{{ $className }}">
    @csrf

    {{ $slot }}
</form>