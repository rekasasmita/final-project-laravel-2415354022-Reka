<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController
{
    public function index(): JsonResponse
    {
        $customers = Customer::query()->latest()->get();
        return response()->json(["success" => true, "message" => "Customers retrieved", "data" => $customers]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "customer_id" => ["required", "string", "unique:customers,customer_id"],
            "name" => ["required", "string", "max:255"],
            "email" => ["nullable", "string", "email", "unique:customers,email"],
            "phone" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ]);

        $data["status"] = $data["status"] ?? true;
        $customer = Customer::query()->create($data);

        return response()->json(["success" => true, "message" => "Customer created", "data" => $customer], 201);
    }

    public function show(int $customer): JsonResponse
    {
        $customer = Customer::query()->find($customer);
        if (!$customer) return response()->json(["success" => false, "message" => "Customer not found"], 404);
        
        return response()->json(["success" => true, "message" => "Customer retrieved", "data" => $customer]);
    }

    public function update(Request $request, $customer): JsonResponse
    {
        $customerModel = Customer::query()->find($customer);
        if (!$customerModel) return response()->json(["success" => false, "message" => "Customer not found"], 404);

        $data = $request->validate([
            "customer_id" => ["sometimes", "string", "unique:customers,customer_id," . $customer],
            "name" => ["sometimes", "string", "max:255"],
            "email" => ["nullable", "string", "email", "unique:customers,email," . $customer],
            "phone" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ]);

        $customerModel->update($data);
        return response()->json(["success" => true, "message" => "Customer updated", "data" => $customerModel]);
    }

    public function destroy($customer): JsonResponse
    {
        $customerModel = Customer::query()->find($customer);
        if (!$customerModel) return response()->json(["success" => false, "message" => "Customer not found"], 404);

        if ($customerModel->subscriptions()->exists()) {
            return response()->json(["success" => false, "message" => "Customer cannot be deleted because it has subscriptions"], 422);
        }

        $customerModel->delete();
        return response()->json(["success" => true, "message" => "Customer deleted"]);
    }
}