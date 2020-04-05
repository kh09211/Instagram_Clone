@extends('layouts.app')

@section('content')

<div class="container">
    @if (count($posts) == 0)
        <h3 class="text-center pt-3">You are not following anyone yet</h3>
    @endif

    @foreach($posts as $post)
        <div class="row justify-content-center pt-3">
            <div class="col-md-7">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        </div>
        <div class="row justify-content-center pt-3">
            <div class="col-md-7 text-center">
                <p>
                    <span class="font-weight-bold mr-1">
                        <a href="/profile/{{ $post->user->id }}" class="text-dark">{{ $post->user->username }}</a>
                    </span> 
                    {{ $post->caption }}
                </p>
            </div>
        </div>
        <hr>
    @endforeach
</div>
@endsection
