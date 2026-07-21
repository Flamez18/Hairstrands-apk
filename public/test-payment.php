<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;

try {
    $controller = new PaymentController();
    $request = Request::create('/payment/process/6', 'POST', [
        '_token' => csrf_token()
    ]);
    
    $response = $controller->simulateProcess(6, $request);
    
    echo "Simulate payment response: " . $response->getContent();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
