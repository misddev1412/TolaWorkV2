{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group">
        <button class="btn purple btn-outline sbold" onclick="showProfileSkillModal();"> Add Skill </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Skill</span> </div>
                </div>
                <div class="portlet-body"><div class="row" id="skill_div"></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_skill_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
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
    function showProfileSkillModal(){
    $("#add_skill_modal").modal();
    loadProfileSkillForm();
    }
    function loadProfileSkillForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.skill.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_skill_modal").html(json.html);
            }
    });
    }
    function showProfileSkillEditModal(skill_id){
    $("#add_skill_modal").modal();
    loadProfileSkillEditForm(skill_id);
    }
    function loadProfileSkillEditForm(skill_id){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.skill.edit.form', $user->id) }}",
            data: {"skill_id": skill_id, "_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_skill_modal").html(json.html);
            }
    });
    }
    function submitProfileSkillForm() {
    var form = $('#add_edit_profile_skill');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
            $ ("#add_skill_modal").html(json.html);
            showSkills();
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
    function delete_profile_skill(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.profile.skill') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#skill_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
    $(document).ready(function(){
    showSkills();
    });
    function showSkills()
    {
    $.post("{{ route('show.profile.skills', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#skill_div').html(response);
            });
    }
</script> 
@endpush