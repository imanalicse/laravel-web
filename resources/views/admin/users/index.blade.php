@extends('layouts.admin')

@section('content')

<div class="page-content">
        <table class="table-striped table table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th class="fx-action-links text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                @if(count($users) > 0)
                @foreach($users as $user)
                    <tr>                        
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td class="fx-action-links text-center">
                            <div class="action-group">
                                <a class="action view" href="{{url('/admin/customers/')}}"></a>
                                <a href="{{url('/admin/users/'.$user->id.'/edit')}}" class="action edit"></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @endif  
                
            </tbody>
        </table>
    </div>
@endsection
