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
    public function get(string $topic, string $property, $failSilently = true): string
    {
        $setting = $this->findOneBy(['topic' => $topic, 'property' => $property]);

        if (null === $setting) {
            if ($failSilently) {
                return '';
            }
            throw new SettingNotFoundException();
        }

        return $setting->getValue();
    }

    public function set(string $group, string $key, string $value): bool
    {
        $setting = $this->findOneBy(['topic' => $group, 'property' => $key]);

        if (null === $setting) {
            $setting = new Setting($group, $key);
        }

        $setting->setValue($value);

//        try {
        $this->_em->persist($setting);
        $this->_em->flush($setting);
//        } catch (\Exception $e) {
//            return false;
//        }

        return true;
    }
}
