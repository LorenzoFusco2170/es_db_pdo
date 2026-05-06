<?php
//distrugge la sessione con session destroy, poi reindirizza alla home
session_start();
session_unset();
session_destroy();
header("Location: index.html");
exit;