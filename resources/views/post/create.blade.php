@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-primary">Post Manage</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Post Title</label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                @error('title')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Photo</label>
                                <input type="file" class="form-control" name="photos[]" value="{{old('photos')}}" multiple>
                                @error('photos')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                @error('photos.*')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Post Item</label>
                                <select name="category" id="" class="form-select">
                                    @foreach(\App\Models\Category::all() as $category)
{{--                                        {{$category->id == $post->category_id ? 'selected' : ''}}--}}
                                        <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''}}>{{$category->category}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Post Tag</label>
                                <br>
                                @foreach(App\Models\Tag::all() as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" {{in_array($tag->id,old('tags',[])) ? 'checked' : ''}} type="checkbox" name="tags[]" id="tag{{$tag->id}}" value="{{$tag->id}}">
                                        <label class="form-check-label" for="tag{{$tag->id}}">{{$tag->tag}}</label>

                                    </div>
                                @endforeach
                                @error('tags')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                @error('tags.*')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Post Description</label>
                                <textarea name="description" rows="6" class="form-control">{{old('description')}}</textarea>
                                @error('description')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-info" value="Create Post">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
