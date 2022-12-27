<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class ApiController extends Controller
{
    public function create(Request $request){

        $request->validate([
         "name"=>"required",
         "email"=>"required|email|unique:employees",
         "phone"=>"required",
         "gender"=>"required",
         "age"=>"required",
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->save();
        return response()->json([
            "status"=> 200,
            "message"=>"Employee Created Succesfully"
        ],200);
    }
    public function getEmployees(){
        $employee = Employee::get();
        return response()->json([
            "status"=>200,
            "message"=>"Employee list get successfully",
            "data"=>$employee
        ],200);

    }
    public function getSingleEmployee($id){
        // $request->validate([
        //     "id"=>"required"
        // ]);

        if(Employee::where("id", $id)->exists()){
            $e_detail = Employee::where("id", $id)->first();
            return response()->json([
                "status"=>200,
                "message"=>"Get individual employee successfully",
                "data"=>$e_detail
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Employee not found",
            ],404);
        }
    }
    public function updateEmployee(Request $request, $id){
        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);
            $employee->name = $request->name ?? $employee->name;
            $employee->email = $request->email ?? $employee->email;
            $employee->phone = $request->phone ?? $employee->phone;
            $employee->gender = $request->gender ?? $employee->gender;
            $employee->age = $request->age ?? $employee->age;

            $employee->save();
            
            return response()->json([
                "status"=>200,
                "message"=>"Employee updated successfully",
                "data"=>$employee
            ],200);

        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Employee not found",
            ],404);
        }

    }
    public function deleteEmployee($id){
        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);

            $employee->delete();
            return response()->json([
                "status"=>200,
                "message"=>"Employee deleted successfully"
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Employee not found",
            ],404);
        }
    }
}
