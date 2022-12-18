  {{-- # Modal Popup Code # --}}
  <div class="modal fade" id="addNewCompany" tabindex="-1" role="dialog" aria-labelledby="addNewCompanyLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="addNewCompanyLabel">Add New Company Here</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="company-name" class="col-form-label">Company Name:</label>
              <input type="text" class="form-control" id="company_name" >
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <label style="float: left;" id="company_resp_msg"></label>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ABORT</button>
          <button type="button" class="btn btn-primary" id="btn-new-company">ADD Company</button>
        </div>
      </div>
    </div>
  </div>
  {{-- # Modal Popup Code # --}}

  <script>

    $('#addNewCompany').on('show.bs.modal', function (event) {
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


    $('#btn-new-company').on('click', function (event) {
        var company_name = $('#company_name').val();
        $.ajax({
            url: "{{route('add_company')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {'company_name': company_name},
            success: function(resp){
                console.log(resp.message);
                if(resp.message == 'Done'){ 
                    $("#company_resp_msg").text('Congrats, Company Name Successfully Added!');
                    $("#company_resp_msg").css({'color': 'Green'});
                }else{
                    $("#company_resp_msg").text('Whoops, Please try again later!');
                    $("#company_resp_msg").css({'color': 'Green'});
                }
            },
            error: function(err){
                $("#company_resp_msg").text(err.message);
                $("#company_resp_msg").css({'color': 'Red'});
            }
        });
    });
  </script>