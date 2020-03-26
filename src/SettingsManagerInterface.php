<?php

namespace LST\SettingsBundle;

interface SettingsManagerInterface
{
    public function fetchProperty(string $category, string $property): string;

    public function persistProperty(string $category, string $property, string $value);

    public function fetch(string $settingsClassName);

    public function persist(object $settingsObject): bool;
}
