<?php
declare(strict_types=1);

namespace Jajuma\PotGoogleTranslate\Magewire;

use Magento\Framework\Phrase;
use Magewirephp\Magewire\Component;
use Jajuma\PotGoogleTranslate\Helper\Config as HelperConfig;
use Magento\Framework\Serialize\Serializer\Json as JsonSerialize;

class QuickAction extends Component
{
    protected const DEFAULT_URL = 'https://translate.googleapis.com/translate_a/single';

    protected $listeners = ['sendGoogleTranslateRequest'];

    /**
     * @var HelperConfig
     */
    protected HelperConfig $helperConfig;

    /**
     * @var JsonSerialize
     */
    protected JsonSerialize $jsonSerialize;

    /**
     * @param HelperConfig $helperConfig
     * @param JsonSerialize $jsonSerialize
     */
    public function __construct(
        HelperConfig $helperConfig,
        JsonSerialize $jsonSerialize
    ) {
        $this->helperConfig = $helperConfig;
        $this->jsonSerialize = $jsonSerialize;
    }

    /**
     * Send google translate request
     *
     * @param $request
     * @param string $from
     * @param string $to
     * @return void
     */
    public function sendGoogleTranslateRequest($request, string $from = '', string $to = '')
    {
        $requestContent = '';
        if (is_array($request)) {
            if (!empty($request['request_content'])) {
                $requestContent = $request['request_content'];
            }
            if (!empty($request['from_lang'])) {
                $from = $request['from_lang'];
            }
            if (!empty($request['to_lang'])) {
                $to = $request['to_lang'];
            }
        } else {
            $requestContent = $request;
        }

        if (!$requestContent) {
            return;
        }

        if (strlen($requestContent) >= 5000) {
            $message = 'Maximum number of characters exceeded: 5000';
            $this->dispatchBrowserEvent('finish-request-pot-google-translate', ['message' => $message]);
            return;
        }

        $from = !empty($from) ? $from : $this->helperConfig->getDefaultFromLanguage();
        $to = !empty($to) ? $to : $this->helperConfig->getDefaultToLanguage();

        $message = '';
        $response = $this->sendRequest($requestContent, $from, $to);
        $message = $this->getResult($response);

        $this->dispatchBrowserEvent('finish-request-pot-google-translate', ['message' => $message]);
    }

    protected function sendRequest($requestContent, $from, $to)
    {
        $baseUrl = $this->helperConfig->getBaseUrl();
        if (empty($baseUrl)) {
            $baseUrl = self::DEFAULT_URL;
        }

        $params = [
            'client' => 'gtx',
            'dt' => 't',
            'sl' => $from,
            'tl' => $to,
            'q' => $requestContent
        ];

        $paramStr = '';
        foreach ($params as $key => $value) {
            $paramStr .= '&' . $key . '=' . $value;
        }
        rtrim($paramStr, '&');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $baseUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramStr);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * Get result
     *
     * @param $response
     * @return Phrase|string
     */
    protected function getResult($response)
    {
        $sentences = '';
        $sentencesArray = $this->jsonSerialize->unserialize($response);
        if (!$sentencesArray || !isset($sentencesArray[0])) {
            return 'Please try latter';
        }

        foreach ($sentencesArray[0] as $s) {
            $sentences .= $s[0] ?? '';
        }

        return $sentences;
    }
}
