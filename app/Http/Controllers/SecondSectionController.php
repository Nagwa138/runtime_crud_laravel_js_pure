<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecondSectionCreateRequest;
use App\Http\Resources\SectionResource;
use App\Models\SecondSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecondSectionController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $sections = SectionResource::collection(SecondSection::all());
            return response()->json([
                'status' => true,
                'sections' => $sections
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function store(SecondSectionCreateRequest $request): JsonResponse
    {
        try {
            $section = SecondSection::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Good adding !',
                'section' => new SectionResource($section)
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'we have an error ! ' . $exception->getMessage()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function update(SecondSectionCreateRequest $request, SecondSection $secondSection): JsonResponse
    {
        try {
            $secondSection->update($request->validated());
            return response()->json([
                'status' => true,
                'section' => new SectionResource($secondSection),
                'message' => 'Update succeeded!'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'we have an error ! ' . $exception->getMessage()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function destroy(SecondSection $secondSection): JsonResponse
    {
        try {
            $secondSection->delete();
            return response()->json([
                'status' => true,
                'message' => 'Delete succeeded!'
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'we have an error ! ' . $exception->getMessage()
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
