

$(function () {

    $(document).ready(function () {

        // ajax contact form
        $('.contact-form form').submit(function (e) {
            e.preventDefault();

            $theForm = $(this);
            $btn = $(this).find('#submit-button');
            $alert = $(this).parent().find('.alert');

            $btn.addClass('loading');
            $btn.attr('disabled', 'disabled');

            $.post('contact.asp', $("#contact").serialize(), function (data) {
                $message = data.message;
                alert(data);
                if (data.result == true) {
                    $theForm.slideUp('medium', function () {
                        $alert.removeClass('alert-danger');
                        $alert.addClass('alert-success').html($message).slideDown('medium');
                    });
                } else {
                    $alert.addClass('alert-danger').html($message).slideDown('medium');
                }

                $btn.removeClass('loading');
                $btn.removeAttr('disabled');

            })
			.fail(function () { console.log('AJAX Error'); });

        });

    });

})(jQuery);