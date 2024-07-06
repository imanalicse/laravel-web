@extends('admin.layouts.app')

@section('content')    
    <div class="page-content">                        
            <table class="table-striped table table-responsive">              
                <tbody>
                    <tr>
                        <td>Id</td>
                        <td>{{$category->id}}</td>
                    </tr>

                    <tr>
                        <td>Title</td>
                        <td>{{$category->title}}</td>
                    </tr>

                    <tr>
                        <td>Identifier</td>
                        <td>{{$category->identifier}}</td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td>{{$category->description}}</td>
                    </tr>                                                          
                </tbody>
            </table>
        </div>

@endsection