<?php

use Carbon\Carbon;

if (!function_exists('jobDeadLineCheck')) {
    function jobDeadLineCheck($date)
    {
        if (Carbon::parse($date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
            return true;
        }
        return false;
    }
}


if (!function_exists('formatExperience')) {
    function formatExperience($experience)
    {
        $experience = trim($experience);
        if (stripos($experience, 'year') !== false) {
            return $experience;
        }
        $years = (int) $experience;
        if ($years === 1) {
            return $experience . ' Year';
        } else {
            return $experience . ' Years';
        }
    }
}
