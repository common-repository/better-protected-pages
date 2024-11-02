<?php 

   include ('../../../wp-config.php');
   //print_r($_REQUEST);

   //check for a real clear
   $mynonce = $_POST['mynonce'];
   if (! wp_verify_nonce($mynonce, 'better-protected-pages') ) die('Security check');
      
   $remove_cookie = $_POST['removecookie'];
   if ($remove_cookie == "Y") {
     unset ($_POST['removecookie']);

     //scribble over the password
     setcookie('wp-postpass_' . COOKIEHASH, '', time() + 864000, COOKIEPATH);
 
     // all looks ok
     $redirect = $_POST['redirect'];
     if ($redirect)
       wp_redirect ($redirect);   
     else
       die('Password was NOT cleared'); // should not get here;
   } 

 ?>