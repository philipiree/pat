{{-- @extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-secondary">Go Back</a>
    <h1>{{ $posts->title }}</h1>
    <div>
        {!! $posts->body !!}
    </div>
    <small> Created on {{ $posts->created_at }} by {{ $posts->user->name }} </small>
    <div>
    @if(!Auth::guest())
        @if(Auth::user()->id == $posts->user_id)
    <a href="/posts/{{$posts->id}}/edit" class="btn btn-success">Edit</a>
    </div>


    {!! Form::open(['action' => ['PostsController@destroy',$posts->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}
        @endif
    @endif
@endsection --}}
@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1 class="text-center">{{$posts->title}}</h1>
     <img class="img-thumbnail mx-auto d-block" src="/storage/cover_images/{{$posts->cover_image}}">
    <div class="text-center">
        {!!$posts->body!!}
    </div>
    <hr>
        <div class="text-center">
            <p class="text-center">Written on {{$posts->created_at}} by {{$posts->user->name}}</p>
        </div>
    <hr>
    @if(!Auth::guest())
    <!--Hide if it is a guest-->
    @if(Auth::user()->id !== $posts->user_id)

    <div class="text-center">
    <a href="/posts/{{$posts->id}}/cart" class="btn btn-success col-sm-3">Buy</a>
        <!--Hide if it is not the same poster/user-->
    </div>
    @endif
    @if(Auth::user()->id == $posts->user_id)
    <div class="text-left">
    <a href="/posts/{{$posts->id}}/edit" class="btn btn-success">Edit</a>

    {!! Form::open(['action' => ['PostsController@destroy', $posts->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {!! Form::hidden('_method', 'DELETE') !!}
        {!! Form::submit('DELETE', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    </div>
    @endif
    @endif
    @endsection
