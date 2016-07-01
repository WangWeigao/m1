<?php
$db_username = 'root';
$db_password = '';
$db_host = 'localhost';   
$database = '';
function redirect($url)
{
    if (strlen(session_id()) > 0) 
        {
            session_regenerate_id(true); 
            session_write_close(); 
        }
    header('Location: ' . $url);
    exit();
}
?>