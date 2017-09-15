<?php declare(strict_types=1);

use TomasVotruba\ShopsysAnalysis\PHPStan\SyliusRobotLoader;

require_once __DIR__ . '/vendor/autoload.php';

$syliusRobotLoader = new SyliusRobotLoader;
$syliusRobotLoader->loadDirectoryWithoutTests(__DIR__ . '/project/sylius/src');
