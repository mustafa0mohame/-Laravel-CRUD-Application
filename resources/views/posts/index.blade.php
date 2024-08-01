@extends('layout.master')

@section('content')

<div class="message mt-5">
    @if (Session::has('success'))
       <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
            <button class="btn-close float-end" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
    @endif
</div>
<div class="main-content mt-5">
    <div class="card border-primary">
        <div class="card-header">
            All Posts
            <a href="{{route('posts.create')}}" class="btn btn-success float-end ms-2"><i class="fa-solid fa-plus"></i> Cerate</a>
            <a href="{{route('posts.trashed')}}" class="btn btn-warning float-end"><i class="fa-solid fa-trash-can"></i> Trash</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered border-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 10%">Image</th>
                        <th scope="col" style="width: 20%">Title</th>
                        <th scope="col" style="width: 10%">Category</th>
                        <th scope="col" style="width: 30%">Description</th>
                        <th scope="col" style="width: 10%">Publish Date</th>
                        <th scope="col" style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <th scope="row">{{$post->id}}</th>
                        <td><img src="{{asset($post->image)}}" alt="" width="50"></td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->category->name}}</td>
                        <td><p>{{Str::limit($post->description,50)}}</p></td>
                        <td>{{date('d-m-Y',strtotime($post->created_at))}}</td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-primary m-2" href="{{route('posts.show',$post->id)}}"><i class="fa-regular fa-eye"></i></a>
                                <a class="btn btn-success m-2" href="{{route('posts.edit',$post->id)}}"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{route('posts.destroy',$post->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-2" type="submit"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
</div>

@endsection
