function countdown(targetDate) {
    const target = new Date(targetDate).getTime();

    const interval = setInterval(function() {
        const now = new Date().getTime();
        const difference = target - now;

        if (difference < 0) {
            clearInterval(interval);
            document.getElementById("countdown").innerHTML = "Evento comenzado!";
            return;
        }

        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        document.getElementById("days").textContent = days < 10 ? '0' + days : days;
        document.getElementById("hours").textContent = hours < 10 ? '0' + hours : hours;
        document.getElementById("minutes").textContent = minutes < 10 ? '0' + minutes : minutes;
        document.getElementById("seconds").textContent = seconds < 10 ? '0' + seconds : seconds;
    }, 1000);
}

countdown('July 6, 2024 23:59:59'); // Reemplaza esta fecha con tu fecha objetivo


function mostrarCampos() {
    var seleccion = document.getElementById('asistencia').value;
    var camposSi = document.getElementById('camposSi');
    var camposNo = document.getElementById('camposNo');

    if (seleccion === "si") {
        camposSi.style.display = 'block';
        camposNo.style.display = 'none';
    } else if (seleccion === "no") {
        camposSi.style.display = 'none';
        camposNo.style.display = 'block';
    }else{
        camposSi.style.display = 'none';
        camposNo.style.display = 'none';
    }
}

function mostrarCampos2() {
    var elem = document.getElementById('form-acompanante');
    elem.style.display = elem.style.display === 'none' ? 'block' : 'none';
}


function esDispositivoMovil() {
    return window.innerWidth <= 800;
}

window.onload = function() {
    var contenidoPrincipal = document.getElementById("contenidoPrincipal");
    var qrcodeContainer = document.getElementById("qrcode");
    var qr = document.getElementById("qr");

    if (!esDispositivoMovil()) {
        // Ocultar el contenido principal
        contenidoPrincipal.style.display = "none";        
        // Mostrar y generar el código QR
        var qrcode = new QRCode(qrcodeContainer, {
            text: window.location.href,
            width: 256,
            height: 256,
        });

        //qrcodeContainer.innerHTML = "Para ver la invitación, por favor lee este código QR";
        qrcodeContainer.style.display = "block";
        qr.style.display = "block";
    }
};


$(document).ready(function() {
    $('#formularioInvitacion').on('submit', function(e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional
        $.ajax({
            type: 'POST',
            url: 'guardar.php', // La URL de tu script PHP
            data: $(this).serialize(),
            success: function(response) {
                $('#mensajeResultado').html(response);
                $('#mensajeResultado').show();
                $('#formularioInvitacion').hide();
            },
            error: function() {
                $('#mensajeResultado').html('Ocurrió un error al enviar el formulario.');
                $('#mensajeResultado').show();
            }
        });
    });
});