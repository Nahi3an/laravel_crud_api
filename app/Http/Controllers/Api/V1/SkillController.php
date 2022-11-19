<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest\StoreSkillRequest;
use App\Http\Resources\V1\SkillCollection;
use App\Http\Resources\V1\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    //

    public function index()
    {

        //One Way of Showing all Skills => Resource Collection
        //return SkillResource::collection(Skill::all()); // or, Skill::paginate(value)

        //Another way of showing all Skills => Collection
        return new SkillCollection(Skill::all());
    }

    public function store(StoreSkillRequest $request)
    {

        Skill::create($request->validated());
        return response()->json("Skill Created");
    }

    public function update(StoreSkillRequest $request, Skill $skill)
    {

        $skill->update($request->validated());
        return response()->json("Skill Updated");
    }

    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {

        $skill->delete();
        return response()->json("Skill Deleted");
    }
}
