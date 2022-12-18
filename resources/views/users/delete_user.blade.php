  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="DeleteUser" tabindex="-1" role="dialog" aria-labelledby="DeleteUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="DeleteUserLabel">ALERT! Are you sure to delete User?</h2>
          <h5 class="modal-sub-title" id="DeleteUserLabel">The User is not yet assigned to Company.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="user-name" class="col-form-label">User Name:</label>
              <input type="text" class="form-control" id="dlt_user_name" readonly>
            </div>
            <input type="hidden" id="dlt_user_id" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="dlt_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-dlt-user">DELETE User</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#DeleteUser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var user_name = button.data('whatever') // Extract info from data-* attributes
        var user_id   = button.data('user_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ALERT! Are you sure to delete User?')
        modal.find('.modal-body input').val(user_name)
        modal.find('#dlt_user_id').val(user_id)
        $.getJSON("{{route('get_user_company')}}?id="+user_id, function(result){
          if(result.message == 'Done'){
            if(result.names != ''){
              var names = result.names.join(", ");
              modal.find('.modal-sub-title').text('This User has been assigned to '+names)
            }else{
              modal.find('.modal-sub-title').text('This User is not yet assigned to Company.');
            }
          }
        });
    });

    $('#btn-dlt-user').on('click', function (event) {
        var user_id = $('#dlt_user_id').val();
        $.ajax({
            url: "{{route('delete_user')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {'user_id': user_id},
            success: function(resp){
                if(resp.message == 'Done'){ 
                    $("#dlt_resp_msg").text('Congrats, User Successfully Deleted!');
                    $("#dlt_resp_msg").css({'color': 'Green'});
                }else{
                    $("#dlt_resp_msg").text('Whoops, Please try again later!');
                    $("#dlt_resp_msg").css({'color': 'Green'});
                }
                setTimeout(function() {
                    $('#DeleteUser').modal('hide');
                    location.reload();
                }, 3000);
            },
            error: function(err){
                $("#dlt_resp_msg").text(err.message);
                $("#dlt_resp_msg").css({'color': 'Red'});
                setTimeout(function() {
                    $('#DeleteUser').modal('hide');
                }, 3000);
            }
        });
    });
  </script>