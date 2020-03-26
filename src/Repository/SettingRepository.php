<?php

namespace LST\SettingsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use LST\SettingsBundle\Entity\Setting;
use LST\SettingsBundle\Exception\SettingNotFoundException;

class SettingRepository extends EntityRepository
{
    /**
     * @throws SettingNotFoundException
     */
    public function fetchProperty(string $category, string $property, $failSilently = true): string
    {
        $setting = $this->findOneBy(['category' => $category, 'property' => $property]);

        if (null === $setting) {
            if ($failSilently) {
                return '';
            }
            throw new SettingNotFoundException();
        }

        return $setting->getValue();
    }

    public function persistProperty(string $category, string $key, string $value): bool
    {
        $setting = $this->findOneBy(['category' => $category, 'property' => $key]);

        if (null === $setting) {
            $setting = new Setting($category, $key);
        }

        $setting->setValue($value);

        try {
            $this->_em->persist($setting);
            $this->_em->flush($setting);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
