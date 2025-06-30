# Adapters - LLM Module

**This component is located in the `backend/Modules/LlmModule` folder.**

This document provides a comprehensive overview of the LLMModule, designed to manage and interact with various large language model (LLM) APIs in a modular and extensible manner. The module includes adapters for various LLM services, enabling integration with platforms such as OpenAI, Anthropic, and Llama.

# Module Overview

The LLMModule facilitates interaction with multiple LLM providers through a standardized interface. This modular design enables flexibility and scalability, allowing developers to easily integrate new LLMs by implementing specific adapters.

# File Descriptions

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

Adapters enable integration of specific LLM providers. Each adapter extends LLMBaseAdapter and implements the call($prompt, array $options = []) method to interact with the respective API.
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

# Usage Instructions

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

# Environment Configuration

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

# Security Notes
* API Keys: Store all API keys securely in your .env file. Do not hardcode them in your application.
* Rate Limits: Be mindful of the rate limits imposed by the LLM providers.
* Prompt Injection: Ensure input sanitization to prevent malicious user inputs in prompts.

# Conclusion

The LLMModule offers a flexible and scalable way to integrate with multiple LLM providers, enabling you to harness the power of AI-driven text generation and processing. Its modular design ensures extensibility and ease of maintenance, making it a robust choice for any Laravel application.
