<h5 onclick="showLanguages();">{{__('Languages')}}</h5>
<div class="row">
  <div class="col-md-12">
    <div class="" id="language_div"></div>
    </div>
  </div>
  <a href="javascript:;" onclick="showProfileLanguageModal();"> {{__('Add Language')}} </a>
<hr>
<div class="modal fade" id="add_language_modal" role="dialog"></div>
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
			url: "{{ route('get.front.profile.language.form', $user->id) }}",
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
			url: "{{ route('get.front.profile.language.edit.form', $user->id) }}",
			data: {"profile_language_id": profile_language_id,"_token": "{{ csrf_token() }}"},
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
  var msg = "{{__('Are you sure! you want to delete?')}}";
  if (confirm(msg)) {
	  $.post("{{ route('delete.front.profile.language') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
			  .done(function (response) {
				  if (response == 'ok')
				  {
					  $('#language_'+id).remove();
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
		$.post("{{ route('show.front.profile.languages', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
		.done(function (response) {
		$('#language_div').html(response);
		});		
    }
</script> 
@endpush