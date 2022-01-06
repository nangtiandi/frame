@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{$post->title}}
                    </div>
                    <div class="card-body">
                        {{$post->description}}
                        <a href="{{route('post.index')}}" class="btn btn-outline-info">See More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
