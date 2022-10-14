<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionResource;
use App\Models\FirstSection;
use Illuminate\Http\Request;

class FirstSectionController extends Controller
{

    public function index()
    {
        return response()->json([
            'status' => true,
            'sections' => SectionResource::collection(FirstSection::all())
        ]);
    }

    public function store(Request $request)
    {
        //return success message and new record

        $section = FirstSection::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Good adding !',
            'section' => new SectionResource($section)
        ]);
    }


    public function update(Request $request, FirstSection $firstSection)
    {
        $firstSection->update($request->all());

        return response()->json([
            'status' => true,
            'section' => new SectionResource($firstSection),
            'message' => 'Update succeeded!'
        ]);
    }


    public function destroy(FirstSection $firstSection)
    {
        $firstSection->delete();
        return response()->json([
            'status' => true,
            'message' => 'Delete succeeded!'
        ]);
    }
}