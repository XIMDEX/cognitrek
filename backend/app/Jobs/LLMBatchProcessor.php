<?php

namespace App\Jobs;

use App\Exceptions\ServiceNotFoundException;
use App\Helpers\ModuleServiceHelper;
use App\Services\ConditionService;
use App\Services\VariantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\LlmModule\Services\LLMService;

class LLMBatchProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Parameters for adaptation generation.
     *
     * @var array
     */
    protected $params;

    /**
     * The LLM Service instance.
     *
     * @var LLMService
     */
    protected $llmService;

    /**
     *
     * @var string
     */
    protected $serviceAlias;

    /**
     * The Variant Service instance.
     *
     * @var VariantService
     */
    protected $variantService;

    /**
     * The Variant Service instance.
     *
     * @var ConditionService
     */
    protected $conditionService;

    /**
     * Create a new job instance.
     *
     * @param  string  $serviceAlias
     * @param  array   $params
     */
    public function __construct($serviceAlias, array $params)
    {
        $this->params = $params;
        $this->serviceAlias = $serviceAlias;
    }


    /**
     * Execute the job.
     */
    public function handle()
    {
        try {

            $this->llmService = $this->getService($this->serviceAlias);
            $this->variantService = app(VariantService::class);
            $this->conditionService = app(ConditionService::class);

            $data_params = $this->params['data'];
            $action = $data_params['action'];
            $lang = $data_params['lang'];
            $resourceID = $data_params['id'];
            $damID = $data_params['dam_id'];
            $validated = $this->params['validated'];

            $done = $this->variantService->getAllByResourceLabel($resourceID, $validated['label']);

            $doing = $done->reject(function($item) {
                return !$item->proccessing_id;
            });

            $done = $done->filter(function($item) {
                return !$item->proccessing_id;
            });

            $doing_ids = $doing->pluck('condition_id')->toArray();
            $done_ids = $done->pluck('condition_id')->toArray();

            $ids_to_not_proccess = array_merge($doing_ids, $done_ids);

            $todo = array_filter($validated['conditions'], function($item) use ($ids_to_not_proccess) {
                return !in_array($item, $ids_to_not_proccess);
            });

            if (!Storage::exists('public/'.$damID.'/raw.json')) {
                $this->fail('Resource JSON file not found');
            }

            $data = Storage::json('public/'.$damID.'/raw.json');
            $json_pages = [];

            foreach ($data['sections'] as $section) {
                $page = ['page' => $section['page'], 'blocks' => []];
                foreach ($section['blocks'] as $block) {
                    if ($block['type'] === 'text') {
                        $page['blocks'][] = $block;
                    }
                }
                $json_pages[] = $page;
            }

            $data = $json_pages;
            foreach ($done as $variant) {
                if ($variant->proccessing_id) continue;
                $content = json_decode($variant->content);
                $condition_label = $this->conditionService->getById($variant->condition_id);
                $data = $this->variantService->adaptHTML($data, $content, $condition_label, $variant->condition_id);
            }

            foreach ($doing as $item) {
                $content = json_decode($item->content, true);
                if (count($content) == 0) {
                    $content = array_merge($data_params, ['opts' => $data_params]);
                    $content['data']['resource'] = $data;
                    $condition = $this->conditionService->getById($item->condition_id);
                    $content['data']['prompt'] = $condition->type;
                    $content['opts']['maxAttempts'] = 5;
                    $content['opts']['timeSleep'] = 60;
                    $content['data']['id'] = $item->proccessing_id;
                } else {
                    $content['data']['resource'] = $data;
                    $content['opts']['maxAttempts'] = 5;
                    $content['opts']['timeSleep'] = 60;
                    $content['data']['id'] = $item->proccessing_id;
                }
                $output = $this->useService($this->serviceAlias, $content);
                if ($output['id'] && !$output['error']) {
                    $this->variantService->update([
                        'proccessing_id' => $output['batch_id'] ?? $output['id'],
                        'content' => $output['content'],
                        'id' => $item->id
                    ]);
                    throw new \Exception('Adaptation generation is still processing.');
                } elseif ($output['error'] && !$output['id']) {
                    $item_content = $this->params;
                    $item_content['error'] = true;
                    $this->variantService->update([
                        'proccessing_id' => -1,
                        'content' => $item_content,
                        'id' => $item->id
                    ]);
                    $this->fail(new \Exception('Adaptation generation failed.'));
                    throw new \Error('Batch failed');
                } else {
                    $this->variantService->update([
                        'proccessing_id' => null,
                        'content' => $output['content'],
                        'id' => $item->id
                    ]);
                    Log::info('Adaptation generation completed.', []);
                }
            }

            $conditions = $this->conditionService->getManyByIds($todo);
            foreach ($conditions as $condition) {
                $output;
                try {
                    $params = array_merge($data_params, ['opts' => $data_params]);
                    $params['data']['resource'] = $data;
                    $params['data']['prompt'] = $condition->type;
                    $content['opts']['maxAttempts'] = 5;
                    $content['opts']['timeSleep'] = 60;

                    $output = $this->useService($this->serviceAlias, $params);

                    $adaptation = $this->variantService->search(['resource_id' => $resourceID, 'label' => $validated['label']])->first();

                    $params['data']['resource'] = [];
                    $data_variant = [
                        'resource_id' => $resourceID,
                        'condition_id' => $condition->id,
                        'content' => $params,
                        'type' => 'content',
                        'proccessing_id' => null,
                        'label' => $validated['label'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $data_variant['adaptation_id'] = $adaptation && isset($adaptation->adaptation_id) ? $adaptation->adaptation_id : Str::uuid();

                    if ($output['id'] && !$output['error']) {
                        $data_variant['proccessing_id'] = $output['batch_id'] ?? $output['id'];
                        if (isset($output['batch'])) {
                            $data_variant['content']['batch'] = $output['batch'];
                        }
                        $v = $this->variantService->create($data_variant);
                        throw new \Exception('Adaptation generation is still processing.');
                    } elseif ($output['error'] && !$output['id']) {
                        $this->fail(new \Exception('Adaptation generation failed.'));
                        throw new \Error('Batch failed');
                    } else {
                        $data_variant['proccessing_id'] = null;
                        $v = $this->variantService->create($data_variant);
                        Log::info('Adaptation generation completed.', []);
                    }

                } catch (\Exception $exc) {
                    throw $exc;
                }
            }

        } catch (\Exception $e) {
                Log::error('Error in LLMBatchAdaptationProcessor.', ['error' => $e->getMessage()]);
                throw $e;
        }
    }

    /**
     * Define a retry time limit
     */
    public function retryUntil()
    {
        return now()->addHours(48);
    }

    /**
     * Configure retry backoff intervals
     */
    public function backoff()
    {
        return 1800;
    }

    private function getService($alias)
    {

        try {
            $moduleService = ModuleServiceHelper::getService($alias);
            return $moduleService;
        } catch (ServiceNotFoundException $e) {
            return $this->fail(new \Exception('Adaptation generation failed.'));
        }
    }


    public function useService($serviceName, $params)
    {
        try {
            $moduleService = ModuleServiceHelper::getService($serviceName);

            if ($moduleService) {
                return $moduleService->performAction($params);
            }
        } catch (ServiceNotFoundException $e) {
            return $this->fail(new \Exception('Adaptation generation failed.'));
        }
    }
}
