<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;

// Create dummy data
$user = User::first();
if (!$user) {
    echo "No user";
    exit;
}
Auth::login($user);

$product = Product::first();
if (!$product) {
    echo "No product";
    exit;
}

$cart = Cart::firstOrCreate(['user_id' => $user->id]);
CartItem::firstOrCreate([
    'cart_id' => $cart->id,
    'product_id' => $product->id
], [
    'quantity' => 1
]);

$request = Request::create('/checkout', 'POST', [
    'shipping_address' => 'Jl. Test No. 123',
    'payment_method' => 'QRIS',
    '_token' => csrf_token()
]);

try {
    $controller = new CheckoutController();
    $response = $controller->process($request);
    
    echo "Success! Redirecting to: " . $response->getTargetUrl();
} catch (\Illuminate\Validation\ValidationException $e) {
    echo "Validation Failed: \n";
    print_r($e->errors());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
