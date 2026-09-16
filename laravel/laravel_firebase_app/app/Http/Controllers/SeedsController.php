<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seed\SeedStoreRequest;
use App\Http\Requests\Seed\SeedUpdateRequest;
use App\Models\Crops;
use App\Models\Seeds;
use Illuminate\Http\Request;

class SeedsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seeds = Seeds::with('crop')->paginate(10);
        return view('seeds.index', compact('seeds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $crops = Crops::all();
        return view('seeds.create', compact('crops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeedStoreRequest $request)
    {
        Seeds::create($request->validated());

        return back()->with('success', 'Seed added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $crops = Crops::all();
        $seed = Seeds::with('crop')->findOrFail($id);
        return view('seeds.show', compact('seed', 'crops'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $seed = Seeds::findOrFail($id);
        $crops = Crops::all();
        return view('seeds.edit', compact('seed', 'crops'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeedUpdateRequest $request, string $id)
    {
        $seed = Seeds::findOrFail($id);
        $seed->update($request->validated());

        return back()->with('success', 'Seed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seed = Seeds::findOrFail($id);
        $seed->status = 'inactive';
        $seed->save();

        return back()->with('success', 'Seed deleted successfully.');
    }

    public function restore(string $id)
    {
        $seed = Seeds::findOrFail($id);
        $seed->status = 'active';
        $seed->save();

        return back()->with('success', 'Seed restored successfully.');
    }
}
