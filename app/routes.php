<?php

Route::any('admin', array('as' => 'admin', 'uses' => 'AdminController@admin'));
Route::any('admin/login', array('as' => 'admin.login', 'uses' => 'AdminController@login'));
Route::post('admin/logout', array('as' => 'admin.logout', 'uses' => 'AdminController@logout'));
Route::any('admin/dashboard', array('as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard'));
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));
