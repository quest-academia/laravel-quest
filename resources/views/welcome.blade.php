@extends('layouts.app')

@section('content')

    <div class="center jumbotron bg-warning">

        <div class="text-center text-white">
            <h1>YouTubeまとめ × SNS</h1>
        </div>

    </div>
    
    <div class="text-right">

        @if(Auth::check())
            {{ Auth::user()->name }}
        @endif

    </div>
    
    <!--usersフォルダのusers.blade.phpに飛ぶと言う意味-->
    @include('users.users', ['users'=>$users])

@endsection