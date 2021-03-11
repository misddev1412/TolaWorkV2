<h5>{{__('Summary')}}</h5>
<div class="row">
    <div class="col-md-12">
        <form class="form" id="add_edit_profile_summary" method="POST" action="{{ route('update.front.profile.summary', [$user->id]) }}">
            {{ csrf_field() }}
            <div class="form-body">
                <div id="success_msg"></div>
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'summary') !!}">
                    <textarea name="summary" class="form-control" id="summary" placeholder="{{__('Profile Summary')}}">{{ old('summary', $user->getProfileSummary('summary')) }}</textarea>
                    <span class="help-block summary-error"></span> </div>
                <button type="button" class="btn btn-large btn-primary" onClick="submitProfileSummaryForm();">{{__('Update Summary')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
</div>
@push('scripts') 
<script type="text/javascript">
    function submitProfileSummaryForm() {
        var form = $('#add_edit_profile_summary');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
                $("#success_msg").html("<span class='text text-success'>{{__('Summary updated successfully')}}</span>");
            },
            error: function (json) {
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
</script> 
@endpush            