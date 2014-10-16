<?php
namespace Agwood\Larassg\Helpers;

use ReflectionClass;
use ReflectionMethod;

class ClassParse {

  protected $String;
  protected $FileSystem;
  protected $ignored_classes = array();
  protected $method_patterns = array();
  protected $parsed_classes = array();

  public function __construct(String $String, FileSystem $FileSystem){

    $this->String = $String;
    $this->FileSystem = $FileSystem;

  }

  public function ignoreClassWithName($class_name){
    $this->ignored_classes[] = $class_name;
  }

  public function addMethodSearchRegex($pattern){
    $this->method_patterns[] = $pattern;
  }

  public function parse($directories_to_parse){

    $this->parsed_classes = array();

    if(!is_array($directories_to_parse)){
      $directories_to_parse = array($directories_to_parse);
    }

    foreach($directories_to_parse as $filepath){

      $filepath = base_path($filepath);
      $files_to_parse = $this->FileSystem->recursiveDirectorySearch($filepath,'/.*.php/');

      foreach($files_to_parse as $file_to_parse) {

        $class_name = $this->String->basename($file_to_parse);

        if(in_array($class_name,$this->ignored_classes)){
          continue;
        }

        if (!class_exists($class_name)) {

          continue;

        }

        $ReflectionClass = new ReflectionClass($class_name);
        $methods = $ReflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {

          foreach($this->method_patterns as $method_name_pattern) {
            if (preg_match($method_name_pattern, $method->name)) {

              $method_name = $method->name;
              $uri = $this->String->slug(preg_replace($method_name_pattern,'',$method_name));

              $this->parsed_classes[] = array(
                  'class_name' => $class_name,
                  'method_name' => $method_name,
                  'uri' => $uri,
                  'class_method_name' => $class_name.'@'.$method_name
              );

            }
          }

        }

      }

    }

  }

  public function callback($callback){

    foreach($this->parsed_classes as $parsed_class){
      call_user_func_array($callback,array(
          $parsed_class['class_name'],
          $parsed_class['method_name'],
          $parsed_class['uri'],
          $parsed_class['class_method_name']
      ));
    }

  }

}
