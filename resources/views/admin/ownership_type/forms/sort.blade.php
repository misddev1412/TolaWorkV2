{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Ownership Types</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshOwnershipTypeSortData();')) !!}
    <div id="ownershipTypeSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshOwnershipTypeSortData();
    });
    function refreshOwnershipTypeSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('ownership.type.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#ownershipTypeSortDataDiv").html('');
                $("#ownershipTypeSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var ownershipTypeOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('ownership.type.sort.update') }}", {ownershipTypeOrder: ownershipTypeOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush