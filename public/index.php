<?php

require_once __DIR__.'/../vendors/helpers.php';

$vendorDirectory = findVendorDiretory();
echo $vendorDirectory;

require_once __DIR__.'/../vendors/'.$vendorDirectory.'/vendor/autoload.php';