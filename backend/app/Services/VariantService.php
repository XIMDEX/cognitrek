<?php

namespace App\Services;

use App\Models\Variant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VariantService
{
    public function getAll()
    {
        return Variant::all();
    }

    public function create(array $data): Variant
    {
        Log::info('Creating variant: ' . json_encode($data));
        $variant = new Variant();
        $variant->resource_id = $data['resource_id'];
        $variant->condition_id = $data['condition_id'];
        
        // Handle content data
        if (!isset($data['content'])) {
            $data['content'] = json_encode([]);
        }
        
        // If content is an array and contains batch data, extract it
        if (is_array($data['content']) && isset($data['content']['batch'])) {
            $data['content'] = $data['content']['batch'];
        }
        
        // Ensure content is in the desired nested array format
        if (is_array($data['content'])) {
            // If content has numeric keys, wrap it in an array
            $keys = array_keys($data['content']);
            if (is_numeric($keys[0])) {
                $data['content'] = [$data['content']];
            }
            $data['content'] = json_encode($data['content']);
        }
        
        $variant->content = $data['content'];
        $variant->type = $data['type'];
        $variant->label = $data['label'];
        if ($data['proccessing_id']) {
            $variant->proccessing_id = $data['proccessing_id'];
        }else{
            $variant->proccessing_id = null;
        }
        if(isset($data['adaptation_id'])){
            $variant->adaptation_id = $data['adaptation_id'];
        }else if(!isset($data['proccessing_id'])){
            $variant->adaptation_id = (string) Str::uuid();
        }
        if (!isset($data['condition_id'])) {
            $variant->condition_id = (string) Str::uuid();
        }
        $variant->save();

        return $variant;
    }

    public function getByResourceAndCondition(string $resourceId, string $conditionId): ?Variant
    {
        return Variant::where('resource_id', $resourceId)
            ->where('condition_id', $conditionId)
            ->first();
    }

    public function getAllByResourceOrdered(string $resourceId): \Illuminate\Database\Eloquent\Collection
    {
        return Variant::where('resource_id', $resourceId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function delete(string $id): bool
    {
        $variant = Variant::find($id);
        if ($variant) {
            return $variant->delete();
        }
        return false;
    }

    public function getAllByResourceLabel(string $resourceId, string $label)
    {
        return $this->search(['resource_id' => $resourceId, 'label' => $label]);
    }

    public function search(array $data)
    {
        $query = Variant::query();
        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get();
    }

    public function update($data)
    {
        if (!isset($data['id'])) {
            return null;
        }

        $variant = Variant::find($data['id']);

        if (!$variant) {
            return null;
        }

        if (isset($data['resource_id'])) {
            $variant->resource_id = $data['resource_id'];
        }

        if (isset($data['condition_id'])) {
            $variant->condition_id = $data['condition_id'];
        }

        if (isset($data['content'])) {
            if (is_array($data['content'])) {
                $data['content'] = json_encode($data['content']);
            }
            $variant->content = $data['content'];
        }

        if (isset($data['type'])) {
            $variant->type = $data['type'];
        }

        if (isset($data['label'])) {
            $variant->label = $data['label'];
        }

        if (isset($data['proccessing_id'])) {
            $variant->proccessing_id = $data['proccessing_id'];
        }

        $variant->save();
        return $variant;
    }

    public function adaptHTML($jsonHTML, $jsonAdaptation, $condition_label, $condition_id)
    {
        $output = [];

        if (!$jsonAdaptation) return $jsonHTML;

        foreach ($jsonHTML as $idx => $section) {
            $output[] = $this->parseSection($section, $jsonAdaptation[$section['page'] - 1], $condition_label, $condition_id);
        }

        return $output;
    }

    public function parseSection($pageData, $modifications, $condition_label, $condition_id)
    {
        Log::info('VariantService::parseSection', [
            'pageData' => $pageData,
            'modifications' => $modifications,
            'condition_label' => $condition_label,
            'condition_id' => $condition_id,
        ]);

        foreach ($pageData['blocks'] as &$block) {
            $blockType = is_object($block) ? $block->type : $block['type'];
            if ($blockType !== 'text') {
                continue;
            }

            $blocks = is_object($block) ? $block->blocks : $block['blocks'];
            if (!isset($blocks) || count($blocks) === 0) {
                continue;
            }

            $fullText = '';
            foreach ($blocks as $subBlock) {
                $fullText .= isset($subBlock['content']) ? $subBlock['content'] : '';
            }

            $blockModifications = array_filter($modifications, function ($mod) use ($block) {
                $modId = is_object($mod) ? ($mod->id ?? null) : ($mod['id'] ?? null);
                if ($modId === null) return false;
                
                $blockId = null;
                if (is_object($block)) {
                    $blockId = $block->id ?? null;
                } else {
                    $blockId = $block['id'] ?? null;
                }
                
                return $modId === $blockId;
            });

            if (count($blockModifications) === 0) {
                continue;
            }

            if (!isset($block->original)) {
                $block->original = $fullText;
            }

            $block->condition_label = $condition_label;
            $block->condition_id = $condition_id;

            usort($blockModifications, function ($a, $b) {
                return $a['start_position_modification'] <=> $b['start_position_modification'];
            });

            foreach ($blocks as $key => $subBlock) {
                if (array_column($blockModifications, 'id')) {
                    $newText = '';
                    $length_txt_change = 0;
                    
                    if (!isset($block->blocks[$key]->modified)) {
                        $block->blocks[$key]->modified = [];
                    }

                    foreach ($blockModifications as $mod) {
                        if (!isset($mod['type']) && isset($mod['modified_text'])) {
                            $mod['type'] = 'modified';
                        }

                        if ($mod['id'] == $subBlock['id']) {
                            if ($mod['type'] == 'added' || $mod['type'] == 'deleted') {
                                continue;
                            }

                            $start = $mod['start_position_modification'];
                            $end = $mod['end_position_modification'];

                            $txt_raw = mb_substr($subBlock['content'], $start, $end - $length_txt_change);
                            $newText .= mb_substr($subBlock['content'], 0, $start - $length_txt_change);
                            $newText .= $mod['modified_text'];
                            $newText .= mb_substr($subBlock['content'], $end, -1);
                            $length_txt_change += strlen($txt_raw) - strlen($mod['modified_text']);

                            $block->blocks[$key]->action = 'modified';
                            $block->blocks[$key]->original = $block->blocks[$key];
                            $block->blocks[$key]->modified[] = [
                                'action' => 'modified',
                                'start' => $start,
                                'end' => $end,
                                'content' => $mod['modified_text'],
                                'original' => $subBlock['content'],
                                'condition_label' => $condition_label,
                                'condition_id' => $condition_id
                            ];
                            $block->blocks[$key]->condition_label = $condition_label;
                            $block->blocks[$key]->condition_id = $condition_id;
                            break;
                        }
                    }
                }
            }

            if (!isset($block->modified)) {
                $block->modified = [];
            }

            $newBlock = clone $block;

            if (count($newBlock->blocks) === 1) {
                $newBlock->blocks[0]->content = $newText;
            } else {
                $newBlock->blocks = [
                    [
                        'type'    => 'text',
                        'content' => $newText,
                        'id'      => $newBlock->blocks[0]->id
                    ]
                ];
            }

            unset($newBlock->original, $newBlock->modified);

            $block->modified[] = $newBlock;
        }

        return $pageData;
    }

    public function getAdaptations($resourceID)
    {
        try {
            $adaptations = Variant::where('resource_id', $resourceID)->select('label', 'adaptation_id')->distinct()->get();
            return $adaptations;
        } catch (\Exception $exc) {
            return [];
        }
    }
}
