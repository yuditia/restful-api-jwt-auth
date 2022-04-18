<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

     public function index()
    {
        $user = User::all();

        return response()->json([
            "success"=>true,
            "message"=>"All data User",
            "data"=>$user
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            "name"=>'required|max:255',
            "email"=>'email|required',
            "password"=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);


        if($user){
            return response()->json([
                'success'=>true,
                'message'=>"User has been created",
                'data'=>$user
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>"fail create user"
            ],409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrfail($id);
        if($user){
            return response()->json([
                'success'=>true,
                'message'=>"Detail data user",
                'data'=>$user
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'User not found'
            ],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(),[
            "name"=>'required|max:255',
            "email"=>'email|required',
            "password"=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::findOrfail($id);

        if($user){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'User has been updated',
                'data'=>$user
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'Update fails'
            ],409);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);

        if($user){
            $user->delete();
            return response()->json([
                'success'=>true,
                'message'=>'User has been deleted',
                'data'=>$user
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'User fail to delete'
            ],409);
    }
}
