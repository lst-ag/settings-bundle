<?php

namespace LST\SettingsBundle\Exception;

class InvalidSettingsObjectException extends Exception
{
    public function __construct(string $fqdn)
    {
        $message = \Safe\sprintf('The object %s is not a valid settings object. Add the annotation @LST\SettingsBundle\Annotation\Category to the object to use it as a settings category.', $fqdn);
        parent::__construct($message, 1585147751);
    }
}
