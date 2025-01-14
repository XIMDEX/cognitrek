# Documentation for Modules

## Anonymizer Module

This document provides a detailed explanation of the Anonymizer Module in your Laravel project, which includes a service for encrypting and decrypting UUIDs to ensure data anonymity.

### Module Overview

The Anonymizer Module provides functionality to encode and decode UUIDs securely using AES-256 encryption. It is designed to maintain the confidentiality of sensitive identifiers in a modular and reusable manner.

### File Descriptions

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

### Usage Instructions

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

### Security Notes
* The secret phrase must be stored securely, preferably in an environment variable.
* Ensure the cipher algorithm aligns with your project’s security requirements.
* Regularly update the secret phrase and re-encrypt any stored data when security protocols change.

### Conclusion

The Anonymizer Module is a robust solution for ensuring data anonymity in your Laravel project. Its modular design and ease of integration make it a versatile choice for managing sensitive data securely. ￼

## LLMModule

This document provides a comprehensive overview of the LLMModule, designed to manage and interact with different Large Language Model (LLM) APIs in a modular and extensible manner. The module includes adapters for various LLM services, enabling integration with platforms such as OpenAI, Anthropic, and Llama.

### Module Overview

The LLMModule facilitates interactions with multiple LLM providers through a standardized interface. This modular design enables flexibility and scalability, allowing developers to easily integrate new LLMs by implementing specific adapters.

### File Descriptions

1. LLMService.php

The LLMService class acts as the primary interface for managing and utilizing the LLMModule.
* Namespace: Modules\LlmModule\Services
* Key Methods:
    * performAction($params):
        * Executes various actions based on the parameters provided, including generating summaries, conceptual maps, or other text-based outputs.
        * Parameters:
            * action: Defines the operation to perform (resume, conceptual_map, or all).
            * id: A unique identifier for the resource.
            * md: Path to the Markdown file containing content.
            * lang: Language in which the operation should be performed (default: es).
* generateResume($id, $content, $lang):
    * Generates a summary of the provided content in the specified language.
* generateMentalMap($id, $content, $lang):
    * Creates a conceptual map (e.g., key points or structured bullet points) from the provided content.
* generateVariant($resource, $lang):
    * Generates a rewritten version of the content, preserving the original meaning while changing the wording.

2. LLMManager.php

The LLMManager class manages the selection and initialization of the appropriate LLM adapter based on the configuration.
* Namespace: Modules\LlmModule\Services
* Key Methods:
    * getDefaultLLM():
        * Returns the default LLM instance based on the configuration.
    * getLLMByName($name):
        * Retrieves a specific LLM adapter instance by name.

3. Adapters

Adapters enable the integration of specific LLM providers. Each adapter extends LLMBaseAdapter and implements the call($prompt, array $options = []) method to interact with the respective API.
* AnthropicAdapter.php:
    * Interacts with Anthropic’s API.
    * Example endpoint: /v1/complete.
* LlamaAdapter.php:
    * Handles requests to Llama’s API.
    * Example endpoint: /v1/generate.
* OpenAIAdapter.php:
    * Connects to OpenAI’s API.
    * Example endpoint: /v1/chat/completions.
* LLMBaseAdapter.php:
    * Provides a common base for all adapters, ensuring consistency in how they interact with their respective APIs.

4. config.php

The configuration file defines the module settings, including the default LLM, available drivers, and prompts.
* Configuration Keys:
    * name: Module name (LlmModule).
    * version: Module version (1.0.0).
    * default: Default LLM driver (e.g., OpenAI).
    * services: Registers the LLMService.
    * drivers: Defines the available LLM adapters with their respective configurations.
    * prompts:
        * Predefined prompts for specific actions like summaries and conceptual maps.

### Usage Instructions

Using the Service in Controllers

In any controller that extends from Controller, you can leverage the following methods to interact with the LLMModule services:

1.	$this->useService('service_name_in_config', $params):
* Executes the performAction($params) method of the corresponding service.
Example:

```PHP
$result = $this->useService('llm_service', [
    'action' => 'resume',
    'id' => $resourceId,
    'md' => $markdownFilePath,
    'lang' => 'en',
]);
```


2.	$this->getService('service_name_in_config'):
* Retrieves an instance of the service for more advanced or custom interactions.
Example:

```PHP
$llmService = $this->getService('llm_service');
$result = $llmService->performAction([
    'action' => 'conceptual_map',
    'id' => $resourceId,
    'md' => $markdownFilePath,
    'lang' => 'es',
]);
```

