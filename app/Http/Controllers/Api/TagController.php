<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Resources\Tag\TagResource;
use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(
        private TagService $tagService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $tags = $this->tagService->search(
            $request->user(),
            $request->get('q'),
        );

        return response()->json([
            'data' => TagResource::collection($tags),
        ]);
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->create(
            $request->user(),
            $request->validated('title'),
        );

        return response()->json([
            'data' => new TagResource($tag)
        ], 201);
    }
}
