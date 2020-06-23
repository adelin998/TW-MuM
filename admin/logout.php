
<?php
session_start();
unset($_SESSION['adminLog']);
   session_unset();
   if(session_destroy()) {
      header("Location: index.php");
   }
?>