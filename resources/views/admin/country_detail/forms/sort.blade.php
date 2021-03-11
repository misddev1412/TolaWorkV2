{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Country Details</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshCountryDetailSortData();')) !!}
    <div id="countryDetailSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshCountryDetailSortData();
    });
    function refreshCountryDetailSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('country.detail.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#countryDetailSortDataDiv").html('');
                $("#countryDetailSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var countryDetailOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('country.detail.sort.update') }}", {countryDetailOrder: countryDetailOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
