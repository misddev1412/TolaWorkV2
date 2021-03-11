{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Career Levels</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshCareerLevelSortData();')) !!}
    <div id="careerLevelSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshCareerLevelSortData();
    });
    function refreshCareerLevelSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('career.level.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#careerLevelSortDataDiv").html('');
                $("#careerLevelSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var careerLevelOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('career.level.sort.update') }}", {careerLevelOrder: careerLevelOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
