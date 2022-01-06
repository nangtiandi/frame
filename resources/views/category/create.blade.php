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

                    <form action="{{route('category.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-7">
                                <div class="mb-3">
                                    <label for="" class="form-label">New Category Name</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{old('category')}}">
                                    @error('category')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <input type="submit" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            @include('category.list')
        </div>
    </div>
</div>
@endsection
