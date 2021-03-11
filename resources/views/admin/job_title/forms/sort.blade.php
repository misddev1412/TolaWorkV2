{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Job Titles</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobTitleSortData();')) !!}
    <div id="jobTitleSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobTitleSortData();
    });
    function refreshJobTitleSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.title.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#jobTitleSortDataDiv").html('');
                $("#jobTitleSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobTitleOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.title.sort.update') }}", {jobTitleOrder: jobTitleOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
