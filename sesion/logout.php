<?php
session_start();
session_destroy();
header('Location: /index.html');
/* Este archivo debe manejar la lógica de cerrar una sesión */
?>