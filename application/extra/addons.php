<?php

return array (
  'autoload' => false,
  'hooks' => 
  array (
    'app_init' => 
    array (
      0 => 'cms',
      1 => 'upyun',
    ),
    'response_send' => 
    array (
      0 => 'cms',
    ),
    'user_sidenav_after' => 
    array (
      0 => 'cms',
    ),
    'upload_config_init' => 
    array (
      0 => 'upyun',
    ),
    'upload_delete' => 
    array (
      0 => 'upyun',
    ),
  ),
  'route' => 
  array (
    'cms/$' => 'cms/index/index',
    'cms/a/[:diyname]' => 'cms/archives/index',
    'cms/t/[:name]' => 'cms/tags/index',
    'cms/p/[:diyname]' => 'cms/page/index',
    'cms/s' => 'cms/search/index',
    'cms/c/[:diyname]' => 'cms/channel/index',
    'cms/d/[:diyname]' => 'cms/diyform/index',
    'cms/special/[:diyname]' => 'cms/special/index',
    'cms/u/[:id]' => 'cms/user/index',
    '/example$' => 'example/index/index',
    '/example/d/[:name]' => 'example/demo/index',
    '/example/d1/[:name]' => 'example/demo/demo1',
    '/example/d2/[:name]' => 'example/demo/demo2',
  ),
);