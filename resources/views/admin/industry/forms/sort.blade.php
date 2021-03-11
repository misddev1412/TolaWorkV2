{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Industries</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshIndustrySortData();')) !!}
    <div id="industrySortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshIndustrySortData();
    });
    function refreshIndustrySortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('industry.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#industrySortDataDiv").html('');
                $("#industrySortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var industryOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('industry.sort.update') }}", {industryOrder: industryOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
