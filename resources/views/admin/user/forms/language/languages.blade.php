{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group">
        <button class="btn purple btn-outline sbold" onclick="showProfileLanguageModal();"> Add Language </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Language</span> </div>
                </div>
                <div class="portlet-body"><div class="row" id="language_div"></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_language_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
    /**************************************************/
    function showProfileLanguageModal(){
    $("#add_language_modal").modal();
    loadProfileLanguageForm();
    }
    function loadProfileLanguageForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.language.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_language_modal").html(json.html);
            }
    });
    }
    function showProfileLanguageEditModal(profile_language_id){
    $("#add_language_modal").modal();
    loadProfileLanguageEditForm(profile_language_id);
    }
    function loadProfileLanguageEditForm(profile_language_id){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.language.edit.form', $user->id) }}",
            data: {"profile_language_id": profile_language_id, "_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_language_modal").html(json.html);
            }
    });
    }
    function submitProfileLanguageForm() {
    var form = $('#add_edit_profile_language');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
            $ ("#add_language_modal").html(json.html);
            showLanguages();
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
    function delete_profile_language(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.profile.language') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#language_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
    $(document).ready(function(){
    showLanguages();
    });
    function showLanguages()
    {
    $.post("{{ route('show.profile.languages', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#language_div').html(response);
            });
    }
</script> 
@endpush