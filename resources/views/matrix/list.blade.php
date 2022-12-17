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
                            <span class="table-caption">Relation Matrix:</span>
                            <span class="add-new-button">
                                <button type="button" class="btn btn-primary btn-sm">Add New User</button>
                            </span>
                        </caption>
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Sr No</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp 
                            @foreach ($relationMatrix as $row)  
                            <tr>
                                <th scope="row">{{$counter}}</th>
                                <td>{{$row['name']}}</td>
                                <td>{{$row['company_name']}}</td>
                                <td class="edit-link">Edit</td>
                                <td class="delete-link">Delete</td>                            
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
</html>