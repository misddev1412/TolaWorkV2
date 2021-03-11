{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body"> 
    <div class="form-group"> <button class="btn purple btn-outline sbold" onclick="showProfileCvModal();"> Add Cv </button> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Cvs</span> </div>
                </div>
                <div class="portlet-body">
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row" id="cvs_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_cv_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
    $(document).ready(function(){
    showCvs();
    });
    /**************************************************/
    function showProfileCvModal(){
    $("#add_cv_modal").modal();
    loadProfileCvForm();
    }
    function loadProfileCvForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.cv.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_cv_modal").html(json.html);
            }
    });
    }
    function submitProfileCvForm() {
    var form = $('#add_edit_profile_cv');
    var formData = new FormData();
    formData.append("id", $('#id').val());
    formData.append("_token", $('input[name=_token]').val());
    formData.append("title", $('#title').val());
    formData.append("is_default", $('input[name=is_default]:checked').val());
    if (document.getElementById("cv_file").value != "") {
    formData.append("cv_file", $('#cv_file')[0].files[0]);
    }
    //form.attr('method'),
    $.ajax({
    url     : form.attr('action'),
            type    : 'POST',
            data    : formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success : function (json){
            $ ("#add_cv_modal").html(json.html);
            showCvs();
            },
            error: function(json){
            if (json.status === 422) {
            var resJSON = json.responseJSON;
            $('.help-block').html('');
            $.each(resJSON.errors, function (key, value) {
            $('.' + key + '-error').html('<strong>' + value + '</strong>');
            $('#div_' + key).addClass('has-error');
            });
            } else {
            // Error
            // Incorrect credentials
            // alert('Incorrect credentials. Please try again.')
            }
            }
    });
    }
    /*****************************************/
    function showProfileCvEditModal(cv_id){
    $("#add_cv_modal").modal();
    loadProfileCvEditForm(cv_id);
    }
    function loadProfileCvEditForm(cv_id){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.cv.edit.form', $user->id) }}",
            data: {"cv_id": cv_id, "_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_cv_modal").html(json.html);
            }
    });
    }
    /*****************************************/
    function showCvs()
    {
    $.post("{{ route('show.profile.cvs', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#cvs_div').html(response);
            });
    }
    function delete_profile_cv(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.profile.cv') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#cv_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
</script>
@endpush
