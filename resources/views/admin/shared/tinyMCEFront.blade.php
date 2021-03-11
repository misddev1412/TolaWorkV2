<script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: '#description',
    height: 150,
    forced_root_block: '',
    plugins: [
        'advlist autolink lists',
        'searchreplace visualblocks code fullscreen',
        'table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
});
</script>