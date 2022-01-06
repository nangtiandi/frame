<div class="card">
    <div class="card-body">

        @if(session('delete'))
            <div class="alert alert-danger">{{session('delete')}}</div>
        @endif
        @if(session('update'))
            <div class="alert alert-success">{{session('update')}}</div>
        @endif


        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Category Name</th>
                <th>
                    <i class="fas fa-user-alt"></i>Owner</th>
                <th>Created At</th>
                <th colspan="2">Control Option</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $key=>$category)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$category->category}}</td>
                    <td>
                        {{--                    {{$users->id === $category->user_id ? '$users->name' : ''}}--}}
                        {{$category->user->name}}
                    </td>
                    <td>
                        <p class="m-0">
                            <i class="fas fa-calendar"></i>
                            {{$category->created_at->format('d / m / Y')}}
                            ||
                            <i class="fas fa-clock"></i>
                            {{$category->created_at->format('h:i:a')}}
                        </p>
                    </td>
                    <td>
                        <a href="{{route('category.edit',$category->id)}}" class="btn btn-warning btn-sm">
                            <i class="fas fa-check"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{route('category.destroy',$category->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">There is any category.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{$categories->links()}}
        </div>
    </div>
</div>
