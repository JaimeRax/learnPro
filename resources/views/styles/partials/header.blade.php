<style>
    /* Estilos generales */
    body {
        font-family: 'Montserrat', sans-serif; /* Aplicar la fuente Montserrat al cuerpo del documento */
    }

    .header {
        line-height: 0.3;
    }

    .contact-info {
        float: right;
        text-align: right;
        font-size: 0.5rem;
        line-height: 0.5;
        margin: 0;
        padding: 0;
    }

    .logo {
        width: 90px;
        display: inline-block;
        vertical-align: middle;
        margin-top: -15px;
    }

    .text-container {
        display: inline-block;
        vertical-align: middle;
        font-size: 1rem;
        line-height: 0.7;
        margin: 0;
        padding: 0;
    }

    .text-container .title {
        display: inline-block;
        vertical-align: middle;
        font-size: 0.5rem;
        line-height: 1.1;
        margin: 0;
        padding: 0;
    }

    /* Estilos del pie de página */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 0.6rem;
        color: #333333;
        padding: 5px 0;
        border-top: 1px solid #ddd;
        background-color: #f9f9f9;
    }

    .lato-regular {
        font-family: 'Montserrat', sans-serif; /* Aplicar Montserrat a texto específico */
        font-weight: 400; /* Peso regular */
    }

    .lato-bold {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; /* Aplicar peso bold */
    }
</style>

<!-- Contenido del componente -->
<div class="header">
    <div class="contact-info lato-regular">
        <img class="logo" src="{{ public_path('Imagenes/jv-logo.png') }}" alt="jv-logo" />
    </div>
    <div class="text-container">
        <p class="lato-bold">INSTITUTO DE EDUCACION BASICA</p>
        <p class="lato-bold">POR EL SISTEMA DE COOPERATIVA DE ENSEÑANZA</p>
    </div>
</div>

<div class="footer">
    <p>4ta. Ave 0-37 zona 4, Finca Municipal Sesbiché San Juan Chamelco Alta Verapaz</p>
    <p>institutobasicojv.chamelco@gmail.com</p>
    <p>Tel. (+502) 5991 0548</p>
</div>

<!-- Asegúrate de incluir este enlace en tu archivo HTML para la fuente Montserrat -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
