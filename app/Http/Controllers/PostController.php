<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use App\Models\Comments;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware(['auth:sanctum'])->only(['store','update','delete']);
        $this->middleware(['pemilik-news'])->only('update','delete');
    }

    function index(){
        $posts = posts::all();
        // return response()->json(['data' => $post]);
        return PostResource::collection($posts);
    }

    public function show($id){
        $post = posts::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
    }

    public function generateRandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        if($request->file) {

            $validated = $request->validate([
                'file' => 'mimes:jpg,jpeg,png|max:100000'
            ]);

            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();
            Storage::putFileAs('image',$request->file, $fileName.'.'.$extension);

            $request['image'] = $fileName . '.' . $extension;
            $request['author'] = Auth::user()->id;
            $post = posts::create($request->all());
        }

        $request['author'] = Auth::user()->id;
        $post = posts::create($request->all());

        $post = posts::create([
            'title' => $request -> input('title'),
            'news_content' => $request -> input('news_content'),
            'author' => Auth::user()->id,
            'image' => $fileName.'.'.$extension
        ]);

        return new PostDetailResource($post->loadMissing('writer'));
    }
    



    public function update(Request $request, $id){
        $request -> validate([
            'title' => 'required|string',
            'news_content' => 'required|string'
        ]);

        $post = posts::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer'));
    }


    public function delete($id){

        $post = posts::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'berhasil menghapus'
        ]);
    }


}
