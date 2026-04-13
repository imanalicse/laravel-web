<?php

namespace App\Http\Controllers\Api;

use App\Ai\Agents\ProductDescriptionAgent;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function generateProductDescription(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'nullable|numeric',
        ]);

        $agent = new ProductDescriptionAgent();

        $prompt = "Write a product description for: {$validated['product_name']}";
        if (!empty($validated['product_price'])) {
            $prompt .= " (priced at \${$validated['product_price']})";
        }

        $response = $agent->prompt($prompt);

        return response()->json([
            'status' => 'success',
            'description' => $response->text,
        ]);
    }

    public function generateDescription(Product $product): \Illuminate\Http\JsonResponse
    {
        $agent = new ProductDescriptionAgent();

        $prompt = "Write a product description for: {$product->name}";
        if ($product->price) {
            $prompt .= " (priced at \${$product->price})";
        }
        if ($product->description) {
            $prompt .= ". Current description for reference: {$product->description}";
        }

        $response = $agent->prompt($prompt);

        return response()->json([
            'status' => 'success',
            'product_id' => $product->id,
            'description' => $response->text,
        ]);
    }
}
