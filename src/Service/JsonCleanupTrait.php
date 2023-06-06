<?php

namespace MLocati\PayWay\Service;

trait JsonCleanupTrait
{
    private function cleanupJson(array $json)
    {
        foreach (array_keys($json) as $key) {
            $value = $json[$key];
            if ($value === '' || $value === null || $value === []) {
                unset($json[$key]);
            }
        }

        return $json;
    }
}
