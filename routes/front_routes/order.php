<?php

/* * ******** OrderController ************ */
Route::get('order-free-package/{id}', 'OrderController@orderFreePackage')->name('order.free.package');

Route::get('order-package/{id}', 'OrderController@orderPackage')->name('order.package');
Route::get('order-upgrade-package/{id}', 'OrderController@orderUpgradePackage')->name('order.upgrade.package');
Route::get('paypal-payment-status/{id}', 'OrderController@getPaymentStatus')->name('payment.status');
Route::get('paypal-upgrade-payment-status/{id}', 'OrderController@getUpgradePaymentStatus')->name('upgrade.payment.status');
Route::get('stripe-order-form/{id}/{new_or_upgrade}', 'StripeOrderController@stripeOrderForm')->name('stripe.order.form');
Route::post('stripe-order-package', 'StripeOrderController@stripeOrderPackage')->name('stripe.order.package');
Route::post('stripe-order-upgrade-package', 'StripeOrderController@stripeOrderUpgradePackage')->name('stripe.order.upgrade.package');


Route::get('payu-order-package', 'PayuController@orderPackage')->name('payu.order.package');


Route::get('payu-order-package-status/', 'PayuController@orderPackageStatus')->name('payu.order.package.status');


