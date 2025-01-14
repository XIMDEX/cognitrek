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
        if ($params['action'] == 'encode') return $this->anonymizeUUID($params['value']);
    }

    public function anonymizeUUID($uuid) {
        $key = hash('sha256', $this->secretPhrase, true); 
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher)); 
        $encrypted = openssl_encrypt($uuid, $this->cipher, $key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function recoverUUID($encryptedUUID) {
        $key = hash('sha256', $this->secretPhrase, true);

        $data = base64_decode($encryptedUUID);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivLength); 
        $encryptedText = substr($data, $ivLength); 

        return openssl_decrypt($encryptedText, $this->cipher, $key, 0, $iv);
    }
}
