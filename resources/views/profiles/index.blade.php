@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3" id="postphoto">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-md-9" id="postname">
            <div class="d-flex align-items-baseline">
                <div class="d-flex align-items-center pb-2">
                    <div class="h2">{{ $user->username }}</div>
                </div>

                {{-- below blade directive switches from the add new post button to the follow/unfollow button if not the authenticated user--}}

                @can ('update', $user->profile)
                    <a class="btn btn-primary ml-4" style="height: 25px; padding-bottom: 30px;" href="/p/create">Add New Post</a>
                @else
                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                @endcan

            </div>
            <div class="pb-2">

                <!-- below blade directive hides if not the user -->
                @can ('update', $user->profile)
                    <a href="/profile/{{ $user->id }}/edit" class="mr-2">Edit Profile</a>
                @endcan

            </div>
            <div class="d-flex" id="postinfo">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="pr-5"><strong>{{ $user->profile->followers->count() }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $user->following->count() }}</strong> following</div>
            </div>
            <div class="pt-3"><strong>{{ $user->profile->title }}</strong></div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center pt-5">
        @if (count($user->posts) == 0)
            <h3>You have not added and post yet</h3>
        @endif

        @foreach($user->posts as $post)
            <div class="col-md-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="post-photo">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
