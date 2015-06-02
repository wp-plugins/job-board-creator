<?php

// In some/most situations WordPress wont allow mail to be sent without a default server email address
add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email )
{
    if(preg_match('/wordpress/', $email)) {
      //Default address
      return "noreply@example.com";
    } else {
      //Keep header
      return $email;
    }
}