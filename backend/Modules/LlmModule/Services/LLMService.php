<?php

namespace Modules\LlmModule\Services;

use App\Models\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LLMService
{
    protected $llmManager;

    private $languages;

    const ACTIONS = [
        'ADAPTATION' => 'adaptation',
        'RESUME' => 'resume',
        'CONCEPTUAL_MAP' => 'conceptual_map',
        'ALL' => 'all'
    ];

    public function performAction($params = null)
    {
        try {
            Storage::disk('local')->put("llm_params_lastest.json", json_encode($params, JSON_PRETTY_PRINT));
            $this->checkParams($params);

            $llmManager = new LLMManager();
            $this->init($llmManager);
            
            if ($params['action'] == self::ACTIONS['ADAPTATION']) {
                $opts = $params['opts'] ?? [];
                $adaptation = $this->generateAdaptation($params['data'], $opts);

                return $adaptation;
            }

            $params['data'] = storage_path("app/public/$params[id]/raw.md");


            $file = file_get_contents($params['data']);
            $content = nl2br(htmlspecialchars($file));
            $id = $params['id'];

            switch ($params['action']) {
                case self::ACTIONS['RESUME']:
                    $this->generateResume($id, $content, $params['lang']);
                    break;
                case self::ACTIONS['CONCEPTUAL_MAP']:
                    $this->generateMentalMap($id, $content, $params['lang']);
                    break;
                case self::ACTIONS['ALL']:
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
        Log::info('LLMService::performAction', $params);

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
        $this->languages = config('llmmodule.languages');
    }

    /**
     * Generate a concise summary of the resource content in the specified language.
     * The prompt instructs the model to be factual and not to hallucinate.
     */
    public function generateResume($id, $content, string $lang = 'es')
    {
        $llm = $this->llmManager->getLlmByAction(self::ACTIONS['RESUME']);

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
        $llm = $this->llmManager->getLlmByAction(self::ACTIONS['CONCEPTUAL_MAP']);

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
    public function generateAdaptation($params, $opts=[])
    {
        return (isset($params['id']) && $params['id']) 
            ? $this->continueAdaptation($params, $opts) 
            : $this->generateNewAdaptation($params, $opts);
    }

    public function call($params, $action)
    {
        $llm = $this->llmManager->getLlmByAction($action);
        return $llm->call($params['prompt'], $params['options'], $params['path']);
    }

    private function generateNewAdaptation($params, $opts)
    {
        $content = $params['resource'];
        $prompt = $params['prompt'];

        $llm = $this->llmManager->getLlmByAction(self::ACTIONS['ADAPTATION']);

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
        
        $opts = [
            'llm_manager' => [
                'class' => LLMManager::class,
                'action' => self::ACTIONS['ADAPTATION']
            ],
            'llm_sevice' => 'llm_service'
        ];

        if (isset($params['maxAttempts'])) {
            $opts['maxAttempts'] = $params['maxAttempts'];
        }
        if (isset($params['timeSleep'])) {
            $opts['timeSleep'] = $params['timeSleep'];
        }
        return $llm->batch($content, $prompt, $opts);
    }

    private function continueAdaptation($params, $opts)
    {
        $llm = $this->llmManager->getLlmByAction(self::ACTIONS['ADAPTATION']);
        $content = $params['resource'];
        $prompt = $params['prompt'];
        $options = [
            'lang' => $params['lang'],
            'batch_id' => $params['id'],
        ];

        if (isset($opts['maxAttempts'])) {
            $options['maxAttempts'] = $opts['maxAttempts'];
        }
        if (isset($opts['timeSleep'])) {
            $options['timeSleep'] = $opts['timeSleep'];
        }
        return $llm->batch($content, $prompt, $options);
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
        if (isset($this->languages[$lang])) return $this->languages[$lang];
        return 'same language of content';
    }

}
