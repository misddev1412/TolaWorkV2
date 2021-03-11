{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Cities</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshCitySortData();')) !!}
    <div id="citySortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshCitySortData();
    });
    function refreshCitySortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('city.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#citySortDataDiv").html('');
                $("#citySortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var cityOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('city.sort.update') }}", {cityOrder: cityOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush