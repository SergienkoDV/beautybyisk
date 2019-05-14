$(document).ready (function() {
    $('.ams').click(function () {
        var $formid = $(this).attr('id');
        $('.qery-form').hide();
        $('#' + $formid + '>.qery-form').show();
        $(".send").click(function () {
            var $sendid = $(this).attr('id');
            var $text = $(".message_form_text").val();
            if ($text.length < 1) {
                $('p.center').html('Поле не заполнено!');
                $('p.center').css("color", "red");
            } else {
                $('.qery-form').hide();
                $.ajax({
                    type: "POST",
                    url: 'http://localhost/beautybyisk/public/message/' + $sendid,
                    dataType: 'json',
                    data: {text: $text},
                    success: console.log($text)
                })
            }

        })
    });
    $(".delete").click(function () {
        var $id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: 'http://localhost/beautybyisk/public/deletemessagesend/' + $id,
            dataType: 'json',
            data: {id: $id},
            success: $('#' + $id).hide()
        });
    });
});