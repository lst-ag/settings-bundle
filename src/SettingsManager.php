<?php

namespace LST\SettingsBundle;

use Doctrine\Common\Annotations\Reader;
use LST\SettingsBundle\Annotation\Category;
use LST\SettingsBundle\Annotation\Property;
use LST\SettingsBundle\Exception\InvalidSettingsObjectException;
use LST\SettingsBundle\Repository\SettingRepository;

class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var Reader
     */
    private $reader;

    public function __construct(SettingRepository $settingRepository, Reader $reader)
    {
        $this->settingRepository = $settingRepository;
        $this->reader = $reader;
    }

    /**
     * Fetch a single setting.
     *
     * @throws Exception\SettingNotFoundException
     */
    public function fetchProperty(string $topic, string $property): string
    {
        return $this->settingRepository->get($topic, $property);
    }

    /**
     * Persist a single setting.
     */
    public function persistProperty(string $topic, string $property, string $value)
    {
        return $this->settingRepository->set($topic, $property, $value);
    }

    /**
     * Fetch a populated settings object.
     *
     * @throws Exception\SettingNotFoundException
     */
    public function fetch(string $settingsClassName): object
    {
        $reflectionObject = new \ReflectionObject(new $settingsClassName());
        $categoryAnnotation = $this->reader->getClassAnnotation($reflectionObject, Category::class);

        if (null === $categoryAnnotation) {
            throw new InvalidSettingsObjectException($settingsClassName);
        }

        $object = new $settingsClassName();

        foreach ($reflectionObject->getProperties() as $reflectionProperty) {
            $propertyAnnotation = $this->reader->getPropertyAnnotation($reflectionProperty, Property::class);

            if (null === $propertyAnnotation) {
                continue;
            }

            $propertyName = $propertyAnnotation->getName() ?? $reflectionProperty->getName();
            $object->$propertyName = $this->fetchProperty($categoryAnnotation->getName(), $propertyName);
        }

        return $object;
    }

    /**
     * Persist a settings object.
     *
     * @throws Exception\SettingNotFoundException
     */
    public function persist(object $settingsObject): bool
    {
        $reflectionObject = new \ReflectionObject($settingsObject);
        $categoryAnnotation = $this->reader->getClassAnnotation($reflectionObject, Category::class);

        if (null === $categoryAnnotation) {
            throw new InvalidSettingsObjectException(get_class($settingsObject));
        }

        $error = false;
        foreach ($reflectionObject->getProperties() as $reflectionProperty) {
            $propertyAnnotation = $this->reader->getPropertyAnnotation($reflectionProperty, Property::class);

            if (null === $propertyAnnotation) {
                continue;
            }

            $originalPropertyName = $reflectionProperty->getName();
            $propertyName = $propertyAnnotation->getName() ?? $originalPropertyName;
            if (!$this->persistProperty($categoryAnnotation->getName(), $propertyName, $settingsObject->$originalPropertyName)) {
                $error = true;
            }
        }

        return $error;
    }
}
