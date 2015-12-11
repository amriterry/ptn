<?php

require("../includes/conf.inc.php");

unset($_SESSION['userLogin'],$_SESSION['userId']);
header("Location: ".$website);

?>