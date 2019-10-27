@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 1)
        @foreach ($posts as $post)
            <div class="card" style="width: 30rem; padding: 10px; margin: 0 0 10px 20px;">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>

                        <p id="getCount"><i class="fa fa-heart" style="color: red;"></i>{{$post->likesCount}}</p>
                        @guest
                        @else
                        <p class="like" id="like"><i class="fa fa-heart" style="color: red"></i> Like</p>
                        <p class="like" id="dislike"><i class="far fa-heart"></p>

                        @endguest
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No posts found</p>
    @endif

    <script>
    
        @if($post->liked)
        $('#like').hide();
        $('#dislike').show();
        @else
        $('#like').show();
        $('#dislike').hide();
        @endif
    
        @guest
    
        @else
        $('.like').on('click', function () {
    
            const user = {{ Auth::user()->id }}
            $.ajax({
                type: 'get',
                url: `{{ route('toggleLike', $post->id) }}`,
                data: user,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.like.isLiked) {
                        $('#like').hide();
                        $('#dislike').show();
                        $('#likesCount').html('<i class="fa fa-heart" style="color:red;"></i>' + data.like.likes);
                    } else {
                        $('#dislike').hide();
                        $('#like').show();
                        $('#likesCount').html('<i class="fa fa-heart" style="color:red;"></i>' + data.like.likes);
                    }
                }
                
            });
        });
        @endif

        </script>

@endsection

