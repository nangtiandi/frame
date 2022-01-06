@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-primary">Post Edit</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.update',$post->id)}}" method="post">
                            @method('put')
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Post Title</label>
                                <input type="text" class="form-control" name="title" value="{{old('title',$post->title)}}">
                                @error('title')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Post Item</label>
                                <select name="category" id="" class="form-select">
                                    @foreach(\App\Models\Category::all() as $category)
                                        {{--                                        {{$category->id == $post->category_id ? 'selected' : ''}}--}}
                                        <option value="{{$category->id}}" {{old('category',$post->category_id) == $category->id ? 'selected' : ''}}>{{$category->category}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Post Description</label>
                                <textarea name="description" rows="6" class="form-control">{{old('description',$post->description)}}</textarea>
                                @error('description')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-info" value="Update Post">
                        </form>

                    </div>
                    <div class="card-footer">
                        <div class="mb-3 d-flex">
                            <div class="d-inline-flex justify-content-center align-items-center border border-3 rounded" id="photoUpload">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <form action="{{route('photo.store')}}" method="post" enctype="multipart/form-data" class="d-none" id="photoForm">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" value="{{$post->id}}" name="post_id">
                                        <input type="file" class="form-control" name="photo[]" id="photoInput" multiple>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-info">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mb-3">
                            @forelse($post->photo as $photo)
                                <div class="d-inline-block position-relative" style="width: 100px;height: 100px">
                                    <img src="{{asset('storage/thumbnail/'.$photo->name)}}" alt="" height="80" class="position-absolute">
                                    <form action="{{route('photo.destroy',$photo->id)}}" method="post" >
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm position-absolute" style="bottom: 20px; right: 20px">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <strong>Photo is empty</strong>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
<script>
    let photoUpload = document.getElementById('photoUpload');
    let photoInput = document.getElementById('photoInput');
    let photoForm = document.getElementById('photoForm');

    photoUpload.addEventListener('click', ()=>{
        photoInput.click();
    })
    photoInput.addEventListener('change',()=>{
        photoForm.submit();
    });

</script>
@endsection
