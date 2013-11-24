<?php

Route::any('login', array('as' => 'admin.login', 'uses' => 'AdminController@login'));
Route::when('admin/*', 'admin');
Route::any('admin', array('as' => 'admin', 'before' => 'admin', 'uses' => 'AdminController@dashboard'));
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));
