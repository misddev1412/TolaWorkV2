{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Drag and Drop to Sort the Questions</h3>
    {!! Form::select('lang', ['' => 'Select Language']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refresh_faq_sort_data();')) !!}	
    <div id="faq_sort_data_div">
    </div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refresh_faq_sort_data();
    });
    function refresh_faq_sort_data() {
        var language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('faq.sort.data') }}",
            data: {lang: language},
            success: function (responseData) {
                $("#faq_sort_data_div").html('');
                $("#faq_sort_data_div").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var faqOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('faq.sort.update') }}", {faqOrder: faqOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endpush
