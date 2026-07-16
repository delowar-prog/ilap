<?php
$adminShow = file_get_contents('C:\laragon\www\iLap\resources\views\backend\admin\students\show.blade.php');
preg_match('/@push\(\'css\'\)(.*?)@endpush/s', $adminShow, $cssMatch);
preg_match('/<div class="profile-card">(.*?)<\/div>\s*<\/div>\s*<\/div>/s', $adminShow, $cardMatch);

$css = $cssMatch[0];
$cardContent = '<div class="profile-card">' . $cardMatch[1] . '</div>';

$preAssess = file_get_contents('C:\laragon\www\iLap\resources\views\backend\pre_assessment\show.blade.php');
$preAssess = str_replace("@section('admin_contents')", $css . "\n@section('admin_contents')", $preAssess);

// We need to replace the col-md-8 content.
$preAssess = preg_replace('/<div class="col-md-8">\s*<div class="card">.*?<\/div>\s*<\/div>\s*<\/div>\s*<div class="col-md-4">/s', '<div class="col-md-8">' . "\n" . $cardContent . "\n" . '</div>' . "\n" . '<div class="col-md-4">', $preAssess);

file_put_contents('C:\laragon\www\iLap\resources\views\backend\pre_assessment\show.blade.php', $preAssess);
