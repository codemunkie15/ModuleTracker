$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function calculateClass() {
    $('.class-box').empty();
    $('.errors-box').empty();
    var $form = $('#year_marks_form'),
        data = $form.serialize(),
        url = $form.attr( "action" );
    var post = $.post(url, {
        data: data
    });
    post.done(function( data ) {
        if(data.success) {
            // Show the classification and mark on the screen
            // Get the class box
            var class_box = $('.class-box');
            class_box.append('<div class=""text">Your total degree mark is ' + data.mark + '% ' + data.class + '</div>');
        } else {
            // Get the error box
            var error_box = $('.errors-box');
            error_box.append('<div class="alert alert-danger">');
            $.each(data.errors, function( index, value ) {
                error_box.find('.alert-danger').append('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ' + value + '<br>');
            });
        }
    }); //done
}