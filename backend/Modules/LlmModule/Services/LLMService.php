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
        try {
            $this->checkParams($params);

            $llmManager = new LLMManager();
            $this->init($llmManager);
            
            if ($params['action'] == 'adaptation') {
                $adaptation = $this->generateAdaptation($params['data']);

                return $adaptation;
            }

            $params['data'] = storage_path("app/public/$params[id]/raw.md");


            $file = file_get_contents($params['data']);
            $content = nl2br(htmlspecialchars($file));
            $id = $params['id'];

            switch ($params['action']) {
                case 'resume':
                    $this->generateResume($id, $content, $params['lang']);
                    break;
                case 'conceptual_map':
                    $this->generateMentalMap($id, $content, $params['lang']);
                    break;
                case 'all':
                    $this->generateResume($id, $content, $params['lang']);
                    $this->generateMentalMap($id, $content, $params['lang']);
                    break;
                default:
                    break;
            }
            return ;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function checkParams($params)
    {
        if (!isset($params['id'])) {
            throw new \Exception('id param not found');
        }

        if (!isset($params['lang'])) {
            throw new \Exception('lang param not found');
        }

        if (!isset($params['action'])) {
            throw new \Exception('action param not found');
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
        $prompt = file_get_contents($prompt);
        $prompt = str_replace('###XIMDEX_LANG###', $this->getLanguage($lang), $prompt);
        $prompt = str_replace('###XIMDEX_CONTENT###', $content, $prompt);

        $summary = $llm->call($prompt);

        Storage::put("public/$id/resume.txt", $summary);
        return $summary;
    }

    /**
     * Generate a mental map (key points or structured bullet points) from the resource content in the specified language.
     */
    public function generateMentalMap($id, $content, string $lang = 'en')
    {
        $llm = $this->llmManager->getDefaultLLM();

        $prompt = config('llmmodule.prompts.conceptual_map');
        $prompt = file_get_contents($prompt);

        $prompt = str_replace('###XIMDEX_LANG###', $this->getLanguage($lang), $prompt);
        $prompt = str_replace('###XIMDEX_CONTENT###', $content, $prompt);

        $map = $llm->call($prompt);

        if (str_starts_with($map, "```markmap") or str_starts_with($map, "```markdown")) {
            $map = substr($map, 10);
        }
        if (str_ends_with($map, "```")) {
            $map = substr($map, 0, -3);
        }

        Storage::put("public/$id/conceptual_map.md", $map);
        return $map;
    }

    /**
     * Generate a variant (a rewritten version) of the resource content in the specified language, preserving meaning but changing wording.
     */
    public function generateAdaptation($params)
    {
        $content = $params['resource'];
        $prompt = $params['prompt'];

        $llm = $this->llmManager->getDefaultLLM();

        $prompt = config('llmmodule.prompts.' . $prompt);
        if (!$prompt) {
            return false;
        }
        $prompt = file_get_contents($prompt);

        $lang = $params['lang'];     
        $prompt = str_replace('###XIMDEX_LANG###', $this->getLanguage($lang), $prompt);

        foreach ($content as $key => $value) {
            $content[$key]['id'] = $value['page'];
            $content[$key]['content'] = json_encode($value['blocks']);
            unset($content[$key]['blocks']);
        }

        $variant = $llm->batch($content, $prompt, []);


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
