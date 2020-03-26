<?php

namespace LST\SettingsBundle\Exception;

class InvalidSettingsObjectException extends Exception
{
    public function __construct(string $className)
    {
        $message = sprintf('The object %s is not a valid settings object. Add the annotation @LST\SettingsBundle\Annotation\Category to the object to use it as a settings category.', $className);
        parent::__construct($message, 1585147751);
    }
}
