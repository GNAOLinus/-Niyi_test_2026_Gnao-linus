<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ShortenLinkRequest;
use App\Models\ShortenedLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortenedLinkController extends Controller
{
    /**
     * Generate a unique random code.
     */
    private function generateUniqueCode(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $length = 6;

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (ShortenedLink::where('code', $code)->exists());

        return $code;
    }

    /**
     * Create a new shortened link.
     * POST /shorten
     */
    public function store(ShortenLinkRequest $request): JsonResponse
    {
        $user = $request->user();

        $code = $request->input('custom_code')
            ? $request->input('custom_code')
            : $this->generateUniqueCode();

        $shortenedLink = ShortenedLink::create([
            'user_id' => $user->id,
            'original_url' => $request->input('original_url'),
            'code' => $code,
            'clicks' => 0,
        ]);

        return response()->json([
            'id' => $shortenedLink->id,
            'user_id' => $shortenedLink->user_id,
            'original_url' => $shortenedLink->original_url,
            'code' => $shortenedLink->code,
            'clicks' => $shortenedLink->clicks,
            'created_at' => $shortenedLink->created_at->toIso8601String(),
        ], 201);
    }

    /**
     * Redirect to the original URL and increment clicks.
     * GET /s/{code}
     */
    public function redirect(string $code): RedirectResponse|JsonResponse
    {
        $shortenedLink = ShortenedLink::where('code', $code)->first();

        if (!$shortenedLink) {
            return response()->json([
                'error' => 'Shortened link not found.',
            ], 404);
        }

        $shortenedLink->increment('clicks');

        return redirect()->to($shortenedLink->original_url);
    }

    /**
     * Get all shortened links for the authenticated user.
     * GET /links
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $links = ShortenedLink::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($link) {
                return [
                    'id' => $link->id,
                    'original_url' => $link->original_url,
                    'code' => $link->code,
                    'clicks' => $link->clicks,
                    'created_at' => $link->created_at->toIso8601String(),
                ];
            });

        return response()->json($links, 200);
    }

    /**
     * Delete a shortened link.
     * DELETE /links/{id}
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $shortenedLink = ShortenedLink::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$shortenedLink) {
            return response()->json([
                'error' => 'Link not found.',
            ], 404);
        }

        $shortenedLink->delete();

        return response()->json([
            'message' => 'Link deleted successfully',
        ], 200);
    }
}
