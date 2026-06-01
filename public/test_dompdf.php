<?php
require __DIR__ . '/../vendor/autoload.php';
if (class_exists('Dompdf\Options')) {
    echo "Class Dompdf\Options found.\n";
} else {
    echo "Class Dompdf\Options NOT found.\n";
}
