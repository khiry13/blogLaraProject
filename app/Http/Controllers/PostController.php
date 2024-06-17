<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {

        // $post = Post::where('id', $id)->first();
        // $post = Post::find($id);

        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', ['users' => $users]);
    }

    public function store()
    {
        // $data = request()->all();

        request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:5'],
            'post_creator' => ['required', 'exists:posts,id'],
        ]);

        Post::create([
            'title' => request()->title,
            'description' => request()->description,
            'user_id' => request()->post_creator,
        ]);

        return to_route('posts.index');
    }

    public function edit($id)
    {
        $users = User::all();
        $post = Post::find($id);
        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }

    public function update($id)
    {
        $post = Post::find($id);

        request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:5'],
            'post_creator' => ['required', 'exists:posts,id'],
        ]);

        $post->update([
            'title' => request()->title,
            'description' => request()->description,
            'user_id' => request()->post_creator,
        ]);

        return to_route('posts.show', $post->id);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        return to_route('posts.index');
    }
}
