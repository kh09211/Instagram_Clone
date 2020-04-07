@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center pt-3 justify-content-center">
                <div class="pr-3">
                    <img src="{{ $post->user->profile->profileImage() }}" alt="profile image" class="rounded-circle w-100" style="max-width: 45px">
                </div>
                <div>
                    <div class="font-weight-bold d-flex h5">
                        <a href="/profile/{{ $post->user->id }}" class="text-dark mt-1">{{ $post->user->username }}</a>

                        {{-- Show delete button if authorized by policy otherwise show follow --}}
                        @can ('update', $post->user->profile)
                            <form action="/p/{{ $post->id }}" method="POST">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-primary ml-4" style="height: 25px; padding-bottom: 30px;">Delete Post</button>
                            </form>
                        @else
                        <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
                        @endcan
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
            



            <form action="/comment/{{ $post->id }}" enctype="multipart/form-data" method="post">

                @csrf

                <div class="form-group row no-gutters pt-2">
                    <div class="col-md-8">
                        <input id="comment" 
                        type="text"
                        class=" form-control @error('comment') is-invalid @enderror" 
                        width="100%"
                        name="comment" 
                        placeholder="Write a comment.."
                        autofocus>

                        @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                        </div>
                </div> 
            </form>
            <p class="mb-2">Comments:</p>

                <div class="comments">
                    @foreach($post->comment as $comment)
                    <div class="row d-flex no-gutters">
                        <div class="col-auto">
                            <span class="font-weight-bold mr-2">
                                <a href="/profile/{{ $comment->user->id }}" class="text-dark">{{ $comment->user->username }}</a>
                            </span>
                        </div>
                        <div class="col">
                            {{ $comment->comment }}
                        </div>
                    </div>
                    @endforeach
                </div>
                {{--
                <div class="comments">
                    @foreach($post->comment as $comment)
                        <div id="indent">
                            <span class="font-weight-bold mr-1">
                                <a href="/profile/{{ $comment->user->id }}" class="text-dark">{{ $comment->user->username }}</a>
                            </span>
                            {{ $comment->comment }}
                        </div>
                    @endforeach
                </div>
                --}}

        </div>
    </div>
</div>
@endsection
