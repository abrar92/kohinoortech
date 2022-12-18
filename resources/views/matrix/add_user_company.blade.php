{{-- # Modal Popup Code # --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="addUserModalLabel">New message</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="company-name" class="col-form-label">Company:</label>
              <input type="text" class="form-control" id="company-name" readonly>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Users:</label>
              <select id="selectUsers" class="selectpicker" multiple data-live-search="true">
                @foreach($users as $user)
                <option value="{{$user['id']}}" >{{$user['name']}}</option>
                @endforeach
              </select>
            </div>
            <input type="hidden" id="company_id" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-add-user">ADD USER</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}
  
  <script>

    $('#addUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var company_name = button.data('whatever') // Extract info from data-* attributes
        var company_id   = button.data('company_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Adding New User to ' + company_name)
        modal.find('.modal-body input').val(company_name)
        modal.find('#company_id').val(company_id)
        
    });

    $('#btn-add-user').on('click', function (event) {
        var userIds = $('#selectUsers').val();
        var company_id = $('#company_id').val();
        $.ajax({
            url: "{{route('modify_user')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {'userIds':userIds, 'company_id': company_id},
            success: function(resp){
                if(resp.message == 'Done'){
                    $("#resp_msg").text('Congrats, Users Are Successfully Added!');
                    $("#resp_msg").css({'color': 'Green'});
                }else{
                    $("#resp_msg").text('Whoops, Please try again later!');
                    $("#resp_msg").css({'color': 'Green'});
                }
            },
            error: function(err){
                $("#resp_msg").text(err.message);
                $("#resp_msg").css({'color': 'Red'});
            }
        });
    });
  </script>