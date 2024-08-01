@extends('layout.master')

@section('content')

<!-- to show all messages on the top of card -->
{{-- <div class="messages">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    .<div class="alert alert-danger" role="alert">
        {{$error}}
    </div>
    @endforeach
    @endif
</div> --}}


<div class="card mt-5">
    <div class="card-header">
        Update Posts
        <a href="{{route('posts.index')}}" class="btn btn-dark float-end ms-2"><i class="fa-solid fa-circle-left"></i>
            Back</a>
    </div>
    <div class="card-body">
        <form action="{{route('posts.update',$post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <img src="{{asset($post->image)}}" alt="" style="width: 200px">
            </div>

            <div class="form-group">
                <label for="formFileMultiple" class="form-label">Image</label>
                <input type="file" class="form-control" name="image" id="formFileMultiple" multiple>
                @error('image')
                <div class="alert alert-danger error mt-2">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="inputTitle4" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="inputTitle4" value="{{$post->title}}">
                @error('title')
                <div class="alert alert-danger error mt-2">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group  mt-3">
                <label for="inputState" class="form-label">Category</label>
                <select id="inputState" class="form-select" name="category_id">
                    <option selected disabled>Select...</option>
                    @foreach ($categories as $category)
                    <option {{$category->id === $post->category_id ? 'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger error mt-2">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5">{{$post->description}}</textarea>
                @error('description')
                <div class="alert alert-danger error mt-2">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary mt-2 float-end">Update</button>
            </div>
    </div>
    </form>
</div>
</div>

@endsection
