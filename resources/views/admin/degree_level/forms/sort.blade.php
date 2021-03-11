{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Degree Levels</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshDegreeLevelSortData();')) !!}
    <div id="degreeLevelSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshDegreeLevelSortData();
    });
    function refreshDegreeLevelSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('degree.level.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#degreeLevelSortDataDiv").html('');
                $("#degreeLevelSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var degreeLevelOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('degree.level.sort.update') }}", {degreeLevelOrder: degreeLevelOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
