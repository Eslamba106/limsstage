<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LanguageController;



Route::group(["prefix" => "ui-settings"], function () {

    Route::get("/{position?}", [SettingController::class, "ui_settings"])->name("admin.settings.ui_settings.index");
    Route::post("/update_word", [SettingController::class, "ui_settings"])->name("admin.settings.ui_settings.update-submit");
    Route::post('remove-key/{position?}', [SettingController::class, 'translate_key_remove'])->name('admin.settings.ui_settings.remove-key');
    Route::any('auto-translate/{position?}', [SettingController::class, 'auto_translate'])->name('admin.settings.ui_settings.auto-translate');
    Route::get('translate-list/{position?}', [SettingController::class, 'translate_list'])->name('admin.settings.ui_settings.translate.list');
    Route::post('change-submit/{position?}', [SettingController::class, 'translate_submit'])->name('admin.settings.ui_settings.translate-submit');
});

Route::group(['prefix' => 'language'], function () {
    Route::get('', [LanguageController::class, 'index'])->name('admin.business-settings.language.index');
    Route::post('add-new', [LanguageController::class, 'store'])->name('admin.business-settings.language.add-new');
    Route::get('update-status', [LanguageController::class, 'update_status'])->name('admin.business-settings.language.update-status');
    Route::get('update-default-status', [LanguageController::class, 'update_default_status'])->name('admin.business-settings.language.update-default-status');
    Route::post('update', [LanguageController::class, 'update'])->name('admin.business-settings.language.update');
    Route::get('translate/{lang}', [LanguageController::class, 'translate'])->name('admin.business-settings.language.translate');
    Route::get('translate-list/{lang}', [LanguageController::class, 'translate_list'])->name('admin.business-settings.language.translate.list');
    Route::post('translate-submit/{lang}', [LanguageController::class, 'translate_submit'])->name('admin.business-settings.language.translate-submit');
    Route::post('remove-key/{lang}', [LanguageController::class, 'translate_key_remove'])->name('admin.business-settings.language.remove-key');
    Route::get('delete/{lang}', [LanguageController::class, 'delete'])->name('admin.business-settings.language.delete');
    Route::any('auto-translate/{lang}', [LanguageController::class, 'auto_translate'])->name('admin.business-settings.language.auto-translate');
});
    Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
        Route::get('', [LanguageController::class, 'index'])->name('index');
        Route::post('add-new', [LanguageController::class, 'store'])->name('add-new');
        Route::get('update-status', [LanguageController::class, 'update_status'])->name('update-status');
        Route::get('update-default-status', [LanguageController::class, 'update_default_status'])->name('update-default-status');
        Route::post('update', [LanguageController::class, 'update'])->name('update');
        Route::get('translate/{lang}', [LanguageController::class, 'translate'])->name('translate');
        Route::get('translate-list/{lang}', [LanguageController::class, 'translate_list'])->name('translate.list');
        Route::post('translate-submit/{lang}', [LanguageController::class, 'translate_submit'])->name('translate-submit');
        Route::post('remove-key/{lang}', [LanguageController::class, 'translate_key_remove'])->name('remove-key');
        Route::get('delete/{lang}', [LanguageController::class, 'delete'])->name('delete');
        Route::any('auto-translate/{lang}', [LanguageController::class, 'auto_translate'])->name('auto-translate');
    });