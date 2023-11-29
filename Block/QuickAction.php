<?php
declare(strict_types=1);

namespace Jajuma\PotGoogleTranslate\Block;

use Jajuma\PotGoogleTranslate\Helper\Config as HelperConfig;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Jajuma\PotGoogleTranslate\Model\Config\Source\Languages;

class QuickAction extends \Jajuma\PowerToys\Block\PowerToys\QuickAction
{
    /**
     * @var HelperConfig
     */
    protected HelperConfig $helperConfig;

    /**
     * @var Languages
     */
    protected Languages $languages;

    /**
     * @param Context $context
     * @param HelperConfig $helperConfig
     * @param Languages $languages
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        HelperConfig $helperConfig,
        Languages $languages,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helperConfig = $helperConfig;
        $this->languages = $languages;
    }

    /**
     * Is enable
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->helperConfig->isEnable();
    }

    /**
     * Get approved languages
     *
     * @return array|string[]
     */
    public function getApprovedLanguages(): array
    {
        $data = [];
        $approved = $this->helperConfig->getApprovedLanguages();
        if (!empty($approved)) {
            $data = explode(',', $approved);
        }

        $defaultFrom = $this->getDefaultFromLanguage();
        $defaultTo = $this->getDefaultToLanguage();

        if (!in_array($defaultFrom, $data)) {
            $data[] = $defaultFrom;
        }

        if (!in_array($defaultTo, $data)) {
            $data[] = $defaultTo;
        }

        return $data;
    }

    /**
     * Get default from language
     *
     * @return mixed
     */
    public function getDefaultFromLanguage()
    {
        return $this->helperConfig->getDefaultFromLanguage();
    }

    /**
     * Get default to language
     *
     * @return mixed
     */
    public function getDefaultToLanguage()
    {
        return $this->helperConfig->getDefaultToLanguage();
    }

    /**
     * Get all languages
     *
     * @return array[]
     */
    public function getAllLanguages(): array
    {
        return $this->languages->toArray();
    }
}
