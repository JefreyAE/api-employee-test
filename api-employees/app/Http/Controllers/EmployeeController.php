<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(Request $request){

        $employee = new Employee();

        $data = $employee->all();

        return response()->json($data,200);
    }

    public function get_employee(Request $request, $id){

        $data = Employee::where('id', $id)->first();

        return response()->json($data,200);
    }

    public function create(Request $request){
        /*
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        */

        $json = $request->input('json',null);

        $params_array = json_decode($json, true);

        $validate = Validator::make($params_array,[
            'fist_name' => 'require|alpha',
            'last_name' => 'require|alpha',
            'email' => 'require|email'
        ]);

        if($validate->failed()){
            $data = array(
                'status' => 'error',
                'code'   => 400,
                'message' => 'Usuario no se a creado correctamente',
                'errors'  =>  $validate->errors()
            );
        }else{
            $employee = new Employee();

            $employee->first_name = $params_array['first_name'];
            $employee->last_name = $params_array['last_name'];
            $employee->email = $params_array['email'];

            $employee->save();

            $data = array(
                'status' => 'success',
                'code'   => 200,
                'message' => 'Usuario creado correctamente'
            );
        }

        return response()->json($data, $data['code']);
    }
    public function update(Request $request){
        $json = $request->input('json',null);

        $params_array = json_decode($json, true);

        $id = $params_array['id'];
        $first_name =  $params_array['first_name'];
        $last_name =  $params_array['last_name'];
        $email =  $params_array['email'];

        $validate = Validator::make($params_array,[
            'id'        => 'required|numeric',
            'fist_name' => 'require|alpha',
            'last_name' => 'require|alpha',
            'email' => 'require|email'
        ]);

        if($validate->failed()){
            $data = array(
                'status' => 'error',
                'code'   => 400,
                'message' => 'Usuario no se a creado correctamente',
                'errors'  =>  $validate->errors()
            );
        }else{
            $employee = Employee::where('id',$id)->first();

            $employee->first_name = $params_array['first_name'];
            $employee->last_name = $params_array['last_name'];
            $employee->email = $params_array['email'];

            $employee->save();

            $data = array(
                'status' => 'success',
                'code'   => 200,
                'message' => 'Usuario actualizado correctamente'
            );
        }

        return response()->json($data, $data['code']);
    }
    public function delete_employee(Request $request, $id){
        
        $employee = Employee::where('id', $id)->first();

        $employee->delete();

        $data = array(
            'status' => 'success',
            'code'   => 200,
            'message' => 'Usuario borrado correctamente'
        );
        return response()->json($data,200);
    }

    public function search(Request $request, $find){
        $data = Employee::where('first_name', 'LIKE', '%'.$find.'%')->get();

        return response()->json($data,200);
    }

    public function delete_selected(Request $request, $ids){
        $ids = rtrim($ids,"_");
        $ids_list = explode("_", $ids);

        foreach($ids_list as $id){
            if(is_int(intval($id))){
                $employee = Employee::where('id', $id)->first();
                $employee->delete();
            }
        }

        $data = array(
            'status' => 'success',
            'code'   => 200,
            'message' => 'Usuarios borrados correctamente'
        );
        
        return response()->json($data, $data['code']);
    }

}
