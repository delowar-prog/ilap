<?php
$adminShow = file_get_contents('C:\laragon\www\iLap\resources\views\backend\admin\students\show.blade.php');
// The card starts with <div class="profile-card"> and ends before @endsection
$start = strpos($adminShow, '<div class="profile-card">');
$end = strpos($adminShow, '@endsection');
$cardContent = substr($adminShow, $start, $end - $start);
// We need to trim trailing </div></div></div> that belong to the outer row.
// Let's just find the last </div>
$cardContent = trim($cardContent);
// Strip the last </div></div> which belong to <div class="col-12"> and <div class="row">
$cardContent = preg_replace('/<\/div>\s*<\/div>\s*$/s', '', $cardContent);

$preAssess = file_get_contents('C:\laragon\www\iLap\resources\views\backend\pre_assessment\show.blade.php');
// Replace the currently wrongly matched content with the proper one.
// We know it currently has <div class="profile-card"> ... Profile Completion ... </div>
// and then immediately <div class="col-md-4">
// Let's replace everything from <div class="profile-card"> to <div class="col-md-4">
$preAssess = preg_replace('/<div class="profile-card">.*?<div class="col-md-4">/s', $cardContent . "\n" . '</div><div class="col-md-4">', $preAssess);

file_put_contents('C:\laragon\www\iLap\resources\views\backend\pre_assessment\show.blade.php', $preAssess);
