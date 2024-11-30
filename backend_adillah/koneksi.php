<?php
try {
    
    $db = new PDO('mysql:host=localhost;dbname=db_tekom2a', 'root', '');

    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    
    echo "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
    die(); 
}
?>