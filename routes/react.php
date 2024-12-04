<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// require __DIR__ . '/router.php';

// Route::get('/catalogo/{id?}', [IndexController::class, 'catalogo'])->name('Catalogo.jsx');
// Route::get('/ofertas/{id?}', [IndexController::class, 'ofertas'])->name('Ofertas.jsx');

Route::middleware(['auth:sanctum', 'verified', 'can:Admin'])->group(function () {
  Route::prefix('admin')->group(function () {
    Route::get('/offers', [OfferController::class, 'reactView'])->name('Admin/Offers.jsx');
    Route::get('/products2', [ProductsController::class, 'reactView'])->name('Admin/Products.jsx');
  });
});
// foreach (Router::components as $path => $page) {
//   if (Auth::check()) {
//     Auth::user()->getAllPermissions();
//   }
//   if (isset($page['adminto-instance']) && $page['adminto-instance']) {
//     Route::get('/' . $path, function (Request $request) use ($page) {
//       $properties = [
//         'token' => csrf_token(),
//         'session' => Auth::user(),
//         'WA_URL' => env('WA_URL'),
//         'APP_URL' => env('APP_URL')
//       ];
//       if (isset($page['compact'])) {
//         foreach ($page['compact'] as $key => $compact) {
//           if (isset($compact['select'])) {
//             $query = $compact['class']::select($compact['select']);
//           } else {
//             $query = $compact['class']::select();
//           }
//           if (isset($compact['filter'])) {
//             $query = $query->where($compact['filter']);
//           }
//           $properties[$key] = $query->get();
//         }
//       }
//       return Inertia::render($page['component'], $properties)->rootView('app');
//     })->name($path);
//   }
// }
