{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Job Experiences</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobExperienceSortData();')) !!}
    <div id="jobExperienceSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobExperienceSortData();
    });
    function refreshJobExperienceSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.experience.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#jobExperienceSortDataDiv").html('');
                $("#jobExperienceSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobExperienceOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.experience.sort.update') }}", {jobExperienceOrder: jobExperienceOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
