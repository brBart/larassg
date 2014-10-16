<?php
namespace Agwood\Larassg\Helpers;

class String {

  public function slug($uri){
    return str_replace('_','-',snake_case($uri));
  }

  public function dirname($path){
    return dirname($path);
  }

  public function basename($path){
    return basename($path,'.php');
  }



}
