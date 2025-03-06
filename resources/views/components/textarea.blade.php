@props(['id', 'name', 'value', 'class', 'required'])

<textarea
    {{ $attributes->merge(['class' => $class]) }}
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $required ? 'required' : '' }}
>{{ $value }}</textarea>
