<?php
session_start();
session_unset(); // Unset session variables
session_destroy(); // Destroy session

header("Location: index.php"); // Redirect to home page
exit();