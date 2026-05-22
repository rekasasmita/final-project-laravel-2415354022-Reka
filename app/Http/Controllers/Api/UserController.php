<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function index(): JsonResponse
    {
        $users = User::query()->latest()->get();
        return response()->json(["success" => true, "message" => "Users retrieved", "data" => $users]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "unique:users,email"],
            "password" => ["required", "string", "min:6"],
        ]);

        $data["password"] = Hash::make($data["password"]);
        $user = User::query()->create($data);

        return response()->json(["success" => true, "message" => "User created", "data" => $user], 201);
    }

    public function show(int $user): JsonResponse
    {
        $user = User::query()->find($user);
        if (!$user) return response()->json(["success" => false, "message" => "User not found"], 404);

        return response()->json(["success" => true, "message" => "User retrieved", "data" => $user]);
    }

    public function update(Request $request, int $user): JsonResponse
    {
        $userModel = User::query()->find($user);
        if (!$userModel) return response()->json(["success" => false, "message" => "User not found"], 404);

        $data = $request->validate([
            "name" => ["sometimes", "string", "max:255"],
            "email" => ["sometimes", "string", "email", "unique:users,email," . $user],
        ]);

        $userModel->update($data);
        return response()->json(["success" => true, "message" => "User updated", "data" => $userModel]);
    }

    public function destroy(int $user): JsonResponse
    {
        $userModel = User::query()->find($user);
        if (!$userModel) return response()->json(["success" => false, "message" => "User not found"], 404);

        $userModel->delete();
        return response()->json(["success" => true, "message" => "User deleted"]);
    }
}