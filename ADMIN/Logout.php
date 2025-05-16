<?php

session_start();
session_unset();
session_destroy();
// ob_start();
header("location:Index.html");
// ob_end_flush(); 

exit();

?>