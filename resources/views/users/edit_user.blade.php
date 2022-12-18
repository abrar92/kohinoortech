  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="EditUserLabel">ALERT! Are you sure to Edit User?</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="user-name" class="col-form-label">User Name:</label>
              <input type="text" class="form-control" id="edt_user_name" >
            </div>
            <div class="form-group">
                <label for="user-email" class="col-form-label">User Email:</label>
                <input type="text" class="form-control" id="edt_user_email" >
              </div>
            <input type="hidden" id="edt_user_id" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="edt_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-edt-user">Edit User</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#EditUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var user_name = button.data('whatever') // Extract info from data-* attributes
        var user_id   = button.data('user_id') // Extract info from data-* attributes
        var user_email   = button.data('user_email') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ALERT! Are you sure to edit User?')
        modal.find('.modal-body input').val(user_name)
        modal.find('#edt_user_id').val(user_id)
        modal.find('#edt_user_email').val(user_email)
        
    });

    $('#btn-edt-user').on('click', function (event) {
        var user_id = $('#edt_user_id').val();
        var user_name = $('#edt_user_name').val();
        var user_email = $('#edt_user_email').val();
        $.ajax({
            url: "{{route('edit_user')}}",
            type: 'POST',
            async: false,
            dataType: 'JSON',
            data: {'user_id': user_id, 'user_name':user_name, 'user_email':user_email},
            success: function(resp){
                if(resp.message == 'Done'){ 
                    $("#edt_resp_msg").text('Congrats, User Successfully Edited!');
                    $("#edt_resp_msg").css({'color': 'Green'});
                }else{
                    $("#edt_resp_msg").text('Whoops, Please try again later!');
                    $("#edt_resp_msg").css({'color': 'Green'});
                }
                setTimeout(function() {
                    $('#EditUser').modal('hide');
                    location.reload();
                }, 3000);
            },
            error: function(err){
                $("#edt_resp_msg").text(err.message);
                $("#edt_resp_msg").css({'color': 'Red'});
                setTimeout(function() {
                    $('#EditUser').modal('hide');
                }, 3000);
            }
        });
    });

  </script>