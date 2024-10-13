<?php

namespace App\Http\Controllers;

class Constants
{
    public const DIAS = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

    public const MESES_EN = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    public const MESES_ES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    public const FAMILIARES = [ 'ABUELA','ABUELO','AMIGO','CUÑADA','CUÑADO','ESPOSA','ESPOSO','HERMANA','HERMANO','HIJA','HIJO','MADRE','NINGUNO','PADRE','PRIMA','PRIMO','SUEGRA','SUEGRO','TIA','TIO','OTROS'];

    // Meses de enero (1) a octubre (10)
    public const MONTHS = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
    ];
}
