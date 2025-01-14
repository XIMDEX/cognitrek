<?php

namespace Modules\LlmModule\Services;

use App\Models\Resource;
use Illuminate\Support\Facades\Storage;

class LLMService
{
    protected $llmManager;

    private const LANGUAGES_DICT = [
        'es' => 'spanish (Spain)',
        'en' => 'english'
    ];

    public function performAction($params = null)
    {
        // $file = file_get_contents($params['path']);
        // $json = json_decode($file, true);
        // foreach ($json['sections'] as $i => $section) {
        //     unset($json['sections'][$i]['images']);
        // }
        // $content = $json['sections'];
        $file = file_get_contents($params['md']);
        $content = nl2br(htmlspecialchars($file));
        $id = $params['id'];
        $output = [];

        try {
            $llmManager = new LLMManager();
            $this->init($llmManager);

            switch ($params['action']) {
                case 'resume':
                    $resume = $this->generateResume($id, $content, $params['lang']);
                    Storage::put("public/$id/resume.txt", $resume);
                    $output['resume'] = 'resume.txt';
                    break;
                case 'conceptual_map':
                    $conceptual_map = $this->generateMentalMap($id, $content, $params['lang']);
                    Storage::put("public/$id/conceptual_map.md", $conceptual_map);
                    $output['conceptual_map'] = 'conceptual_map.md';
                    break;
                case 'all':
                    $resume = $this->generateResume($id, $content, $params['lang']);
                    $conceptual_map =$this->generateMentalMap($id, $content, $params['lang']);
                    Storage::put("public/$id/resume.txt", $resume);
                    Storage::put("public/$id/conceptual_map.md", $conceptual_map);
                    $output['resume'] = 'resume.txt';
                    $output['conceptual_map'] = 'conceptual_map.md';
                    break;
                default:
                    break;
            }
            return ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function init(LLMManager $llmManager)
    {
        $this->llmManager = $llmManager;
    }

    /**
     * Generate a concise summary of the resource content in the specified language.
     * The prompt instructs the model to be factual and not to hallucinate.
     */
    public function generateResume($id, $content, string $lang = 'es')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = config('llmmodule.prompts.resume');
        $prompt = str_replace('###XIMDEX_LANG###', $this->getLanguage($lang), $prompt);
        $prompt = str_replace('###XIMDEX_CONTENT###', $content, $prompt);

        $summary = $llm->call($prompt);

        return $summary;
    }

    /**
     * Generate a mental map (key points or structured bullet points) from the resource content in the specified language.
     */
    public function generateMentalMap($id, $content, string $lang = 'en')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = config('llmmodule.prompts.conceptual_map');

        $prompt = str_replace('###XIMDEX_LANG###', $this->getLanguage($lang), $prompt);
        $prompt = str_replace('###XIMDEX_CONTENT###', $content, $prompt);

        $map = $llm->call($prompt);

        if (str_starts_with($map, "```markmap")) {
            $map = substr($map, 10);
        }
        if (str_ends_with($map, "```")) {
            $map = substr($map, 0, -3);
        }

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

    public function getLanguage($lang)
    {
        if (isset(self::LANGUAGES_DICT[$lang])) return self::LANGUAGES_DICT[$lang];
        return 'same language of content';
    }
}
