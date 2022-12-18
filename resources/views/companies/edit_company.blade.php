  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="EditCompany" tabindex="-1" role="dialog" aria-labelledby="EditCompanyLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="EditCompanyLabel">ALERT! Are you sure to Edit Company?</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="company-name" class="col-form-label">Company Name:</label>
              <input type="text" class="form-control" id="edt_company_name" >
            </div>
            <input type="hidden" id="edt_company_id" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="edt_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-edt-company">Edit Company</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#EditCompany').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var company_name = button.data('whatever') // Extract info from data-* attributes
        var company_id   = button.data('company_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ALERT! Are you sure to edit Company?')
        modal.find('.modal-body input').val(company_name)
        modal.find('#edt_company_id').val(company_id)
        
    });

    $('#btn-edt-company').on('click', function (event) {
        var company_id = $('#edt_company_id').val();
        var company_name = $('#edt_company_name').val();
        $.ajax({
            url: "{{route('edit_company')}}",
            type: 'POST',
            async: false,
            dataType: 'JSON',
            data: {'company_id': company_id, 'company_name':company_name},
            success: function(resp){
                if(resp.message == 'Done'){ 
                    $("#edt_resp_msg").text('Congrats, Company Successfully Edited!');
                    $("#edt_resp_msg").css({'color': 'Green'});
                }else{
                    $("#edt_resp_msg").text('Whoops, Please try again later!');
                    $("#edt_resp_msg").css({'color': 'Green'});
                }
                setTimeout(function() {
                    $('#EditCompany').modal('hide');
                    location.reload();
                }, 3000);
            },
            error: function(err){
                $("#edt_resp_msg").text(err.message);
                $("#edt_resp_msg").css({'color': 'Red'});
                setTimeout(function() {
                    $('#EditCompany').modal('hide');
                }, 3000);
            }
        });
    });

  </script>