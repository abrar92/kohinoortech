<!DOCTYPE html>
<html lang="en">
    @include('layout.head')
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <caption>
                            <span class="table-caption">List of Companies:</span>
                            <span class="add-new-button">
                                <button type="button" class="btn btn-success btn-sm" id="new_company" data-toggle="modal" data-target="#addNewCompany">Add New Company</button>
                            </span>
                        </caption>
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Sr No</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Add User</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp 
                            @foreach ($companies as $company)  
                            <tr>
                                <th scope="row">{{$counter}}</th>
                                <td>{{$company['company_name']}}</td>
                                <td><button type="button" class="btn btn-primary btn-sm" id="assign_user" data-toggle="modal" data-target="#addUserModal" data-company_id="{{$company['id']}}" data-whatever="{{$company['company_name']}}">Assign User</button></td>
                                <td class="edit-link"><button type="button" class="btn btn-info btn-sm" id="edit_company" data-toggle="modal" data-target="#EditCompany" data-company_id="{{$company['id']}}" data-whatever="{{$company['company_name']}}">Edit</button></td>
                                <td class="delete-link"><button type="button" class="btn btn-danger btn-sm" id="delete_company" data-toggle="modal" data-target="#DeleteCompany" data-company_id="{{$company['id']}}" data-whatever="{{$company['company_name']}}">Delete</button></td>                      
                            </tr>
                            @php
                                $counter++;
                            @endphp 
                            @endforeach
                        </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
    </body>

    @include('matrix.add_user_company');

    @include('companies.add_new_company');

    @include('companies.delete_company');

    @include('companies.edit_company');
</html>