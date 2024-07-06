@extends('layouts.admin')

@section('content') 
    <div class="page-content">
        <h3>Add Product</h3>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="category_type" class="col-md-4 control-label">Title</label>
                <div class="col-md-6">
                    <input id="category_type" type="text" class="form-control" name="title" value="{{ old('title') }}" autofocus>
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="price" class="col-md-4 control-label">Price</label>
                <div class="col-md-6">
                    <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="image" class="col-md-4 control-label">Price</label>
                <div class="col-md-6">
                    <input id="image" type="file" class="form-control" name="image" value="{{ old('image') }}">
                    @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
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