### Environment Configuration

To set up the module, ensure the following environment variables are configured:

```
DEFAULT_LLM=OpenAI

# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key
OPENAI_API_URL=https://api.openai.com/v1/chat/completions
OPENAI_MODEL=gpt-4o-mini

# Anthropic Configuration
ANTHROPIC_API_KEY=your_anthropic_api_key
ANTHROPIC_BASE_URL=https://api.anthropic.com
ANTHROPIC_MODEL=soonet-3.5

# Llama Configuration
LLAMA_API_KEY=your_llama_api_key
LLAMA_BASE_URL=https://api.llama.com
LLAMA_MODEL=llama-default-model
```

### Security Notes
* API Keys: Store all API keys securely in your .env file. Do not hardcode them in your application.
* Rate Limits: Be mindful of the rate limits imposed by the LLM providers.
* Prompt Injection: Ensure input sanitization to prevent malicious user inputs in prompts.

### Conclusion

The LLMModule offers a flexible and scalable way to integrate with multiple LLM providers, enabling you to harness the power of AI-driven text generation and processing. Its modular design ensures extensibility and ease of maintenance, making it a robust choice for any Laravel application.

## Viewer Module

This documentation describes the Viewer Module, which facilitates the rendering and management of resource views in a Laravel project. The module includes services and controllers for handling resources and their variants, ensuring seamless integration with your application.

### Module Overview

The Viewer Module is designed to provide a flexible way to manage and display resources retrieved from external systems. It supports the rendering of content with options for handling modified data and different resource variants.

### File Descriptions

1. ViewerService.php

The ViewerService class handles the core logic for rendering resource views.
* Namespace: Modules\ViewerModule\Services
* Key Methods:
    * performAction($params):
        * Reserved for future actions related to the Viewer Module.
    * view($resource, $modified):
        * Renders the resource view using the provided data.
        * Parameters:
            * $resource: The resource data to display.
            * $modified: Modified data, if any, to incorporate into the view.
        * Returns an HTML view or a JSON error response if rendering fails.

2. api.php

Defines the API routes for the Viewer Module.
* Namespace: Not applicable (route file).
* Key Routes:
    * GET /viewer/health:
        * Health check endpoint for the module.
        * Returns a JSON response: { "status": "ok" }.
    * GET /viewer/{resource_id}:
        * Endpoint to view a resource by its ID.
        * Calls the view method in the ViewerController.

3. ViewerController.php

The ViewerController class manages incoming requests and interacts with the ViewerService to display resources.
* Namespace: Modules\ViewerModule\Controllers
* Dependencies:
    * ResourceService: Retrieves resources from external systems.
    * VariantService: Fetches variants of resources, if available.
* Key Methods:
    * view(Request $request, $resourceId):
        * Retrieves the specified resource and its variants, then delegates rendering to ViewerService.
        * Parameters:
            * $request: The HTTP request object.
            * $resourceId: The unique identifier of the resource.
        * Returns an HTML view or a JSON error response.

4. config.php

Defines the configuration for the Viewer Module.
* Configuration Keys:
* name: Module name (ViewerModule).
* version: Module version (1.0.0).
* services: Registers the ViewerService.

Usage Instructions

Using the Service in Controllers

In any controller that extends from Controller, you can leverage the following methods to interact with the ViewerModule services:

1.	$this->useService('service_name_in_config', $params):
* Executes the performAction($params) method of the corresponding service.

Example:

```PHP
$result = $this->useService('viewer_service', [
    'action' => 'view',
    'id' => $resourceId,
]);
```

2.	$this->getService('service_name_in_config'):
* Retrieves an instance of the service for custom interactions.
Example:

```PHP
$viewerService = $this->getService('viewer_service');
$result = $viewerService->view($resourceData, $modifiedData);
```

### Environment Configuration

No specific environment variables are required for the Viewer Module by default. Ensure your system properly configures the ResourceService and VariantService to interact with external systems or databases.

Security Notes
* Data Validation: Ensure that incoming requests for resources are validated to prevent unauthorized access.
* Error Handling: Implement robust error logging for the view method to diagnose issues efficiently.
* Secure Rendering: Avoid exposing sensitive data in the rendered views.

### Conclusion

The Viewer Module provides a streamlined way to display resources and their variants in your Laravel application. Its modular design and clear structure make it easy to maintain and extend, ensuring reliable integration into your project. ￼