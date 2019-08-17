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
    '/$' => 'cms/index/index',
    '/a/[:diyname]' => 'cms/archives/index',
    '/t/[:name]' => 'cms/tags/index',
    '/p/[:diyname]' => 'cms/page/index',
    '/s' => 'cms/search/index',
    '/c/[:diyname]' => 'cms/channel/index',
    '/d/[:diyname]' => 'cms/diyform/index',
    '/special/[:diyname]' => 'cms/special/index',
    '/u/[:id]' => 'cms/user/index',
  ),
);