@extends('layouts.app')

@section('content')
Hello <?php echo $user['name'] ?>(<?php echo $user['id'] ?>)
@endsection
