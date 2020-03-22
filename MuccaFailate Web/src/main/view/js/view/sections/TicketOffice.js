$(document).ready(function () {
    SystemWeb.initializeSectionJs("ticket-office", function () {
        $('#generate-tickets-btn').click(showGenerateTicket);
        $('#validate-tickets-btn').click(showValidateTicket);
        $('#scan-ticket-btn').click(function () {
            $('#input-file').trigger('click');
        });
        $('#goBack1').click(goBack);
        $('#goBack2').click(goBack);
        $('#input-file').change(function (e) {
            readFile(e.target.files[0]);
        });
        $('#ticket-img').load(function () {
            showLoading();

            QCodeDecoder().decodeFromImage(
                this,
                function (er, res) {
                    if (er) {
                        alert('No hemos podido detectar el código QR. Por favor mejora la foto.');
                        hideLoading();
                    }
                    else {
                        validateTicket(res);
                    }
                });
        });

        // Generate login form send
        ManagerForm.add($("#ticketOfficeLoginForm"), function () {
            window.location.reload();
        }, function () {
            alert("El usuario no es válido!");
        });

        // Generate ticket form send
        ManagerForm.add($("#generateTicketForm"), function () {
        }, function (response) {
            var r = response.target.response;
            if (r.substr(0, 5) !== 'ERROR') {
                alert('La entrada se ha generado correctamente!');
                UtilsHttp.goToUrl(r.replace(/&amp;/g, '&'), true);
                hideLoading();
                UtilsHttp.refresh();
            } else {
                alert("Ha ocurrido un error generando la entrada");
                hideLoading();
            }
        }, function () {
            showLoading();
        });
    });
});


function showLoading() {
    $("#loading-backdrop").show();
}


function hideLoading() {
    $("#loading-backdrop").hide();
}


function showGenerateTicket() {
    $("#generate-tickets").show();
    $("#validate-tickets").hide();
    $("#initial-options").hide();
    $('#validate-tickets-result').hide();
}


function showValidateTicket() {
    $("#generate-tickets").hide();
    $("#validate-tickets").show();
    $("#initial-options").hide();
    $('#validate-tickets-result').hide();
}


function goBack() {
    UtilsHttp.refresh();
    $('html').hide();
    modifyBackgroundColor('#387fc2');
}

function readFile(file) {
    var img = $('#ticket-img')[0];
    var reader = new FileReader();

    reader.addEventListener(
        "load",
        function () {
            hideLoading();
            img.src = reader.result;
        }, false);

    if (file) {
        showLoading();
        reader.readAsDataURL(file);
    }
}


function showValidateTicketResult(resultTicket) {
    var ticket = UtilsConversion.jsonToObject(resultTicket);
    $('#validate-tickets-form').hide();
    var trc = $('#validate-tickets-result');
    trc.show();
    trc.html('<p>DETALLE ENTRADA:</p><br>' +
        '<p><b>Nombre completo:</b><span>' + ticket.fullName + '</span></p>' +
        '<p><b>Correo:</b><span>' + ticket.email + '</span></p>' +
        '<p><b>DNI:</b><span>' + ticket.dni + '</span></p>' +
        '<p><b>Código:</b><span>' + ticket.code + '</span></p>'
    );
}


function validateTicket(code) {
    $.ajax({
            url: VALIDATE_TICKET_URL,
            method: 'POST',
            data: {
                code: code
            },
            error: function () {
                modifyBackgroundColor('red');
                alert('Ha ocurrido un problema con el servidor al validar la entrada.');
            },
            success: function (result) {
                var r = result.split(';');

                if (r[0] === 'ERROR_NOT_FOUND') {
                    modifyBackgroundColor('#920f0f');
                    alert('ERROR! No hemos encontrado la entrada con este código: ' + code);
                } else if (r[0] === 'ERROR_ALREADY_VALIDATED') {
                    modifyBackgroundColor('#920f0f');
                    alert('ERROR! Esta entrada ya estaba validada!');
                    showValidateTicketResult(r[1]);
                } else if (r[0] === 'ERROR_SET_AS_VALIDATED') {
                    alert('Ha ocurrido un problema con el servidor al actualizar la entrada.');
                } else if (r[0] === 'SUCCESS') {
                    alert('Entrada validada!');
                    modifyBackgroundColor('#356b0c');
                    showValidateTicketResult(r[1]);
                }
            },
            complete: function () {
                hideLoading();
            }
        }
    );
}


function modifyBackgroundColor(color) {
    $('html').css({backgroundColor: color});
}
