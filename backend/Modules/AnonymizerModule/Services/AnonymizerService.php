<?php

namespace Modules\AnonymizerModule\Services;

class AnonymizerService
{
    private $secretPhrase;
    private $cipher;

    public function performAction($params = null)
    {
        $this->secretPhrase = config('anonymizermodule.secret_phrase');
        $this->cipher =  config('anonymizermodule.cipher');
        if ($params['action'] == 'encode') return $this->anonymizeUUID($params['value']);
        if ($params['action'] == 'decode') return $this->recoverUUID($params['value']);
    }

    public function anonymizeUUID($uuid) {
        $key = hash('sha256', $this->secretPhrase, true);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr(hash('sha256', $this->secretPhrase), 0, $ivLength);
        $encrypted = openssl_encrypt($uuid, $this->cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public function recoverUUID($encryptedUUID) {
        $key = hash('sha256', $this->secretPhrase, true);
        $ivLength = openssl_cipher_iv_length($this->cipher);

        $iv = substr(hash('sha256', $this->secretPhrase), 0, $ivLength);
        $encryptedText = base64_decode($encryptedUUID);
        return openssl_decrypt($encryptedText, $this->cipher, $key, 0, $iv);
    }
}
