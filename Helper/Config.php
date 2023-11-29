<?php
declare(strict_types=1);

namespace Jajuma\PotGoogleTranslate\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    public const XML_PATH_ENABLE = 'power_toys/pot_google_translate/is_enabled';

    public const XML_PATH_BASE_URL = 'power_toys/pot_google_translate/base_url';

    public const XML_PATH_APPROVED_LANGUAGES = 'power_toys/pot_google_translate/approved_languages';

    public const XML_PATH_APPROVED_DEFAULT_FROM_LANGUAGE = 'power_toys/pot_google_translate/default_from_language';

    public const XML_PATH_APPROVED_DEFAULT_TO_LANGUAGE = 'power_toys/pot_google_translate/default_to_language';

    /**
     * Is enable
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE);
    }

    /**
     * Get base url
     *
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_BASE_URL);
    }

    /**
     * Get approved languages
     *
     * @return mixed
     */
    public function getApprovedLanguages()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_APPROVED_LANGUAGES);
    }

    /**
     * Get default from language
     *
     * @return mixed
     */
    public function getDefaultFromLanguage()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_APPROVED_DEFAULT_FROM_LANGUAGE);
    }

    /**
     * Get default to language
     *
     * @return mixed
     */
    public function getDefaultToLanguage()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_APPROVED_DEFAULT_TO_LANGUAGE);
    }
}
