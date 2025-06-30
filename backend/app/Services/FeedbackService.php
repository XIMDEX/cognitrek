<?php

namespace App\Services;

use App\Models\Feedback;

class FeedbackService
{

    public function create(array $data): Feedback
    {
        $feedback = new Feedback();
        $feedback->variant_id = $data['variant_id'];
        $feedback->user_id = $data['user_id'];
        $feedback->score = $data['score'];
        $feedback->created_at = now();
        $feedback->updated_at = now();
        $feedback->save();

        return $feedback;
    }
    
    public function getFeedback($variantID)
    {
        $feedback = Feedback::where('variant_id', $variantID)->get();
        if ($feedback) {
            return $feedback;
        }
        return [];
    }

    public function getFeedbackByUser($variantID, $userHash)
    {
        $feedback = Feedback::where('variant_id', $variantID)
            ->where('user_id', $userHash)
            ->first();
        
        if ($feedback) {
            return $feedback;
        }
        return [];
    }

    public function getFeedbackByUserAndVariant($variantID, $userHash)
    {
        $feedback = Feedback::where('variant_id', $variantID)
            ->where('user_id', $userHash)
            ->first();
        
        if ($feedback) {
            return $feedback;
        }
        return [];
    }

    public function updateFeedback($variantID, $userHash, $score)
    {
        $feedback = Feedback::where('variant_id', $variantID)
            ->where('user_id', $userHash)
            ->first();
        
        if ($feedback) {
            $feedback->score = $score;
            $feedback->save();
            return $feedback;
        }
        return [];
    }

    public function deleteFeedback($variantID, $userHash)
    {
        $feedback = Feedback::where('variant_id', $variantID)
            ->where('user_id', $userHash)
            ->first();
        
        if ($feedback) {
            $feedback->delete();
            return true;
        }
        return false;
    }
} 