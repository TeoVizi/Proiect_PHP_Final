<?php

setcookie("loggedInUser", "", time() - 3600, "/");

setcookie("loggedInAdminUser", "", time() - 3600, "/");

header("Location: index.php");
exit();
