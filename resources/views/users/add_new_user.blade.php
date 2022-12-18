  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="addNewUserLabel">Add New User Here</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="user-name" class="col-form-label">User Name:</label>
              <input type="text" class="form-control" id="user_name" >
            </div>
            <div class="form-group">
                <label for="user-email" class="col-form-label">User Email:</label>
                <input type="text" class="form-control" id="user_email" >
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="user_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-new-user">ADD User</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#addNewUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var user_name = button.data('whatever') // Extract info from data-* attributes
        var user_id   = button.data('user_id') // Extract info from data-* attributes
        var user_email   = button.data('user_email') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Adding New User')
        modal.find('.modal-body input').val(user_name)
        modal.find('#user_id').val(user_id)
        modal.find('#user_email').val(user_email)
        
    });


    $('#btn-new-user').on('click', function (event) {
        var user_name = $('#user_name').val();
        var user_email = $('#user_email').val();
        $.ajax({
            url: "{{route('add_user')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {'user_name': user_name, 'user_email': user_email},
            success: function(resp){
                if(resp.message == 'Done'){ 
                    $("#user_resp_msg").text('Congrats, User Name Successfully Added!');
                    $("#user_resp_msg").css({'color': 'Green'});
                }else{
                    $("#user_resp_msg").text('Whoops, Please try again later!');
                    $("#user_resp_msg").css({'color': 'Green'});
                }
                setTimeout(function() {
                    $('#addNewUser').modal('hide');
                    location.reload();
                }, 3000);
            },
            error: function(err){
                $("#user_resp_msg").text(err.message);
                $("#user_resp_msg").css({'color': 'Red'});
                setTimeout(function() {
                    $('#addNewUser').modal('hide');
                }, 3000);
            }
        });
    });
  </script>