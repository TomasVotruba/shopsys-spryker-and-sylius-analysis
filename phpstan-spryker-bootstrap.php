<?php declare(strict_types=1);

use TomasVotruba\ShopsysAnalysis\PHPStan\TestsExcludingRobotLoader;

require_once __DIR__ . '/vendor/autoload.php';

(new TestsExcludingRobotLoader)->loadDirectoryWithoutTests(__DIR__ . '/project/spryker/vendor/spryker');
//(new TestsExcludingRobotLoader)->loadDirectoryWithoutTests(__DIR__ . '/project/spryker/src');
