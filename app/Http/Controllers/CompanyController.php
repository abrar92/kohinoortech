<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

use App\Models\Company;
use App\Models\User;
use App\models\RelationMatrix;
use Faker\Extension\CompanyExtension;
use PhpParser\Node\Stmt\TryCatch;

class CompanyController extends Controller
{
    function index(){
        return 0;
    }

    function company_list(){
        $data['companies'] = Company::all();
        $data['users'] = User::all();
        $relationCollection = RelationMatrix::all();
        if(!is_null($relationCollection)){
           // echo "<pre>";print_r($relationCollection); die;
        }
        return view('companies.list',$data); 
    }

    function add_company(Request $request){
        try {
            $validator = \Validator::make($request->all(), [
                'company_name' => 'required'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }

            $check_name = Company::where('company_name', $request->company_name)->first(); 
            if(is_null($check_name)){
                // The Company Name does not exist.
                $query_resp = Company::create(['company_name' => $request->company_name]);
                return response()->json([
                    'message' => 'Done',
                ], 200);
            }
            else{
                // Company Name already exist.
                return response()->json([
                    'message' => 'Company Name already exist.',
                ], 200);
            }           
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    function edit_company(Request $request){
        try {
            $validator = \Validator::make($request->all(), [
                'company_id' => 'required|numeric',
                'company_name' => 'required'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }

            Company::where('id', $request->company_id)->update(['company_name' => $request->company_name]);

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

    function delete_company(Request $request){
        DB::beginTransaction();
        try {
            $validator = \Validator::make($request->all(), [
                'company_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }
            $companyID =  $request->company_id;
            
            RelationMatrix::where('company_id', '=', $companyID)->delete();
            
            Company::where('id', '=', $companyID)->delete();
            /* Have used transaction here.
                Because if one of the query fails all transactio has to rolledback to maintain consistency.
                Company has to be deleted either from both table or should not deleted.
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

    function modify_user(Request $request){
        try {           # Defined TRY Block to handle the Exception.
            $validator = \Validator::make($request->all(), [
                'userIds'    => 'required',
                'company_id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                // if the validation fails.
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 500); // Response Sent with status 500 to Flag Error Response.
            }

            /*   Defined Belongs to Relationship to get company wise users     */
            $userCollection = User::find($request->company_id)->users;

            if(is_null($userCollection) || $userCollection->count() == 0){
                # This means no user found for this company.
                $existing_users = []; // defining blank array.
                // No existinf users found. All incoming users will be added.
            }else{
                foreach($userCollection as $user){
                    # Collecting existing users in array.
                    $existing_users[] = $user['id'];
                }
                /* Existing Users collected to compare and check the modifications. */
            }
            
            $new_users = $request->userIds; // Collecting updated users in array.
            
            $removed_users = array_diff($existing_users, $new_users); // Finding the users to remove from existing allocation.

            $added_users = array_diff($new_users, $existing_users);  //  Finding the users to add to existing allocation.
            
            if(!is_null($removed_users) && count($removed_users) > 0){ //Check if there is user to remove then run the logic
                RelationMatrix::where('company_id', $request->company_id)
                              ->where('user_id', $removed_users)
                              ->delete();
                /* Retaltion is Soft Deleted. */
            }

            if(!is_null($added_users) && count($added_users) > 0){ //Check if there is user to add then run the logic
                for($i = 0; $i<count($added_users); $i++){
                    // Iterating the loop so that each user can be added in table.
                    RelationMatrix::updateOrCreate(
                        ['company_id' => $request->company_id, 'user_id' => $added_users[$i]],
                        ['deleted_at', null]
                    );
                    /* *** updateOrCreate ***
                        This method accepts two parameters.
                        First as Condition
                        Second as Updating Value.
                        -- If first condition is found matched in table it will simply updated the value from second Parameter.
                        -- If condition not found matched it will simply create a new record and insert a new row with combining
                           first and second parameter.
                        @@ In our case it will check if user is previously deleted in table and record is still present, in this case
                           it will only update `deleted_at` column to null and relation will be activated.
                           Other wise It will create a new record by inserting a new row with same values [user_id, company_id, null].
                           Here we have done many condition checks in one statement also minimised the lines of codes.
                           Also, controlled rows count in matrix table. 
                    */
                }
            }
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
}
