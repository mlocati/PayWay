<?php

use MLocati\PayWay\Test\Service\TestCase;
use PHPUnit\Runner\Version;

require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists(Version::class)) {
    class_alias('PHPUnit_Runner_Version', Version::class);
}

if (version_compare(Version::id(), '8') >= 0) {
    class_alias(TestCase\v2::class, TestCase::class);
} else {
    class_alias(TestCase\v1::class, TestCase::class);
}
