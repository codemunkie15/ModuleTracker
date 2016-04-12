$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function calculateClass() {
    $('.class-box').empty();
    $('.errors-box').empty();
    var form = $('#year_marks_form'),
        serialized = form.serialize(),
        form_url = form.attr( "action" );
    var post = $.post(form_url, {
        data: serialized
    });
    post.done(function( data ) {
        if(data.success) {
            // Check all the percentages added up to 100
            // Laravel validation custom rules with form arrays wasn't working so i'm doing it with js
            // Add up the "year percentage" percentages
            var percent = 0;
            form.find('.input-percentage').each(function() {
                percent += parseInt($(this).val());
            });
            if(percent == 100) {
                // Show the classification and mark on the screen
                // Get the class box
                var class_box = $('.class-box');
                class_box.append('<div class="text">Your total degree mark is ' + data.mark + '% ' + data.class + '</div>');
            } else {
                // Get the error box
                var error_box = $('.errors-box');
                error_box.append('<div class="alert alert-danger">');
                error_box.find('.alert-danger').append('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Your year percentages need to add up to 100%.');
            }
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