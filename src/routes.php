<?php

App::make('agwood::helpers.classparse')->callback(function($class,$method,$uri,$class_method){
  Route::get('/'.$uri,$class_method);
});
