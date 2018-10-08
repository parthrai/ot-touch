@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @isset ($flash_success)
                <div class="alert alert-primary" role="alert">
                    {{ $flash_success }}
                </div>
                @endisset
                <div class="panel-heading">Users Dashboard</div>

                <div class="panel-body">
                    <a href="{{ route('newuser') }}"><button>Add User</button></a>
                </div>
               <!-- Users Table -->
               <table class="table table-condensed">
                   <thead>
                       <tr>
                           <td>id</td>
                           <td>Name</td>
                           <td>Email</td>
                           <td>Created At</td>
                           <td>Admin</td>
						   <td>Edit</td>
						   <td>Delete</td>
                       </tr>
                   </thead>
                   <tbody>
                       
                       @foreach($users as $user)
                       <tr>
                           <td>{{ $user->id }}</td>
                           <td>{{ $user->name }}</td>
                           <td>{{ $user->email }}</td>
                           <td>{{ $user->created_at }}</td>
                           <td>
                               @if(Auth::user()->id == $user->id)
                                   
								  <input type="checkbox" name="admin" value="admin" disabled />
                               @elseif($user->is_admin)

                                   <input type="checkbox" id="admin" name="admin" value="admin" onClick="otAjax.rm_admin({{ $user->id }})" checked>
                                   
                               @else
                                   <input type="checkbox" id="admin" name="admin" value="admin" onClick="otAjax.add_admin({{ $user->id }})">
								   
                               @endif
                           </td>
						   <!-- @todo: add fontawesome and make these icons -->
						   <td><a href="#" ><span class="glyphicon glyphicon-pencil"></span></a></td>
						   <td>

                               {!! Form::open(['method' => 'DELETE','route' => ['user.delete', $user->id],'style'=>'display:inline']) !!}

                               {{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-danger', 'type'=>'submit')) }}


                               {!! Form::close() !!}

                           </td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</div>
@endsection
