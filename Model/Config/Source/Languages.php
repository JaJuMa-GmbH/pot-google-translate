<?php
declare(strict_types=1);

namespace Jajuma\PotGoogleTranslate\Model\Config\Source;

class Languages
{
    /**
     * To option array
     *
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' =>  'auto', 'label' => 'Auto'],
            ['value' =>  'en', 'label' => 'English'],
            ['value' =>  'vi', 'label' => 'VietNam'],
            ['value' =>  'de', 'label' => 'German'],
            ['value' =>  'fr', 'label' => 'France'],
            ['value' =>  'ja', 'label' => 'Japan'],
            ['value' =>  'zh-CN', 'label' => 'Chinese'],
            ['value' =>  'es', 'label' => 'Spanish'],
            ['value' =>  'uk', 'label' => 'Ukraine'],
            ['value' =>  'ru', 'label' => 'Russia'],
        ];
    }

    /**
     * To array
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        $languages = $this->toOptionArray();
        foreach ($languages as $language) {
            $value = $language['value'];
            $label = $language['label'];
            $array[$value] = $label;
        }

        return $array;
    }
}
