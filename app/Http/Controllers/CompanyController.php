<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    function index(){
        return 0;
    }

    function company_list(){
        $data['companies'] = Company::all();
        return view('companies.list',$data); 
    }
}
