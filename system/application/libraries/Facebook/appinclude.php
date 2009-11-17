<?php
//If user wants to uninstall application we have to pass the process to controllers
if ($facebook->fb_params['uninstall'] != 1)
{
        //Else catch the exception that gets thrown if the cookie has an invalid session_key in it
        try {
          if (!$facebook->api_client->users_isAppAdded()) {
            $facebook->redirect($facebook->get_add_url());
          }
        } catch (Exception $ex) {
          //this will clear cookies for your application and redirect them to a login prompt
          $facebook->set_user(null, null);
          $facebook->redirect(Zend_Registry::get('config')->urls->fbapp);
        }

        $facebook->require_login();
        $facebook->require_frame();
}
Zend_Registry::set('facebook', $facebook);