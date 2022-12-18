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
                            <span class="table-caption">List of Users:</span>
                            <span class="add-new-button">
                                <button type="button" class="btn btn-success btn-sm" id="new_user" data-toggle="modal" data-target="#addNewUser">Add New User</button>
                            </span>
                        </caption>
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Sr No</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp 
                            @foreach ($users as $user)  
                            <tr>
                                <th scope="row">{{$counter}}</th>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td class="edit-link"><button type="button" class="btn btn-info btn-sm" id="edit_user" data-toggle="modal" data-target="#EditUser" data-user_id="{{$user['id']}}" data-whatever="{{$user['name']}}" data-user_email="{{$user['email']}}">Edit</button></td>
                                <td class="delete-link"><button type="button" class="btn btn-danger btn-sm" id="delete_user" data-toggle="modal" data-target="#DeleteUser" data-user_id="{{$user['id']}}" data-whatever="{{$user['name']}}">Delete</button></td>                            
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

    @include('users.add_new_user');

    @include('users.delete_user');

    @include('users.edit_user');

</html>