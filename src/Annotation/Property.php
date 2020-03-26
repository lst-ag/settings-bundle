<?php

namespace LST\SettingsBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Property
{
    /**
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
