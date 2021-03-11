{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Marital Statuses</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshMaritalStatusSortData();')) !!}
    <div id="maritalStatusSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshMaritalStatusSortData();
    });
    function refreshMaritalStatusSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('marital.status.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#maritalStatusSortDataDiv").html('');
                $("#maritalStatusSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var maritalStatusOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('marital.status.sort.update') }}", {maritalStatusOrder: maritalStatusOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush