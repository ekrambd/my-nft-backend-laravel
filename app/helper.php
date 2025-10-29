<?php
 use App\Models\Setting;

 function user()
 {
 	$user = auth()->user();
 	return $user;
 }

 function setting()
 {
 	$setting = Setting::find(1);
 	return $setting;
 }