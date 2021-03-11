        function load_blog_category_add_form (){
	$('#addModal').modal('show');
        }
        
        function load_content_edit_form(id){
	$.getJSON(APP_URL+'/admin/blog_category/get_blog_category_by_id/'+id, function(data) {
            $('#id').val(data.id);
            $('#title_update').val(data.heading);
            $('#slug_update').val(data.slug);
             $('#editModal').modal('show');
        });	
        }
        function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

    return str;
}
function string_to_slug(titleId, slugId) {

    var str = $("#" + titleId).val();

    var eventSlug = $("#" + slugId).val();

    if (eventSlug.length == "") {

        str = str.replace(/^\s+|\s+$/g, ''); // trim

        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc

        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";

        var to = "aaaaeeeeiiiioooouuuunc------";

        for (var i = 0, l = from.length; i < l; i++) {

            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));

        }



        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars

                .replace(/\s+/g, '-') // collapse whitespace and replace by -

                .replace(/-+/g, '-'); // collapse dashes

        //return str;

        $("#" + slugId).val(str);

    }

}




$(document).ready(function (e) {
    $("#title").change(function () {
        string_to_slug('title', 'slug');
    });
});
        
        
        
        function delete_blog_category(id){
            var is_confirm = confirm("Are you sure you want to delete this Category?");
	    if(is_confirm){
            $.ajax({
                type: 'DELETE',
                url: 'blog_category/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    toastr.success('Successfully deleted Category!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data['id']).remove();
                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            });
        }
    }
              
                  
                  
                  


        
        
        
       



       
