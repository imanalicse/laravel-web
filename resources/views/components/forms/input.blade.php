@php
$column_number = 12 / $column;
@endphp

<div @class([
'col-sm-'.$column_number,
$attributes->get('wrapper_class')
])>
    <label for="{{ $attributes->get('id') }}" class="form-label">{{ $title }}</label>
    <input {{ $attributes->whereDoesntStartWith('wrapper')->merge(['type' => 'text', 'class' => 'form-control']) }}>
</div>
