@extends('layouts.app')

@section('content')

<div class="container">
    @if (count($posts) == 0)
        <div class="row justify-content-center pt-3">
            <div class="col-md">
                <h3 class="text-center pt-1">You are not following anyone yet</h3>
            </div>
        </div>
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
                    <br/>
                    <span style="font-size: 14px" class="mb-2">Comments ({{ $post->comment()->count() }})
                    </span>
                </p>
            </div>
        </div>
        <hr>
    @endforeach
</div>
@endsection
