<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|String',
            'email' => 'required|email|unique:users',
            'status' => 'nullable|in:admin,writer',
            'password' => 'required|String|min:6',    
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->status = $request->status;
        $user->save();
        return back()->withErrors(['message' => 'user created successfuly!']);

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
    public function edit(User $user)
    {
        return view('dashboard.users.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $user = User::where('id',$id)->first();
        // return $user;
        $valiEmail = ($user->email == $request->email)? '' : '|unique:users,email';
        $valid = $request->validate([
            'name' => 'required|String',
            'email' => 'required|email'.$valiEmail,
            'status' => 'nullable|'.Rule::in(['admin','writer']),    
        ]);
        if($valid){
            $user->update($request->except(['_token','_method']));
            return back()->withErrors(['message' => 'information updated']);
        }
        return 'error';
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

    public function delete(Request $req){
        return $req;
    }

    public function getUsers(){
        $data = User::select('*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return $btn = '
                <a href="'.route('dashboard.users.edit', $row->id) .'" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a><a id="deleteBtn" data-id="'. $row->id .'" class="edit btn btn-danger deleteBtn btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a> ';
            })
            // ->addColumn('user', function($row){
            //     return $row->user->shown_name; 
            // })
            // ->addColumn('status', function($row){
            //     return $row->status == "published"?"منشور":"مسودة";
            // })
            // ->addColumn('url', function($row){
            //     return '<a href="'. route('news.post',[$row->id,$row->slug]).'" target="_blanck">الذهاب للمقالة</a>';
            // })
            // ->addColumn('date', function($row){
            //     return $row->created_at->toDateString();
            // })
            ->rawColumns(['action'])
            ->make(true);
    }
}
