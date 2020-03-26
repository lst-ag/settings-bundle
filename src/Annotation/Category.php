<?php

namespace LST\SettingsBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Category
{
    /**
     * @Required
     *
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
