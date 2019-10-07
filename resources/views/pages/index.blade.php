@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
        <h1>Welcome To WeebWatcher!</h1>
        <p>Please register or login to view your own personalized list!</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection