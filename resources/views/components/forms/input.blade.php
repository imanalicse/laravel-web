@php
$column_number = 12 / $column;
@endphp

<div @class(['col-sm-'.$column_number, 'additional-class'])>
    <label for="{{ $name }}" class="form-label">{{ $title }}</label>
    <input type="{{$type}}" name="{{ $name }}" value="{{ $value }}" class="form-control" id="{{ $name }}" placeholder="" @required($required)>
</div>
