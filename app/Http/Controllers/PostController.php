<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(Auth::user()->role == 1,function ($query){
            $query->where('user_id',Auth::id());
        })->when(isset(request()->search),function ($query){
            $keyword = request()->search;

            $query->orWhere('title','like','%'.$keyword.'%')->orWhere('description','like','%'.$keyword.'%');
        })->with(['user','category','photos'])->latest()->paginate(10);
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create',Post::class);
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title',
            'category' => 'required|exists:categories,id',
            'description'=> 'required|min:10',
            'photos' => 'required',
            'photos.*' => 'file|mimes:jpg,png|max:1024',
            'tags' => 'required',
            'tags.*' => 'exists:tags,id'
        ]);
//        DB::transaction(function () use($request){
//        DB::beginTransaction();
//        try{
        if (!Storage::exists('public/thumbnail')){
            Storage::makeDirectory('public/thumbnail');
        }

            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->title;
            $post->category_id = $request->category;
            $post->description = $request->description;
            $post->excerpt = Str::words($request->description);
            $post->user_id = Auth::id();
            $post->isPublished = '1';
            $post->save();
            $post->tags()->attach($request->tags);

        if($request->hasFile('photos')){
            foreach ($request->file('photos') as $photo){
                $newName = uniqid()."_photo.".$photo->extension();
                $photo->storeAs('public/photo',$newName);

                $img = Image::make($photo);
                $img->fit(200,200);
                $img->save('storage/thumbnail/'.$newName);

                $photo = new Photo();
                $photo->name = $newName;
                $photo->post_id = $post->id;
                $photo->user_id = Auth::id();
                $photo->save();
            }
        }
//            DB::commit();
//
//        }catch (\Exception $e){
//            DB::rollBack();
//            throw $e;
//        }
//        });
        return redirect()->route('post.index')->with('success','Success Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
//        if (! Gate::allows('edit-post', $post)) {
//            abort(403);
//        Gate::authorize('edit-post',Post);

//        return $user->id === $post->user_id
//            ? Response::allow()
//            : Response::deny('You do not own this post.');
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,'.$post->id,
            'category' => 'required|exists:categories,id',
            'description'=> 'required|min:10'
        ]);
        $post->title = $request->title;
        $post->slug = $request->title;
        $post->category_id = $request->category;
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description);
        $post->update();
        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        return redirect()->route('post.index')->with('success','Success Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
//        Gate::authorize('delete',$post);
//        delete photo files
        foreach ($post->photos as $photo) {
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);
        }
//        delete pivot records
        $post->tags()->detach();
//        delete db records
        $post->photos()->delete();
//        post delete
        $post->delete();

        return redirect()->back()->with('delete','successfully Deleted');
    }
}
