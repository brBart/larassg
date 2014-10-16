<?php
return array(

  /**
   * the controller dirs to recursively search for ssg methods
   */
  'controller_paths' => array(
    'app/controllers'
  ),

  /**
   * The search pattern for finding which controller methods should be parsed into static files.
   * eg. HomeController@ssgWelcome = /ssg/ = find all methods that start with ssg and parse them.
   */
  'method_name_search_pattern' => '/ssg/',

  /**
   * the url laravel runs on in the browser. The ssg creates the static files by dynamically
   * registering routes and cURLing the html responses
   */
  'laravel_url' => 'http://localhost:8000/',

  /**
   * sometimes when building static sites a url prefix (usually an absolute url) is required. All of
   * the url/asset helper functions will use this.
   */
  'url_prefix' => 'http://localhost:8000/',

  /**
   * The location where static files should be saved to.
   */
  'build_location' => base_path('public/'),

);