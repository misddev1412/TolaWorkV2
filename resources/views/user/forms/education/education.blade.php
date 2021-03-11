<h5 onclick="showEducation();">{{__('Education')}}</h5>
<div class="row">
  <div class="col-md-12">
    <div class="" id="education_div"></div>
  </div>
</div>
  <a href="javascript:;" onclick="showProfileEducationModal();"> {{__('Add Education')}} </a>
<hr>
<div class="modal fade" id="add_education_modal" role="dialog"></div>
@push('styles')
<style type="text/css">
.datepicker>div {
    display: block;
}
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
/**************************************************/
function showProfileEducationModal(){
$("#add_education_modal").modal();
	loadProfileEducationForm();
}
function loadProfileEducationForm(){
	$.ajax({
	type: "POST",
			url: "{{ route('get.front.profile.education.form', $user->id) }}",
			data: {"_token": "{{ csrf_token() }}"},
			datatype: 'json',
			success: function (json) {
				$("#add_education_modal").html(json.html);
				initdatepicker();
				filterLangStatesEducation(0, 0);
			}
	});
}

function showProfileEducationEditModal(education_id, state_id, city_id, degree_type_id){
$("#add_education_modal").modal();
	loadProfileEducationEditForm(education_id, state_id, city_id, degree_type_id);
}
function loadProfileEducationEditForm(education_id, state_id, city_id, degree_type_id){
	$.ajax({
	type: "POST",
			url: "{{ route('get.front.profile.education.edit.form', $user->id) }}",
			data: {"education_id": education_id,"_token": "{{ csrf_token() }}"},
			datatype: 'json',
			success: function (json) {
				$("#add_education_modal").html(json.html);
				initdatepicker();
				filterLangStatesEducation(state_id, city_id);
				filterDegreeTypes(degree_type_id);
			}
	});
}


function submitProfileEducationForm() {
	var form = $('#add_edit_profile_education');
	$.ajax({
		url     : form.attr('action'),
		type    : form.attr('method'),
		data    : form.serialize(),
		dataType: 'json',
		success : function (json){
			$ ("#add_education_modal").html(json.html);
			showEducation();
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

function delete_profile_education(id) {
  var msg = "{{__('Are you sure! you want to delete?')}}";
  if (confirm(msg)) {
	  $.post("{{ route('delete.front.profile.education') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
			  .done(function (response) {
				  if (response == 'ok')
				  {
					  $('#education_'+id).remove();
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
	
	/*****/
	$('.select2-multiple').select2({
		placeholder: "{{__('Select Major Subjects')}}",
		allowClear: true
	});
}

    $(document).ready(function(){
    	showEducation();
		initdatepicker();
		
	$(document).on('change', '#degree_level_id', function (e) {
    e.preventDefault();
    filterDegreeTypes(0);
    });
	$(document).on('change', '#education_country_id', function (e) {
    e.preventDefault();
    filterLangStatesEducation(0, 0);
    });
    $(document).on('change', '#education_state_id', function (e) {
    e.preventDefault();
    filterLangCitiesEducation(0);
    });
	
    });
    
	
	function showEducation()
    {
		$.post("{{ route('show.front.profile.education', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
		.done(function (response) {
		$('#education_div').html(response);
		});		
    }
	
	
	function filterDegreeTypes(degree_type_id)
    {
    var degree_level_id = $('#degree_level_id').val();
    if (degree_level_id != ''){
    $.post("{{ route('filter.degree.types.dropdown') }}", {degree_level_id: degree_level_id, degree_type_id: degree_type_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            	$('#degree_types_dd').html(response);            
            });
    }
    }
	
	
	function filterLangStatesEducation(state_id, city_id)
    {
    var country_id = $('#education_country_id').val();
    if (country_id != ''){
    $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, new_state_id: 'education_state_id', _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_state_education_dd').html(response);
            filterLangCitiesEducation(city_id);
            });
    }
    }

    function filterLangCitiesEducation(city_id)
    {
    var state_id = $('#education_state_id').val();
    if (state_id != ''){
    $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_city_education_dd').html(response);
            });
    }
    }
</script> 
@endpush