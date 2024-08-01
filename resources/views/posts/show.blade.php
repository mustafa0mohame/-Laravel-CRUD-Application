@extends('layout.master')

@section('content')

<div class="card mt-5 mb-3" style="max-width: 840px;">
    <div class="card-header">
        Show Posts
        <a href="{{route('posts.index')}}" class="btn btn-dark float-end ms-2"><i class="fa-solid fa-circle-left"></i>
            Back</a>
    </div>
    <div class="row g-0">
        <div class="col-md-4">
            <img src="{{asset($post->image)}}" alt="" class="img-fluid rounded-start">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text">{{$post->description}}.</p>
                <p class="card-text"><small class="text-muted">{{$post->category->name}}</small>
                    <p class="card-text"><small class="text-muted">{{date('d-m-Y',strtotime($post->created_at))}}</small>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection