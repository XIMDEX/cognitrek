<?php

namespace App\Http\Controllers;

use App\Services\FeedbackService;
use App\Services\VariantService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected $feedbackService;
    protected $variantService;

    public function __construct(FeedbackService $feedbackService, VariantService $variantService)
    {
        $this->feedbackService = $feedbackService;
        $this->variantService = $variantService;
    }

    public function createFeedback(Request $request)
    {
        // check score is flat with max 2 decimal places and between 0 and 5
        $validated = $request->validate([
            'variant_id' => 'required',
            'user_id' => 'required',
            'score' => 'required|numeric|between:0,5'
        ]);

        $feedback = $this->feedbackService->create($validated);
        return response()->json($feedback);
    }

    public function getFeedback($variantID)
    {
        $feedback = $this->feedbackService->getFeedback($variantID);
        $feedback->user_id = $this->useService('anonymizer_service', ['action' => 'decode', 'value' => $feedback->user_id]);
        return response()->json($feedback);
    }

    public function getFeedbackResource(Request $request, $resourceID)
    {
        $variants = $this->variantService->getAllByResourceOrdered($resourceID);

        $output = [];
        foreach ($variants as $variant) {
            $feedbacks = $this->feedbackService->getFeedback($variant->id);
            if (count($feedbacks)>0) {
                foreach ($feedbacks as $feedback) {
                    $feedback->user_id = $this->useService('anonymizer_service', ['action' => 'decode', 'value' => $feedback->user_id]);
                    $output[] = $feedback;
                }
            }
        }


        return response()->json($output);
    }

    public function getFeedbackResourceByUser(Request $request, $resourceID, $userID)
    {
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $variants = $this->variantService->getAllByResourceOrdered($resourceID);

        $feedbacks = [];
        foreach ($variants as $variant) {
            $feedback = $this->feedbackService->getFeedbackByUser($variant->id, $userHash);
            $feedback->user_id = $this->useService('anonymizer_service', ['action' => 'decode', 'value' => $feedback->user_id]);
            $feedbacks[] = $feedback;
        }

        return response()->json($feedback);
    }
    

    public function getFeedbackByUser($variantID, $userID)
    {
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $feedback = $this->feedbackService->getFeedbackByUser($variantID, $userHash);

        if (!$feedback) {
            return response()->json([]);
        }

        return response()->json($feedback);
    }

    public function getFeedbackByUserAndVariant($variantID, $userID)
    {
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $feedback = $this->feedbackService->getFeedbackByUserAndVariant($variantID, $userHash);

        if (!$feedback) {
            return response()->json([]);
        }
        return response()->json($feedback);
    }

    public function updateFeedback(Request $request, $variantID, $userID)
    {
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $validated = $request->validate([
            'score' => 'required|numeric|between:0,5'
        ]);

        $feedback = $this->feedbackService->updateFeedback($variantID, $userHash, $validated['score']);

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found']);
        }

        return response()->json($feedback);
    }

    public function deleteFeedback($variantID, $userID)
    {
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $feedback = $this->feedbackService->getFeedbackByUserAndVariant($variantID, $userHash);
        if ($feedback) {
            $feedback->delete();
            return response()->json(['message' => 'Feedback deleted']);
        }
        return response()->json(['message' => 'Feedback not found']);
    }
}
