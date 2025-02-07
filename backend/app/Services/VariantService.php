<?php

namespace App\Services;

use App\Models\Variant;

class VariantService
{
    public function getAll() {
        return Variant::all();
    }

    public function create(array $data): Variant
    {
        $variant = new Variant();
        $variant->resource_id = $data['resource_id'];
        $variant->condition_id = $data['condition_id'];
        if (is_array($data['content'])) $data['content'] = json_encode($data['content']);
        $variant->content = $data['content'];
        $variant->type = $data['type'];
        $variant->label = $data['label'];
        if ($data['proccessing_id']) {
            $variant->proccessing_id = $data['proccessing_id'];
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

    public function update($data) {
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


    public function adaptHTML($jsonHTML, $jsonAdaptation) 
    {
        $output = [];

        if (!$jsonAdaptation) return $jsonHTML;
        
        foreach ($jsonHTML as $idx => $section) {
            $output[] = $this->parseSection($section, $jsonAdaptation[$idx]);
        }

        return $output;
    }

    
    public function parseSection($pageData, $modifications)
    {
    
        foreach ($pageData['blocks'] as &$block) {
            if ($block['type'] === 'text') {
                if (!isset($block['blocks']) || count($block['blocks']) === 0) {
                    continue;
                }

                $fullText = '';
                foreach ($block['blocks'] as $subBlock) {
                    $fullText .= isset($subBlock['content']) ? $subBlock['content'] : '';
                }

                if (!isset($block['original'])) {
                    $block['original'] = $fullText;
                }

                $blockModifications = array_filter($modifications, function ($mod) use ($block) {
                    return $mod['id'] === $block['id'];
                });

                if (count($blockModifications) === 0) {
                    continue;
                }

                usort($blockModifications, function ($a, $b) {
                    return $a['start_position_modification'] <=> $b['start_position_modification'];
                });

                $newText = '';
                $lastIndex = 0;

                foreach ($blockModifications as $mod) {
                    $start = $mod['start_position_modification'];
                    $end = $mod['end_position_modification'];
                    $newText .= mb_substr($fullText, $lastIndex, $start - $lastIndex);
                    $newText .= $mod['modified_text'];
                    $lastIndex = $end;
                }

                $newText .= mb_substr($fullText, $lastIndex);

                if (!isset($block['modified'])) {
                    $block['modified'] = [];
                }

                $newBlock = $block;

                if (count($newBlock['blocks']) === 1) {
                    $newBlock['blocks'][0]['content'] = $newText;
                } else {
                    $newBlock['blocks'] = [
                        [
                            'type'    => 'text',
                            'content' => $newText,
                            'id'      => $newBlock['blocks'][0]['id']
                        ]
                    ];
                }

                unset($newBlock['original'], $newBlock['modified']);

                $block['modified'][] = $newBlock;
            }
        }

        return $pageData;
    }
}