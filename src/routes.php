<?php

<<<<<<< HEAD
/**
 * @codeCoverageIgnore
 */
Route::group(['middleware' => config('laravel-feature-flag.route_middleware')], function () {
=======
use Illuminate\Support\Facades\Config;

Route::group(['middleware' => Config::get('laravel-feature-flag.route_middleware')], function () {
>>>>>>> fix style work
    Route::get(
        'admin/feature_flags',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@getSettings',
            'as' => 'laravel-feature-flag.index'
        ]
    );
    Route::get(
        'admin/feature_flags/{feature}/edit',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@edit',
            'as' => 'laravel-feature-flag.edit_form'
        ]
    );
    Route::get(
        'admin/feature_flags/create',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@create',
            'as' => 'laravel-feature-flag.create_form'
        ]
    );
    Route::post(
<<<<<<< HEAD
        'admin/feature_flags/imports',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@import',
            'as' => 'laravel-feature-flag.imports'
        ]
    );
    Route::post(
=======
>>>>>>> fix style work
        'admin/feature_flags',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@store',
            'as' => 'laravel-feature-flag.store'
        ]
    );
    Route::put(
        'admin/feature_flags/{feature}',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@update',
            'as' => 'laravel-feature-flag.update'
        ]
    );
    Route::delete(
        'admin/feature_flags/{feature}',
        [
            'uses' => '\AlfredNutileInc\LaravelFeatureFlags\FeatureFlagSettingsController@destroy',
            'as' => 'laravel-feature-flag.delete'
        ]
    );
});
