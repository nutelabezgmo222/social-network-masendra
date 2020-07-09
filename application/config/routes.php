<?php

return [
  //GuestController
  'diploma/register' => [
    'controller' => 'guest',
    'action' => 'register',
  ],
  'diploma/register(\?act=finish)' => [
    'controller' => 'guest',
    'action' => 'registerFinish',
  ],
  'diploma/login' => [
    'controller' => 'guest',
    'action' => 'login',
  ],
  //UserController
  'diploma' => [
    'controller' => 'user',
    'action' => 'index',
  ],
  'diploma(\?sec={sec:saved})' => [
    'controller' => 'user',
    'action' => 'index',
  ],
  'diploma/id/{id:\d+}(\?photo={photo:\w+})?' => [
    'controller' => 'user',
    'action' => 'index',
  ],
  'diploma/id/{id:\d+}(\?sec={sec:saved})' => [
    'controller' => 'user',
    'action' => 'index',
  ],
  'diploma/out' => [
    'controller' => 'user',
    'action' => 'out',
  ],
  'diploma/feed' => [
    'controller' => 'user',
    'action' => 'feed',
  ],
  'diploma/friends' => [
    'controller' => 'user',
    'action' => 'friends',
  ],
  'diploma/friends(\?sec={sec:all})(\&usr={usr:\d+})?' => [
    'controller' => 'user',
    'action' => 'friends',
  ],
  'diploma/friends(\?sec={sec:online})(\&usr={usr:\d+})?' => [
    'controller' => 'user',
    'action' => 'friends',
  ],
  'diploma/friends(\?sec={sec:all_request})(\&usr={usr:\d+})?' => [
    'controller' => 'user',
    'action' => 'friendsRequest',
  ],
  'diploma/friends(\?sec={sec:out_request})(\&usr={usr:\d+})?' => [
    'controller' => 'user',
    'action' => 'friendsRequest',
  ],
  'diploma/friends(\?act={act:find})' => [
    'controller' => 'user',
    'action' => 'friendsSearch',
  ],
  'diploma/messages' => [
    'controller' => 'user',
    'action' => 'messages',
  ],
  'diploma/messages(\?sec={sec:unread})' => [
    'controller' => 'user',
    'action' => 'messages',
  ],
  'diploma/messages(\?usr={usr:\d+})' => [
    'controller' => 'user',
    'action' => 'chat',
  ],
  'diploma/albums' => [
    'controller' => 'user',
    'action' => 'albums',
  ],
  'diploma/albums(\?photo={photo:\w+})?' => [
    'controller' => 'user',
    'action' => 'albums',
  ],
  'diploma/albums(/?usr={usr:\d+})' => [
    'controller' => 'user',
    'action' => 'albums',
  ],
  'diploma/settings' => [
    'controller' => 'user',
    'action' => 'settings',
  ],
  'diploma/settings(\?act=additional)' => [
    'controller' => 'user',
    'action' => 'settingsAdditional',
  ],
  'diploma/settings(\?act=contact)' => [
    'controller' => 'user',
    'action' => 'settingsContact',
  ],
  'diploma/settings(\?act=confidentiality)' => [
    'controller' => 'user',
    'action' => 'confidentiality',
  ],
];
