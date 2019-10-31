@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach ($posts as $post)
            <div class="card" style="width: 30rem; padding: 10px; margin: 0 0 10px 20px;">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>

                        <div class="interaction">
                         
                            @if($usersPost > 2)
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You liked this post' : 'Like' : 'Like' }}</a> |
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You dont like this post' : 'Dislike' : 'Dislike' }}</a>
                            
                            <hr>
                            @endif
                        
                        </div>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No posts found</p>
    @endif

   
        <h4>Tags</h4>

        @foreach ($tags as $tag)
            <a href="/posts/tags/{{ $tag }}">
                {{ $tag }}
            </a>
        @endforeach
    


    <script src="{{ asset('/js/like.js') }}"></script>
    <script type="text/javascript">
    let token = '{{ Session::token() }}';
    let urlLike = '{{ route('like') }}';
    </script>

@endsection

