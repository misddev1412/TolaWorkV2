<script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: '#industry,#faq_question,#faq_answer',
    height: 150,
    forced_root_block: '',
    language: '{{ $lang }}',
    directionality: '{{ $direction }}',
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
});
</script>