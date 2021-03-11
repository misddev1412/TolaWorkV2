{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Languages</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshLanguageSortData();')) !!}
    <div id="languageSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshLanguageSortData();
    });
    function refreshLanguageSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('language.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#languageSortDataDiv").html('');
                $("#languageSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var languageOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('language.sort.update') }}", {languageOrder: languageOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush