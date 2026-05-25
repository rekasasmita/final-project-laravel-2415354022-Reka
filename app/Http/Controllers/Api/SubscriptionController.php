<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController
{
    public function index(): JsonResponse
    {
        $subscriptions = Subscription::with(['customer', 'service'])->latest()->get();
        return response()->json(["success" => true, "message" => "Subscriptions retrieved", "data" => $subscriptions]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "customer_id" => ["required", "integer", "exists:customers,id"],
            "service_id" => ["required", "integer", "exists:services,id"],
            "start_date" => ["nullable", "date"],
            "end_date" => ["nullable", "date", "after_or_equal:start_date"],
            "status" => ["required", "string", "in:active,inactive,trial,isolir,dismantle"],
        ]);

        $subscription = Subscription::query()->create($data);

        return response()->json(["success" => true, "message" => "Subscription created", "data" => $subscription], 201);
    }

    public function show(int $subscription): JsonResponse
    {
        $subscriptionModel = Subscription::with(['customer', 'service'])->find($subscription);
        if (!$subscriptionModel) return response()->json(["success" => false, "message" => "Subscription not found"], 404);

        return response()->json(["success" => true, "message" => "Subscription retrieved", "data" => $subscriptionModel]);
    }

    public function update(Request $request, $subscription): JsonResponse
    {
        $subModel = Subscription::query()->find($subscription);
        if (!$subModel) return response()->json(["success" => false, "message" => "Subscription not found"], 404);

        $data = $request->validate([
            "start_date" => ["nullable", "date"],
            "end_date" => ["nullable", "date", "after_or_equal:start_date"],
            "status" => ["sometimes", "string", "in:active,inactive,trial,isolir,dismantle"],
        ]);

        if ($subscription->status === 'dismantle') {
        return response()->json([
            'success' => false,
            'message' => 'Dismantled subscription cannot be changed'
        ], 422);
    }

    $subscription->update($request->all());

    return response()->json([
        'success' => true,
        'data' => $subscription
    ]);
    $subModel->update($data);
    return response()->json(["success" => true, "message" => "Subscription updated", "data" => $subModel]);

    }

    public function destroy(int $subscription): JsonResponse
    {
        $subModel = Subscription::query()->find($subscription);
        if (!$subModel) return response()->json(["success" => false, "message" => "Subscription not found"], 404);

        $subModel->delete();
        return response()->json(["success" => true, "message" => "Subscription deleted"]);
    }
}