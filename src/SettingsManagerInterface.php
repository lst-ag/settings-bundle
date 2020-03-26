<?php

namespace LST\SettingsBundle;

interface SettingsManagerInterface
{
    public function fetchProperty(string $topic, string $property): string;

    public function persistProperty(string $topic, string $property, string $value);

    public function fetch(string $settingsClassName);

    public function persist(object $settingsObject): bool;
}
