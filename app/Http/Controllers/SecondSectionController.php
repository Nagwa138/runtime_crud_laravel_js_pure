<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionResource;
use App\Models\SecondSection;
use Illuminate\Http\Request;

class SecondSectionController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'sections' => SectionResource::collection(SecondSection::all())
        ]);
    }


    public function store(Request $request)
    {
        $section = SecondSection::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Good adding !',
            'section' => new SectionResource($section)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    public function update(Request $request, SecondSection $secondSection)
    {
        $secondSection->update($request->all());

        return response()->json([
            'status' => true,
            'section' => new SectionResource($secondSection),
            'message' => 'Update succeeded!'
        ]);
    }



    public function destroy(SecondSection $secondSection)
    {
        $secondSection->delete();
        return response()->json([
            'status' => true,
            'message' => 'Delete succeeded!'
        ]);
    }
}
