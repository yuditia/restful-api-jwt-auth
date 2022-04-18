<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\get(
     * path="/api/employee",
     * summary="generate all data",
     * description="displaying all data employees",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
     public function index()
    {
        $employee = Employee::all();
        return response()->json([
            'success'=>true,
            'message'=>'All data costummers',
            'data'=>$employee
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'email'=>'nullable',
            'address'=>'required|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $employee = Employee::create($validator->validate());
        if($employee){
            return response()->json([
                'success'=>true,
                'message'=>'Data berhasil disimpan',
                'data'=>$employee
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'Data gagal disimpan'
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
        $employee = Employee::findOrfail($id);
        if($employee){
            return response()->json([
                'success'=>true,
                'message'=>'Detail data employee',
                'data'=>$employee
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'Data kosong/tidak ada'
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
            'name'=>'required|max:255',
            'email'=>'nullable',
            'address'=>'required|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $employee = Employee::findOrfail($id);
        if($employee){
            $employee->update($validator->validate());
            return response()->json([
                'success'=>true,
                'message'=>'Data employee berhasil diupdate',
                'data'=>$employee
            ],200);
        }
            return response()->json([
                'success'=>true,
                'message'=>'Data gagal diupdate'
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
        $employee = Employee::findOrfail($id);
        if($employee){
            $employee->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Data berhasil dihapus',
                'data'=>$employee
            ],200);
        }
            return response()->json([
                'success'=>false,
                'message'=>'Data gagal hapus'
            ],409);
    }
}
