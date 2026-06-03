<?php
$path = 'D:\php8.4\php.ini';
$content = file_get_contents($path);
$content = str_replace("\0", '', $content);
$content = str_replace("e x t e n s i o n = i n t l", '', $content);
$content = trim($content) . "\n\nextension=intl\n";
file_put_contents($path, $content);
echo "php.ini fixed.\n";
