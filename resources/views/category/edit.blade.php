@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Manage Category
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                        <form action="{{route('category.update',$category->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-7">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Edit Category Name</label>
                                        <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{old('category',$category->category)}}">
                                        @error('category')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Update Category">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                @if(session('delete'))
                    <div class="alert alert-danger">{{session('delete')}}</div>
                @endif
                @include('category.list')
            </div>
        </div>
    </div>
@endsection
