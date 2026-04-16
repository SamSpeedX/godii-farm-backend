<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CowController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cows = Cow::where('user_id', $request->user()->id)
                ->latest()
                ->get();

            return response()->json([
                "status" => "success",
                "data" => $cows,
                "cows" => $cows->count(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch cows",
                "error" => $th->getMessage()
            ]);
        }
    }

    // ➕ Create cow
    public function store(Request $request)
    {
        try {
            $request->validate([
                "tag" => "required|string|max:100",
                "name" => "required|string|max:255",
                "breed" => "nullable|string|max:255",
                "age" => "nullable|integer|min:0",
                "gender" => "required|string|max:100",
                "weight" => "nullable|numeric|min:0",
                "health" => "nullable|in:Healthy,Monitoring,Sick",
                "last_checkup" => "nullable|date",
            ]);

            $cow = Cow::create([
                "user_id" => $request->user()->id,
                "tag" => $request->tag,
                "name" => $request->name,
                "breed" => $request->breed,
                "age" => $request->age ?? 0,
                "gender" => $request->gender,
                "weight" => $request->weight ?? 0,
                "health" => $request->health ?? "Healthy",
                "last_checkup" => $request->last_checkup ?? now(),
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Cow created successfully",
                "data" => $cow,
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to create cow",
                "error" => $th->getMessage(),
                "user" => $request->user(),
            ]);
        }
    }

    // 🔍 Show single cow
    public function show($id)
    {
        try {
            $cow = Cow::where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                "status" => "success",
                "data" => $cow
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Cow not found",
                "error" => $th->getMessage()
            ], 404);
        }
    }

    // ✏️ Update cow
    public function update(Request $request, $id)
    {
        try {
            $cow = Cow::where('user_id', Auth::id())
                ->findOrFail($id);

            $request->validate([
                "tag" => "sometimes|string|max:100",
                "name" => "sometimes|string|max:255",
                "breed" => "nullable|string|max:255",
                "age" => "nullable|integer|min:0",
                "weight" => "nullable|numeric|min:0",
                "health" => "nullable|in:Healthy,Monitoring,Sick",
                "last_checkup" => "nullable|date",
            ]);

            $cow->update($request->only([
                "tag",
                "name",
                "breed",
                "age",
                "weight",
                "health",
                "last_checkup"
            ]));

            return response()->json([
                "status" => "success",
                "message" => "Cow updated successfully",
                "data" => $cow
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to update cow",
                "error" => $th->getMessage()
            ]);
        }
    }

    // ❌ Delete cow
    public function destroy($id)
    {
        try {
            $cow = Cow::where('user_id', Auth::id())
                ->findOrFail($id);

            $cow->delete();

            return response()->json([
                "status" => "success",
                "message" => "Cow deleted successfully"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to delete cow",
                "error" => $th->getMessage()
            ]);
        }
    }
}
