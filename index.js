$(document).ajaxSuccess(function (event, xhr, settings) {
    console.log(settings.url);
    if (settings.url == "https://www.spinepilates.co.il/formsWriter.asmx") {
        const mail = document.querySelector('[data-ph="מייל:"]').value;
        const phone = document.querySelector('[data-ph="טלפון:"]').value;
        const name = document.querySelector('[data-ph="שם מלא:"]').value;
        const message = document.querySelector('[data-ph="הודעה:"]').value;
        if(name&&phone&&mail)
        $.ajax({
            type: "POST",
            url: "http://api.arboxapp.com/index.php/api/v2/leads",
            headers: {
                "apiKey":"8a6b889a-c64e-4c72-bdb7-5d450929c3a2"
            },
            data: {
                first_name: name.split(' ')[0],
                last_name: name.split(' ')[1],
                email: mail,
                phone:phone,
                comment:message,
                location_box_fk:371,
                source_fk:1592
            }
        });
    }
});


