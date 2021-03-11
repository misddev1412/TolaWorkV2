{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Job Shifts</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobShiftSortData();')) !!}
    <div id="jobShiftSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobShiftSortData();
    });
    function refreshJobShiftSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.shift.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#jobShiftSortDataDiv").html('');
                $("#jobShiftSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobShiftOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.shift.sort.update') }}", {jobShiftOrder: jobShiftOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
