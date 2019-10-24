@extends('layouts.app')

@section('content')
    <h1>Create your post</h1>
    <form method="post" enctype="multipart/form-data" action="{{ route('posts.store') }}">
            <div class="form-group">
                @csrf            
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Title"/>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" cols="20" rows="10" placeholder="Body Text"></textarea>
            </div>
            
            <div class="form-group">
                {{Form::file('cover_image')}}
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
     </form>
@endsection