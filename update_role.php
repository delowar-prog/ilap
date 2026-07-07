<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;

$role = Role::firstOrCreate(['name' => 'Student']);
$role->syncPermissions(['campus view', 'institute view']);

echo 'Student role permissions updated successfully.';
