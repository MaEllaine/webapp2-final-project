<?

session_start();

session_destroy();

header("Location: 1stPage.php");
exit;