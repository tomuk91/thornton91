<?php

function site_url($script_path) {
    // add the leading '/' if not present
    if($script_path[0] != '/') {
      $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
  }

  function has_unique_username($username) {
    $user = users::find_by_username($username);
    if($user === false) {
      return true;
    } else {
      return false;
    }
  }

  function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
      $output = "<div class=\"errors\">";
      $output .= "Please fix the following errors:\n";
      $output .= "<ul>";
      foreach($errors as $error) {
        $output = $output . "<li>" . $error . "</li>";
        }
      $output .= "<ul>";
      $output .= "</div>";
    }
    return $output;
  }

  function display_session_message() {
    global $session;
    $msg = $session->message();
    if(isset($msg) && $msg != '') {
      $session->clear_session_message();
      return '<div id="message">' . htmlspecialchars($msg) . '</div>';
    }
  }
?>