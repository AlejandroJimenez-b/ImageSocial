<?php
namespace App\Helpers;
// use Illuminate\Support\Facades\DB;

class FormatTime
{
    public static function longTimeFilter($date)
    {
        if ($date === null) {
            return "Sin fecha";
        }

        $diff = $date->diff(new \DateTime());

        $units = [
            'y' => ['año', 'años'],
            'm' => ['mes', 'meses'],
            'd' => ['día', 'días'],
            'h' => ['hora', 'horas'],
            'i' => ['minuto', 'minutos'],
            's' => ['segundo', 'segundos'],
        ];

        foreach ($units as $key => [$singular, $plural]) {
            $value = $diff->$key;

            if ($value > 0) { // Solo si value es mayor que 0:
                $text = $value === 1 ? $singular : $plural; // value es igual a 1? singular, si es mayor a 1 plural
                return "Hace {$value} {$text}";
            }
        }

        return "Hace 0 segundos";
    }
}
?>