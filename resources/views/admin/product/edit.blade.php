@extends('layouts.admin')

@section('content')
    <div class="page-content">
    <h3>Edit Product</h3>
    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="title" class="col-md-4 control-label">Title</label>
                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" name="name" value="{{ $product->name }}" autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="price" class="col-md-4 control-label">Price</label>
                <div class="col-md-6">
                    <input id="price" type="text" class="form-control" name="price" value="{{ $product->price }}">
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
