<?php

namespace App\Jobs;

use App\Exceptions\ServiceNotFoundException;
use App\Helpers\ModuleServiceHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\LlmModule\Services\LLMService;
use Illuminate\Support\Facades\Log;


class ProcessManualBatchJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected string $batchId;
    protected LLMService $llm_service;
    protected array $options;

    public function __construct(
        string $batchId,
        array $options = []
    ) {
        $this->batchId = $batchId;
        $this->options = $options;
    }

    public function handle()
    {
        $folderPath    = "public/adaptations_batches/{$this->batchId}";
        $batchFilePath = "{$folderPath}/batch.jsonl";
        $outputPath    = "{$folderPath}/output.json";

        if (!Storage::exists($batchFilePath)) {
            return;
        }

        $lines = array_filter(explode("\n", Storage::get($batchFilePath)));
        $outputData = Storage::exists($outputPath)
            ? json_decode(Storage::get($outputPath), true)
            : [];

        $this->llm_service = $this->getService('llm_service');


        foreach ($lines as $line) {
            $row = json_decode($line, true);
            if (!$row || empty($row['custom_id'])) {
                continue;
            }

            $customId = $row['custom_id'];
            if (isset($outputData[$customId])) {
                continue;
            }

            try {
                $prompt  = $row['body']['messages'][0]['content'] ?? '';
                $options = $row['body'] ?? [];

                $response = $this->llm_service->call(['prompt' => $prompt, 'options' =>$options, 'path' => null], $this->options['llm_manager']['action']);

                $outputData[$customId] = [
                    'prompt'   => $prompt,
                    'response' => $response,
                    'error'    => false
                ];
            } catch (\Throwable $th) {
                Log::error('Error in ProcessManualBatch.', ['error' => $th->getMessage()]);
                throw $th;
            } finally {
                Storage::put($outputPath, json_encode($outputData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

        }
    }

    public function uniqueId()
    {
        return $this->batchId;
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

}