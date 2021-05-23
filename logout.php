<?php
    session_start();
    session_destroy();
    if($_SESSION['faculty_id']){
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);
        header("Location: index.php");
    }

    if($_SESSION['prn_no']){
      session_start();
      session_unset();
      session_destroy();
      session_write_close();
      setcookie(session_name(),'',0,'/');
      session_regenerate_id(true);
      header("Location: index.php");
    }

?>