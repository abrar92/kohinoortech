  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="DeleteCompany" tabindex="-1" role="dialog" aria-labelledby="DeleteCompanyLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="DeleteCompanyLabel">ALERT! Are you sure to delete Company?</h2>
          <h5 class="modal-sub-title" id="DeleteCompanyLabel">This Company is not yet assigned to user. </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="company-name" class="col-form-label">Company Name:</label>
              <input type="text" class="form-control" id="dlt_company_name" readonly>
            </div>
            <input type="hidden" id="dlt_company_id" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="dlt_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-dlt-company">DELETE Company</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#DeleteCompany').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var company_name = button.data('whatever') // Extract info from data-* attributes
        var company_id   = button.data('company_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ALERT! Are you sure to delete Company?')
        modal.find('.modal-body input').val(company_name)
        modal.find('#dlt_company_id').val(company_id)
        $.getJSON("{{route('get_company_user')}}?id="+company_id, function(result){
          if(result.message == 'Done'){
            if(result.names != ''){
              var names = result.names.join(", ");
              modal.find('.modal-sub-title').text('This Company has been assigned to '+names)
            }else{
              modal.find('.modal-sub-title').text('This Company is not yet assigned to user.');
            }
          }
        });
    });

    $('#btn-dlt-company').on('click', function (event) {
        var company_id = $('#dlt_company_id').val();
        $.ajax({
            url: "{{route('delete_company')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {'company_id': company_id},
            success: function(resp){
                if(resp.message == 'Done'){ 
                    $("#dlt_resp_msg").text('Congrats, Company Successfully Deleted!');
                    $("#dlt_resp_msg").css({'color': 'Green'});
                }else{
                    $("#dlt_resp_msg").text('Whoops, Please try again later!');
                    $("#dlt_resp_msg").css({'color': 'Green'});
                }
                setTimeout(function() {
                    $('#DeleteCompany').modal('hide');
                    location.reload();
                }, 3000);
            },
            error: function(err){
                $("#dlt_resp_msg").text(err.message);
                $("#dlt_resp_msg").css({'color': 'Red'});
                setTimeout(function() {
                    $('#DeleteCompany').modal('hide');
                }, 3000);
            }
        });
    });
  </script>