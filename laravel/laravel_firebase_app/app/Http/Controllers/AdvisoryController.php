<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advisory\AdvisoryRequest;
use App\Jobs\SendNotificationJob;
use App\Models\Advisory;

class AdvisoryController extends Controller
{
    public function index()
    {
        $advisories = Advisory::withTrashed()->with('creator')->get();

        return view('advisories.index', compact('advisories'));
    }

    public function create()
    {
        return view('advisories.create');
    }

    public function store(AdvisoryRequest $request)
    {
        $advisory = Advisory::create([
            ...$request->validated(),
            'created_by' => auth('web')->id(),
        ]);

        // SendNotificationJob::dispatch($advisory->title_en, $advisory->description_en, $advisory->title_hi, $advisory->description_hi);

        return redirect()
            ->back()
            ->with('success', 'Advisory created successfully.');
    }

    public function show(string $id)
    {
        $advisory = Advisory::withTrashed()->with('creator', 'updater')->findOrFail($id);

        return view('advisories.show', compact('advisory'));
    }

    public function update(AdvisoryRequest $request, string $id)
    {
        $advisory = Advisory::findOrFail($id);

        $advisory->update([
            ...$request->validated(),
            'updated_by' => auth('web')->id(),
        ]);

        return back()->with('success', 'Advisory updated successfully.');
    }

    public function destroy(string $id)
    {
        $advisory = Advisory::findOrFail($id);
        $advisory->update(['status' => false]);
        $advisory->delete();

        return back()->with('success', 'Advisory deleted successfully.');
    }

    public function restore(string $id)
    {
        $advisory = Advisory::withTrashed()->findOrFail($id);
        $advisory->restore();
        $advisory->update(['status' => true]);

        return back()->with('success', 'Advisory restored successfully.');
    }
}
