<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

if (!($settings = include(__DIR__ . '/../vendor/ezsystems/ezpublish-kernel/config.php'))) {
    throw new \RuntimeException('Could not find config.php, please copy config.php-DEVELOPMENT to vendor/ezsystems/ezpublish-kernel/config.php & customize to your needs!');
}

require_once __DIR__ . '/../vendor/autoload.php';
