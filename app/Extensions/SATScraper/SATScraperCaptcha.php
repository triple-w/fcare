<?php

namespace App\Extensions\SATScraper;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class SATScraperCaptcha extends \Blacktrue\Scraping\SATScraper {

    const SAT_CREDENTIAL_ERROR = 'El RFC o CIEC son incorrectos';

    protected $captcha;

    public function __construct(array $options = [])
    {
        $this->data = [];
        $this->requests = [];

        $this->rfc = $options['rfc'];
        $this->ciec = $options['ciec'];
        $this->captcha = $options['captcha'];
        $this->tipoDescarga = isset($options['tipoDescarga']) ? $options['tipoDescarga'] : 'recibidos';
        $this->cancelados = isset($options['cancelados']) ? $options['cancelados'] : false;
        $this->loginUrl = isset($options['loginUrl']) ? $options['loginUrl'] : URLS::SAT_URL_LOGIN;
        $this->client = new Client();
        $value = (array)json_decode(base64_decode($options['session'], true));
        $this->cookie = CookieJar::fromArray($value, '/');
        $this->init();
    }

    protected function init()
    {
        $this->login();
        $data = $this->dataAuth();
        $data = $this->postDataAuth($data);
        $data = $this->start($data);
        $this->selectType($data);
    }

    public function setTipoDescarga($tipoDescarga) {
        $this->tipoDescarga = $tipoDescarga;
    }

    private function login()
    {
        $response = $this->client->post($this->loginUrl, [
            'future' => true,
            'verify' => false,
            'cookies' => $this->cookie,
            'form_params' => [
                'Ecom_Password' => $this->ciec,
                'Ecom_User_ID' => $this->rfc,
                'jcaptcha' => $this->captcha,
                'option' => 'credential',
                'submit' => 'Enviar',
            ],
        ])->getBody()->getContents();

        if (strpos($response, 'document.forms[0].submit();') !== false) {
            throw new SATCredentialsException(self::SAT_CREDENTIAL_ERROR);
        }

        return $response;
    }
}

?>
