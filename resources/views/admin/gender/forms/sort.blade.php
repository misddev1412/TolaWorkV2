{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort Genders</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshGenderSortData();')) !!}
    <div id="genderSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshGenderSortData();
    });
    function refreshGenderSortData() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('gender.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#genderSortDataDiv").html('');
                $("#genderSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var genderOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('gender.sort.update') }}", {genderOrder: genderOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush
