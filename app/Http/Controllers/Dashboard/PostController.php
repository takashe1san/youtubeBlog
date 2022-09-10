<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Trait\imageUpload;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;


class PostController extends Controller
{
    use imageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.posts.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return dd($request);
        //get catagories
        $categories = Category::all();
        foreach($categories as $item){
            $categoriesID[] = $item->id;
        }
        //validate request
        $data = [
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'category_id'   => 'nullable|'.Rule::in($categoriesID),
        ];
        foreach(config('app.languages') as $key => $value){
            $data[$key.'.title']   = 'required|string';
            $data[$key.'.content'] = 'nullable|string';
            $data[$key.'.smallDesc'] = 'nullable|string';
            $data[$key.'.tags'] = 'nullable|string';
        }
        $request->validate($data);

        //store date except image
        $post = Post::create($request->except('image','_token', '_method'));

        //store category image
        if($request->has('image')){
            // $path = $request->file('image')->store('images');
            $path = $this->upload($request->image);
            $post->update(['image' => $path]);
        }

        //redir to index page after storing
        return redirect(route('dashboard.post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        //get catagories
        $categories = Category::all();
        foreach($categories as $item){
            $categoriesID[] = $item->id;
        }
        //validate request
        $data = [
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'category_id'   => 'nullable|'.Rule::in($categoriesID),
        ];
        foreach(config('app.languages') as $key => $value){
            $data[$key.'.title']   = 'required|string';
            $data[$key.'.content'] = 'nullable|string';
            $data[$key.'.smallDesc'] = 'nullable|string';
            $data[$key.'.tags'] = 'nullable|string';
        }
        $request->validate($data);

        $post->update($request->except('image','_token', '_method'));

        //store category image
        if($request->has('image')){
            // $path = $request->file('image')->store('images');
            $path = $this->upload($request->image);
            $post->update(['image' => $path]);
        }

        //return to edit page after updating
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPosts(){
        $data = Post::all();
        // return dd($data);
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('img', function($row){
            return $img = '
            <img src="'.asset($row->image).'" width=100 alt="post picture"> '; 
        })
        ->addColumn('action', function($row){
            return $btn = '
            <a href="'.route('dashboard.post.edit', $row->id) .'" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a><a id="deleteBtn" data-id="'. $row->id .'" class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a> ';
        })
        
        // ->addColumn('status', function($row){
        //     return $row->status == "published"?"منشور":"مسودة";
        // })
        // ->addColumn('url', function($row){
        //     return '<a href="'. route('news.post',[$row->id,$row->slug]).'" target="_blanck">الذهاب للمقالة</a>';
        // })
        // ->addColumn('date', function($row){
        //     return $row->created_at->toDateString();
        // })
        ->rawColumns(['action','img','smallDesc'])
        ->make(true);
       
    }
}
