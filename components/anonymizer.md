# Anonymizer Module

**This component is located in the `backend/Modules/AnonymizerModule` folder.**

This document provides a detailed explanation of the Anonymizer Module in your Laravel project, which includes a service for encrypting and decrypting UUIDs to ensure data anonymity.

## Module Overview

The Anonymizer Module provides functionality to encode and decode UUIDs securely using AES-256 encryption. It is designed to maintain the confidentiality of sensitive identifiers in a modular and reusable manner.

## File Descriptions

1. AnonymizerService.php

The AnonymizerService class is the core of the module. It provides methods to encode and decode UUIDs using the specified cipher and a secret phrase.
* Namespace: Modules\AnonymizerModule\Services
* Key Methods:
    * performAction($params = null):
        * Executes the appropriate method (anonymizeUUID or recoverUUID) based on the action parameter.
        * Parameters:
        * `$params['action']`: Action to perform (encode or decode).
        * `$params['value']`: The UUID to process.
        * Usage: Acts as an entry point for other components to interact with the service.
    * anonymizeUUID($uuid):
        * Encrypts the given UUID using AES-256-CBC encryption.
        * Encryption Process:
            1.	Generates a key using the secret phrase.
            2.	Creates an initialization vector (IV) based on the cipher’s requirements.
            3.	Encrypts the UUID and concatenates it with the IV.
            4.	Encodes the result in Base64 for safe storage or transmission.
    * recoverUUID($encryptedUUID):
        * Decrypts the given Base64-encoded string to recover the original UUID.
        * Decryption Process:
            1.	Decodes the Base64-encoded data to extract the IV and encrypted text.
            2.	Decrypts the text using the secret key and IV to retrieve the original UUID.

2. config.php

This file defines the configuration settings for the Anonymizer Module.
* Configuration Keys:
    * name: The name of the module (AnonymizerModule).
    * version: The module version (1.0.0).
    * services: Registers the AnonymizerService class.
    * secret_phrase:
        * Defines the secret phrase used for encryption and decryption.
        * Default: Retrieved from the .env file (SECRET_PHRASE_ANONYMIZER).
    * cipher:
        * Specifies the encryption algorithm (AES-256-CBC).

## Usage Instructions

Using the Service in Controllers

In any controller that extends from Controller, you can use the following methods:

1.	$this->useService('service_name_in_config', $params):
* Executes the performAction($params) method of the corresponding service.

Example:

```PHP
$result = $this->useService('anonymizer_service', [
    'action' => 'encode',
    'value' => $uuid,
]);
```


2.	$this->getService('service_name_in_config'):
* Retrieves an instance of the service for more direct usage.

Example:

```PHP
$anonymizerService = $this->getService('anonymizer_service');
$encoded = $anonymizerService->performAction([
    'action' => 'encode',
    'value' => $uuid,
]);
```

## Security Notes
* The secret phrase must be stored securely, preferably in an environment variable.
* Ensure the cipher algorithm aligns with your project’s security requirements.
* Regularly update the secret phrase and re-encrypt any stored data when security protocols change.

## Conclusion

The Anonymizer Module is a robust solution for ensuring data anonymity in your Laravel project. Its modular design and ease of integration make it a versatile choice for managing sensitive data securely. ￼