{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Countries</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshCountrySortData();')) !!}
    <div id="countrySortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshCountrySortData();
    });
    function refreshCountrySortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('country.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#countrySortDataDiv").html('');
                $("#countrySortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var countryOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('country.sort.update') }}", {countryOrder: countryOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
