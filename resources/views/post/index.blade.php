@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('delete'))
                    <div class="alert alert-danger">{{session('delete')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        Post List
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="w-25">Title</th>
                                    <th><i class="fas fa-user-alt"></i>Owner</th>
                                    <th>Post Item</th>
                                    <th>Created At</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <div class="d-flex justify-content-between">
                                {{$posts->appends(request()->all())->links()}}
                                <div>
                                    <form action="">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search..." name="search">
                                            <button class="btn btn-outline-primary" >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{$post->id}}</td>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->user->name}}</td>
                                        <td>
                                            @forelse($post->photo as $photo)
                                                <a class="my-link" data-gall="gall{{$post->id}}" data-autoplay="true" data-maxwidth="500px" href="{{asset('storage/photo/'.$photo->name)}}"><img src="{{asset('storage/thumbnail/'.$photo->name)}}" height="40" alt="image alt"/></a>
{{--                                                <img src="{{asset('storage/thumbnail/'.$photo->name)}}" alt="" height="40">--}}
                                            @empty
                                                <p>empty photo</p>
                                            @endforelse
                                        </td>
                                        <td>{{$post->category->category}}</td>
                                        <td>
                                            <p class="m-0">
                                                <i class="fas fa-calendar"></i>
                                                {{$post->created_at->format('d / m / Y')}}
                                                ||
                                                <i class="fas fa-clock"></i>
                                                {{$post->created_at->format('h:i:a')}}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('post.show',$post->id)}}" class="btn btn-outline-info">
                                                    <i class="fas fa-info"></i>
                                                </a>
                                                <a href="{{route('post.edit',$post->id)}}" class="btn btn-outline-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button form="deletePost{{$post->id}}" class="btn btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            <form action="{{route('post.destroy',$post->id)}}" class="d-none" id="deletePost{{$post->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There is empty post.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
