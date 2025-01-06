<?php
$from = "/home/steelghar/public_html/demo/steelghar.com/public/storage";
$to = "/home/steelghar/public_html/demo/storage";
symlink($from, $to);
echo readlink($to);
