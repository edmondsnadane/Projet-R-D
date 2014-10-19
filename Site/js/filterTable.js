$(document).ready(function () {

    (function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));

});

onchange=function(ancre) {
 var form = document.forms['form_pro'];
 form.action = form.action +'#' + ancre;
 return form.submit();
}