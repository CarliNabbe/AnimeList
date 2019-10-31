@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">This is the ADMIN Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>All posts</h1>
                    <li>
                        <a class="btn btn-primary" style="margin: 10px;" href="/posts/create">Create Post</a>
                    </li>
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach (Auth::user()->post as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                            <td>
                                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'DELETE', 'class' => 'float-right']) !!}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
