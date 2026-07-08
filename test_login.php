<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Login as User 1
Auth::loginUsingId(1);

$request = Illuminate\Http\Request::create('/login', 'GET');
$response = $kernel->handle($request);
echo "STATUS CODE: " . $response->getStatusCode() . "\n";
if ($response->isRedirection()) {
    echo "REDIRECT TO: " . $response->getTargetUrl() . "\n";
}
