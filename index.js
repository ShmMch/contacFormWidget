document.addEventListener("DOMContentLoaded", function () {
    //Add validators
    document.querySelectorAll('input, textarea').forEach(function (element) {
        element.oninvalid = function (e) {
            e.target.parentNode.classList.add('error');
            e.preventDefault();
        };
        element.oninput = function (e) {
            e.target.parentNode.classList.remove('error')
        };
    });

    //Set submit function
    $(function () {
        $("#form").submit(function () {
            $.ajax({
                type: "POST",
                url: "https://kidumplus.top/spinepilatescoil/index.php",
                data: {
                    name: $("#name").val(),
                    phone: $("#phone").val(),
                    email: $("#email").val(),
                    message: $("#message").val()
                },
                success: function () {
                    $('#form').hide();
                   $('.success').fadeIn(1000);
                }
            });
            return false;
        });
    });
})