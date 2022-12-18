<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Company;
use App\Models\RelationMatrix;

class UserController extends Controller
{
    function index(){
        return 0;
    }

    function user_list(){
        $data['users'] = User::all();
        return view('users.list',$data);            
    }

    function add_user(Request $request){
        try {
            $validator = \Validator::make($request->all(), [
                'user_email' => 'required|email',
                'user_name' => 'required'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }

            $check_name = User::where('name', $request->user_name)->first(); 
            $check_email = User::where('email', $request->user_email)->first(); 
            if(is_null($check_name) && is_null($check_email)){
                // The User Name does not exist.
                $query_resp = User::create(['name' => $request->user_name, 'email' => $request->user_email, 'password' => Hash::make('password')]);
                return response()->json([
                    'message' => 'Done',
                ], 200);
            } else if(!is_null($check_email)){
                // User Email already exist.
                return response()->json([
                    'message' => 'User Email already exist.',
                ], 200);
            }else{
                // User Name already exist.
                return response()->json([
                    'message' => 'User Name already exist.',
                ], 200);
            }           
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    function edit_user(Request $request){
        try {
            $validator = \Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'user_email' => 'required|email',
                'user_name' => 'required'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }

            User::where('id', $request->user_id)->update(['name' => $request->user_name, 'email' => $request->user_email]);

            return response()->json([
                'message' => 'Done',
            ], 200); // Returnng Success Response.

        } catch (\Exception $e) {
            // When any exception occurs.
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    function delete_user(Request $request){
        DB::beginTransaction();
        try {
            $validator = \Validator::make($request->all(), [
                'user_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }
            $userID =  $request->user_id;
            
            RelationMatrix::where('user_id', '=', $userID)->delete();
            
            User::where('id', '=', $userID)->delete();
            /* Have used transaction here.
                Because if one of the query fails all transactio has to rolledback to maintain consistency.
                User has to be deleted either from both table or should not deleted.
            */
            DB::commit();

            return response()->json([
                'message' => 'Done',
            ], 200); // Returnng Success Response.

        } catch (\Exception $e) {
            // When any exception occurs.
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    function get_user_company(Request $request){
        try {           # Defined TRY Block to handle the Exception.
            $validator = \Validator::make($request->all(), [
                'id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }
            $allCompany = Company::all()->toArray();
            $userCollection = RelationMatrix::where('user_id', $request->id)->get();
            if($userCollection->count() == 0 || $userCollection == null){
                $existingUsers = [];
                $usersName = [];
            }else{
                foreach($userCollection as $row){
                    $existingUsers[] = $row['company_id'];
                    $usersName[] = $allCompany[$row['company_id']]['company_name'];
                }
            }
            return response()->json([
                'message' => 'Done',
                'values'  => $existingUsers,
                'names'   => $usersName
            ], 200);

        } catch (\Exception $e) {
            // When any exception occurs.
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
