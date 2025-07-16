<?php
//get starting url
define('baseURL', $_SERVER['HTTP_HOST']);
if (baseURL === 'localhost') {
  define('cockpitURL', 'http://localhost/presence/cms');
  define('authUrl', cockpitURL.'/api/user/auth');
  define('apiUrl', cockpitURL.'/api/content/items');
  define('apiUrlSolo', cockpitURL.'/api/content/item');
}
else {
  define('cockpitURL', 'https://ingrwf12.cepegra-frontend.xyz/cockpit_james');
  define('authUrl', cockpitURL . '/api/user/auth');
  define('apiUrl', cockpitURL.'/api/content/items');
  define('apiUrlSolo', cockpitURL.'/api/content/items');
}