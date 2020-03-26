<?php

namespace LST\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="LST\SettingsBundle\Repository\SettingRepository")
 */
class Setting
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $category;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $property;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $value;

    public function __construct(string $category, string $property)
    {
        $this->category = $category;
        $this->property = $property;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
