<?php

namespace App\Http\Controllers;

use App\Http\Requests\Crop\CropStoreRequest;
use App\Http\Requests\Crop\CropUpdateRequest;
use App\Models\Crops;
use Illuminate\Http\Request;

class CropsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crops = Crops::paginate(10);
        return view('crops.index', compact('crops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CropStoreRequest $request)
    {
        if ($request->hasFile('crop_image')) {
            $image = $request->file('crop_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/crops'), $imageName);
        }

        Crops::create([
            'crop_name' => $request->input('crop_name'),
            'crop_season' => $request->input('crop_season'),
            'crop_type' => $request->input('crop_type'),
            'variety' => $request->input('variety'),
            'sowing_method' => $request->input('sowing_method'),
            'irrigation' => $request->input('irrigation'),
            'fertilizers' => $request->input('fertilizers'),
            'plant_protection' => $request->input('plant_protection'),
            'deficiency' => $request->input('deficiency'),
            'weeds' => $request->input('weeds'),
            'advisory' => $request->input('advisory'),
            'crop_image' => $imageName ?? null,
        ]);

        return back()->with('success', 'Crop added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Crops::findOrFail($id);
        return view('crops.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CropUpdateRequest $request, string $id)
    {
        $crop = Crops::findOrFail($id);

        if ($request->hasFile('crop_image')) {
            $image = $request->file('crop_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/crops'), $imageName);
        } else {
            $imageName = $crop->crop_image;
        }

        $crop->update([
            'crop_name' => $request->input('crop_name'),
            'crop_season' => $request->input('crop_season'),
            'crop_type' => $request->input('crop_type'),
            'variety' => $request->input('variety'),
            'sowing_method' => $request->input('sowing_method'),
            'irrigation' => $request->input('irrigation'),
            'fertilizers' => $request->input('fertilizers'),
            'plant_protection' => $request->input('plant_protection'),
            'deficiency' => $request->input('deficiency'),
            'weeds' => $request->input('weeds'),
            'advisory' => $request->input('advisory'),
            'crop_image' => $imageName ?? null,
        ]);

        return back()->with('success', 'Crop updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $crop = Crops::findOrFail($id);
        $crop->status = 'inactive';
        $crop->save();

        return back()->with('success', 'Crop deleted successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $crop = Crops::findOrFail($id);
        $crop->status = 'active';
        $crop->save();

        return back()->with('success', 'Crop restored successfully.');
    }
}
