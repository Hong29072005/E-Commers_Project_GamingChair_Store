<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

//Product
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'search']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

//Category
Route::get('/categories', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'search']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

//Brand
Route::get('/brands', [BrandController::class, 'show']);
Route::post('/brands', [BrandController::class, 'store']);
Route::get('/brands/{id}', [BrandController::class, 'search']);
Route::put('/brands/{id}', [BrandController::class, 'update']);
Route::delete('/brands/{id}', [BrandController::class, 'destroy']);

//Order
Route::get('/orders', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'search']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

//Customer
Route::get('/customer', [CustomerController::class, 'show']);
Route::post('/customer', [CustomerController::class, 'store']);
Route::get('/customer/{id}', [CustomerController::class, 'search']);
Route::put('/customer/{id}', [CustomerController::class, 'update']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);

//Coupon
Route::get('/coupon', [CouponController::class, 'show']);
Route::post('/coupon', [CouponController::class, 'store']);
Route::get('/coupon/{id}', [CouponController::class, 'search']);
Route::put('/coupon/{id}', [CouponController::class, 'update']);
Route::delete('/coupon/{id}', [CouponController::class, 'destroy']);

//ProductVariant
Route::get('/product-variant', [ProductVariantController::class, 'show']);
Route::post('/product-variant', [ProductVariantController::class, 'store']);
Route::get('/product-variant/{id}', [ProductVariantController::class, 'search']);
Route::put('/product-variant/{id}', [ProductVariantController::class, 'update']);
Route::delete('/product-variant/{id}', [ProductVariantController::class, 'destroy']);

//Address
Route::get('/address', [AddressesController::class, 'show']);
Route::post('/address', [AddressesController::class, 'store']);
Route::get('/address/{id}', [AddressesController::class, 'search']);
Route::put('/address/{id}', [AddressesController::class, 'update']);
Route::delete('/address/{id}', [AddressesController::class, 'destroy']);

//Cart
Route::get('/carts', [CartController::class, 'show']);
Route::post('/carts', [CartController::class, 'store']);
Route::get('/carts/{id}', [CartController::class, 'search']);
Route::put('/carts/{id}', [CartController::class, 'update']);
Route::delete('/carts/{id}', [CartController::class, 'destroy']);

//CartItem
Route::get('/cart_items', [CartItemController::class, 'show']);
Route::post('/cart_items', [CartItemController::class, 'store']);
Route::get('/cart_items/{id}', [CartItemController::class, 'search']);
Route::put('/cart_items/{id}', [CartItemController::class, 'update']);
Route::delete('/cart_items/{id}', [CartItemController::class, 'destroy']);

//Payment
Route::get('/payments', [PaymentController::class, 'show']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'search']);
Route::put('/payments/{id}', [PaymentController::class, 'update']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);

//Review
Route::get('/reviews', [ReviewController::class, 'show']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/{id}', [ReviewController::class, 'search']);
Route::put('/reviews/{id}', [ReviewController::class, 'update']);
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

//Wishlist
Route::get('/wishlist', [WishlistController::class, 'show']);
Route::post('/wishlist', [WishlistController::class, 'store']);
Route::get('/wishlist/{id}', [WishlistController::class, 'search']);
Route::put('/wishlist/{id}', [WishlistController::class, 'update']);
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

//OrderItems
Route::get('/order-items', [OrderItemController::class, 'show']);
Route::post('/order-items', [OrderItemController::class, 'store']);
Route::get('/order-items/{id}', [OrderItemController::class, 'search']);
Route::put('/order-items/{id}', [OrderItemController::class, 'update']);
Route::delete('/order-items/{id}', [OrderItemController::class, 'destroy']);

//ProductImage
Route::get('/product-images', [ProductImageController::class, 'show']);
Route::post('/product-images', [ProductImageController::class, 'store']);
Route::get('/product-images/{id}', [ProductImageController::class, 'search']);
Route::put('/product-images/{id}', [ProductImageController::class, 'update']);
Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy']);