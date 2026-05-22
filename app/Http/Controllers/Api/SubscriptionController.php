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
        // Mengambil data subscription sekalian dengan data user dan service-nya
        $subscriptions = Subscription::with(['user', 'service'])->latest()->get();
        return response()->json(["success" => true, "message" => "Subscriptions retrieved", "data" => $subscriptions]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "user_id" => ["required", "integer", "exists:users,id"],
            "service_id" => ["required", "integer", "exists:services,id"],
            "status" => ["nullable", "string", "in:active,expired,cancelled"],
        ]);

        $subscription = Subscription::query()->create($data);

        return response()->json(["success" => true, "message" => "Subscription created", "data" => $subscription], 201);
    }

    public function show(int $subscription): JsonResponse
    {
        $subscription = Subscription::with(['user', 'service'])->find($subscription);
        if (!$subscription) return response()->json(["success" => false, "message" => "Subscription not found"], 404);

        return response()->json(["success" => true, "message" => "Subscription retrieved", "data" => $subscription]);
    }

    public function update(Request $request, int $subscription): JsonResponse
    {
        $subModel = Subscription::query()->find($subscription);
        if (!$subModel) return response()->json(["success" => false, "message" => "Subscription not found"], 404);

        $data = $request->validate([
            "status" => ["required", "string", "in:active,expired,cancelled"],
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