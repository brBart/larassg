<?php
namespace Agwood\Larassg\Helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class FileSystem {

  public function recursiveDirectorySearch($folder, $pattern) {

    $dir = new RecursiveDirectoryIterator($folder);
    $ite = new RecursiveIteratorIterator($dir);
    $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
    $fileList = array();

    foreach($files as $file) {
      $fileList = array_merge($fileList, $file);
    }

    return $fileList;

  }

}
