<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirstSectionCreateRequest;
use App\Http\Requests\FirstSectionUpdateRequest;
use App\Http\Resources\SectionResource;
use App\Models\FirstSection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FirstSectionController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $sections = SectionResource::collection(FirstSection::all());
            return response()->json([
                'status' => true,
                'sections' => $sections
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, we have a technical error error ! '
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function store(FirstSectionCreateRequest $request): JsonResponse
    {
        try {
            $section = FirstSection::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Good adding !',
                'section' => new SectionResource($section)
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, we have a technical error error ! '
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }


    public function update(FirstSectionUpdateRequest $request, FirstSection $firstSection): JsonResponse
    {
        try {
            $firstSection->update($request->all());
            return response()->json([
                'status' => true,
                'section' => new SectionResource($firstSection),
                'message' => 'Update succeeded!'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, we have a technical error error ! '
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function destroy(FirstSection $firstSection): JsonResponse
    {
        try {
            $firstSection->delete();
            return response()->json([
                'status' => true,
                'message' => 'Delete succeeded!'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, we have a technical error error ! '
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
