{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort States</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshStateSortData();')) !!}
    <div id="stateSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshStateSortData();
    });
    function refreshStateSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('state.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#stateSortDataDiv").html('');
                $("#stateSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var stateOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('state.sort.update') }}", {stateOrder: stateOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush