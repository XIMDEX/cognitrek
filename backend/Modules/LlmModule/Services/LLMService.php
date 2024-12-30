<?php

namespace Modules\LlmModule\Services;

use App\Models\Resource;

class LLMService
{
    protected $llmManager;

    public function init(LLMManager $llmManager)
    {
        $this->llmManager = $llmManager;
    }

    /**
     * Generate a concise summary of the resource content in the specified language.
     * The prompt instructs the model to be factual and not to hallucinate.
     */
    public function generateResume(Resource $resource, string $lang = 'en')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = <<<EOT
You are a helpful assistant. The user will provide a text, and you must produce a concise summary in {$lang}. 
Follow these rules strictly:
- Only use information provided in the text.
- Do not add new details or hallucinate.
- Be factual, neutral, and concise.
- The final answer must be strictly in {$lang}.

Text:
{$resource->content}

Please provide a concise summary in {$lang}.
EOT;

        $summary = $llm->call($prompt);

        // Store the generated summary
        $resource->resume = $summary;
        $resource->save();

        return $summary;
    }

    /**
     * Generate a mental map (key points or structured bullet points) from the resource content in the specified language.
     */
    public function generateMentalMap(Resource $resource, string $lang = 'en')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = <<<EOT
You are a helpful assistant. The user will provide a text, and you must extract the key points to form a structured, hierarchical mental map in {$lang}. 
Follow these rules strictly:
- Only use information from the given text.
- Do not add new points that are not present in the text.
- Use bullet points or a hierarchical format.
- The final answer must be strictly in {$lang}.
- Remain factual, no hallucinations.

Text:
{$resource->content}

Please provide the mental map in {$lang}.
EOT;

        $map = $llm->call($prompt);

        $resource->mental_map = $map;
        $resource->save();

        return $map;
    }

    /**
     * Generate a variant (a rewritten version) of the resource content in the specified language, preserving meaning but changing wording.
     */
    public function generateVariant(Resource $resource, string $lang = 'en')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = <<<EOT
You are a helpful assistant. The user will provide a text, and you must rewrite it into a variant in {$lang}:
- Preserve the original meaning.
- Do not introduce new information or hallucinations.
- Use the same factual content from the provided text, but rephrase the sentences in a natural way.
- The final answer must be strictly in {$lang}.

Text:
{$resource->content}

Please provide a rephrased variant in {$lang}.
EOT;

        $variant = $llm->call($prompt);

        $resource->variant = $variant;
        $resource->save();

        return $variant;
    }

    /**
     * Retrieve stored resume.
     */
    public function getResume(Resource $resource)
    {
        return $resource->resume;
    }

    /**
     * Retrieve stored mental map.
     */
    public function getMentalMap(Resource $resource)
    {
        return $resource->mental_map;
    }

    /**
     * Retrieve stored variant.
     */
    public function getVariant(Resource $resource)
    {
        return $resource->variant;
    }
}
