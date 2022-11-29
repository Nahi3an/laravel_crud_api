<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\V1\SkillResource;
use App\Http\Resources\V1\SkillCollection;
use App\Http\Requests\SkillRequest\StoreSkillRequest;
use App\Http\Requests\SkillRequest\UpdateSkillRequest;

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

        $validatedSkill = $request->validated();

        //$image = $this->saveImage($validatedSkill['image']);

        Skill::create([

            'name' => $validatedSkill['name'],
            'slug' => $validatedSkill['slug'],
            'image' => $this->saveImage($validatedSkill['image'])
        ]);



        return response()->json('Skill Created');
    }


    private function saveImage($image)
    {
        $uploadFolder = 'skills';
        $imageExt = $image->getClientOriginalExtension();
        $imageName = rand() . '.' . $imageExt;
        $image_uploaded_path = $image->storeAs($uploadFolder, $imageName, 'public');
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );
        return  $uploadedImageResponse["image_name"];
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $validatedSkill = $request->validated();



        if ($request->file('image')) {


            unlink(storage_path('app/public/skills/' . $skill->image));
            $image = $this->saveImage($validatedSkill['image']);

            //return $image;
        } else {

            $image = $skill->image;
        }

        $skill->update([

            'name' => $validatedSkill['name'],
            'slug' => $validatedSkill['slug'],
            'image' => $image
        ]);

        return response()->json("Skill Updated");
    }

    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {

        unlink(storage_path('app/public/skills/' . $skill->image));
        $skill->delete();
        return response()->json("Skill Deleted");
    }
}
