@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center">
                <div class="pr-3">
                    <img src="{{ $post->user->profile->profileImage() }}" alt="profile image" class="rounded-circle w-100" style="max-width: 45px">
                </div>
                <div>
                    <div class="font-weight-bold d-flex h5">
                        <a href="/profile/{{ $post->user->id }}" class="text-dark mt-1">{{ $post->user->username }}</a>
                        <follow-button user-id="{{ $post->user->id }}" follows="{{ $post->user->profile->follows }}"></follow-button>
                    </div>
                </div>
            </div>
            <hr/>
            <p>
                <span class="font-weight-bold mr-1">
                    <a href="/profile/{{ $post->user->id }}" class="text-dark">{{ $post->user->username }}</a>
                </span> 
                {{ $post->caption }}
            </p>
            <hr>
            comments
        </div>
    </div>
</div>
@endsection
