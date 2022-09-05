<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::where('parent',null)->get();
        return view('dashboard.category.add',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //get the categories which have not parent
        //they are used for validating
        $parents = Category::where('parent', null)->get();
        foreach($parents as $item){
            $parentID[] = $item->id;
        }

        //validate request
        $data = [
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'parent'   => 'nullable|'.Rule::in($parentID),
        ];
        foreach(config('app.languages') as $key => $value){
            $data[$key.'.title']   = 'required|string';
            $data[$key.'.content'] = 'nullable|string';
        }
        $request->validate($data);

        //store date except image
        $category = Category::create($request->except('image','_token', '_method'));

        //store category image
        if($request->has('image')){
            $path = $request->file('image')->store('images');
            $category->update(['image' => $path]);
        }

        //return to edit page after storing
        return back();
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
     * @param  Category  $category
     * @return view
     */
    public function edit(Category $category)
    {
        $categories = Category::where('parent',null)->get();
        return view('dashboard.category.edit', [
            'categories' => $categories,
            'category'   => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request,Category $category)
    {
        //get the categories which have not parent 
        //they are used for validating
        $parents = Category::where('parent', null)->whereNot('id',$category->id)->get();
        foreach($parents as $item){
            $parentID[] = $item->id;
        }

        //validate request
        $data = [
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'parent' => 'nullable|'.Rule::in($parentID),
        ];
        foreach(config('app.languages') as $key => $value){
            $data[$key.'.title']   = 'required|string';
            $data[$key.'.content'] = 'nullable|string';
        }
        $request->validate($data);

        //updating data except image
        $category->update($request->except('image', '_token', '_method'));

        //change category image
        if($request->has('image')){
            if($category->image != null) unlink($category->image);
            $path = $request->file('image')->store('images');
            $category->update(['image' => $path]);
        }

        //return to edit page after updating
        return redirect(route('dashboard.category.index'));
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

    public function getCategories(){
        $data = Category::select('*')->with('parent');
        // return $data;
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('img', function($row){
            return $img = '
            <img src="'.asset($row->image).'" width=100 alt="category picture"> '; 
        })
        ->addColumn('action', function($row){
            return $btn = '
            <a href="'.route('dashboard.category.edit', $row->id) .'" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a><a id="deleteBtn" data-id="'. $row->id .'" class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a> ';
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
        ->rawColumns(['action','img'])
        ->make(true);
        // dd($data1);
    }
}
