{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group">
        <button class="btn purple btn-outline sbold" onclick="showProfileExperienceModal();"> Add Experience </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Experience</span> </div>
                </div>
                <div class="portlet-body"><div class="row" id="experience_div"></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_experience_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
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
    function showProfileExperienceModal(){
    $("#add_experience_modal").modal();
    loadProfileExperienceForm();
    }
    function loadProfileExperienceForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.experience.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_experience_modal").html(json.html);
            initdatepicker();
            }
    });
    }
    function showProfileExperienceEditModal(profile_experience_id, state_id, city_id){
    $("#add_experience_modal").modal();
    loadProfileExperienceEditForm(profile_experience_id, state_id, city_id);
    }
    function loadProfileExperienceEditForm(profile_experience_id, state_id, city_id){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.experience.edit.form', $user->id) }}",
            data: {"profile_experience_id": profile_experience_id, "_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_experience_modal").html(json.html);
            initdatepicker();
            filterDefaultStatesExperience(state_id, city_id);
            }
    });
    }
    function submitProfileExperienceForm() {
    var form = $('#add_edit_profile_experience');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
            $ ("#add_experience_modal").html(json.html);
            showExperience();
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
    function delete_profile_experience(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.profile.experience') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#experience_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
    function initdatepicker(){
    $(".datepicker").datepicker({
    autoclose: true,
            format:'yyyy-m-d'
    });
    }
    $(document).ready(function(){
    showExperience();
    initdatepicker();
    $(document).on('change', '#experience_country_id', function (e) {
    e.preventDefault();
    filterDefaultStatesExperience(0, 0);
    });
    $(document).on('change', '#experience_state_id', function (e) {
    e.preventDefault();
    filterDefaultCitiesExperience(0);
    });
    });
    function showExperience()
    {
    $.post("{{ route('show.profile.experience', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#experience_div').html(response);
            });
    }





    function filterDefaultStatesExperience(state_id, city_id)
    {
    var country_id = $('#experience_country_id').val();
    if (country_id != ''){
    $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, new_state_id: 'experience_state_id', _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_state_experience_dd').html(response);
            filterDefaultCitiesExperience(city_id);
            });
    }
    }
    function filterDefaultCitiesExperience(city_id)
    {
    var state_id = $('#experience_state_id').val();
    if (state_id != ''){
    $.post("{{ route('filter.default.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_city_experience_dd').html(response);
            });
    }
    }
</script> 
@endpush