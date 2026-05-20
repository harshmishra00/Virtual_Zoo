<?php

namespace App\Helpers;

class ZooHelper
{
    public static function badgeColor(string $status): string
    {
        return match ($status) {
            'Least Concern'         => 'bg-green-100 text-green-800 border-green-300',
            'Near Threatened'       => 'bg-lime-100 text-lime-800 border-lime-300',
            'Vulnerable'            => 'bg-yellow-100 text-yellow-800 border-yellow-300',
            'Endangered'            => 'bg-orange-100 text-orange-800 border-orange-300',
            'Critically Endangered' => 'bg-red-100 text-red-800 border-red-300',
            'Extinct in Wild'       => 'bg-purple-100 text-purple-800 border-purple-300',
            default                 => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    public static function badgeDotColor(string $status): string
    {
        return match ($status) {
            'Least Concern'         => 'bg-green-500',
            'Near Threatened'       => 'bg-lime-500',
            'Vulnerable'            => 'bg-yellow-500',
            'Endangered'            => 'bg-orange-500',
            'Critically Endangered' => 'bg-red-500',
            'Extinct in Wild'       => 'bg-purple-500',
            default                 => 'bg-gray-500',
        };
    }
}

if (!function_exists('conservation_badge_color')) {
    function conservation_badge_color(string $status): string
    {
        return ZooHelper::badgeColor($status);
    }
}
