<?php
$iniPath = 'D:\php8.4\php.ini';
$content = file_get_contents($iniPath);

$content = preg_replace('/^upload_max_filesize\s*=\s*.+/m', 'upload_max_filesize = 50M', $content);
$content = preg_replace('/^post_max_size\s*=\s*.+/m', 'post_max_size = 50M', $content);

file_put_contents($iniPath, $content);
echo "php.ini updated!\n";
