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
        1 => 'Ene',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Abr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Ago',
        9 => 'Sep',
        10 => 'Oct',
    ];
}
