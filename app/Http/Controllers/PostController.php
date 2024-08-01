<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(5);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
                'image' => ['image','required','max:2048','mimes:png,jpg'],
                'title' => ['required','max:255'],
                'category_id' => ['required','integer'],
                'description' => ['required']
            ]);

            /**
             * works with Image
             *
             *
             * First Way
             */
            // if($request->hasFile('image')){
            //     $file = $request->file('image');
            //     $ex  = $file->getClientOriginalExtension();
            //     $filename = time().'.'.$ex;
            //     $file->move('storage/uploads/',$filename);
            //     $post->image = 'storage/uploads/'.$filename;
            //     // $posts->image = 'storage/'.$filename;
            // }

            /**
             * works with Image
             *
             *
             * Second Way
             */
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath  = $request->image->storeAs('uploads',$fileName); // uploads/finlename
            // return $filePath;

            $post = new Post();
            $post->title = $request->title;
            $post->category_id = $request->category_id;
            $post->description = $request->description;
            // $post->image = $filePath;
            $post->image = 'storage/'.$filePath; // storage/uploads/finlename
            $post->save();
            return redirect()->route('posts.index')->with('success','Post has been added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        // $categories = Category::all();
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required','max:255'],
            'category_id' => ['required','integer'],
            'description' => ['required']
        ]);

        $post = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['image','required','max:2048','mimes:png,jpg'],
            ]);
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath  = $request->image->storeAs('uploads',$fileName); // uploads/finlename

            File::delete(public_path($post->image));
            $post->image = 'storage/'.$filePath; // storage/uploads/finlename
        }

        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->description = $request->description;
        $post->save();
        // return $request->all();
        return redirect()->route('posts.index')->with('success','Post has been Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success','Post has been deleted successfully');;
    }

    public function trashed() {
        $posts = Post::onlyTrashed()->get();
        return view('posts.trash',compact('posts'));
    }

    public function restored($id) {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->back()->with('success','Post has been restored successfully');
    }

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        File::delete(public_path($post->image));

        $post->forceDelete() ;
        return redirect()->back()->with('success','Post has been force deleted successfully');
    }
}
