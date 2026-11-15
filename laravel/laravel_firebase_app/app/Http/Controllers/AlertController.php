<?php

namespace App\Http\Controllers;

use App\Http\Requests\Alert\AlertRequest;
use App\Jobs\SendNotificationJob;
use App\Models\Alert;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(): View
    {
        $alerts = Alert::withTrashed()->with('creator')->latest()->get();

        return view('alerts.index', compact('alerts'));
    }

    public function create(): View
    {
        return view('alerts.create');
    }

    public function store(AlertRequest $request): RedirectResponse
    {
        $alert = Alert::create([
            ...$request->validated(),
            'created_by' => auth('web')->id(),
        ]);

        // SendNotificationJob::dispatch($alert->title_en, $alert->description_en, $alert->title_hi, $alert->description_hi);

        return redirect()->route('alerts.index')->with('success', 'Alert created successfully.');
    }

    public function show(string $id): View
    {
        $alert = Alert::withTrashed()->with('creator', 'updater')->findOrFail($id);

        return view('alerts.show', compact('alert'));
    }

    public function update(AlertRequest $request, string $id): RedirectResponse
    {
        $alert = Alert::findOrFail($id);
        $alert->update([
            ...$request->validated(),
            'updated_by' => auth('web')->id(),
        ]);

        return back()->with('success', 'Alert updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $alert = Alert::findOrFail($id);
        $alert->update(['status' => false]);
        $alert->delete();

        return back()->with('success', 'Alert deleted successfully.');
    }

    public function restore(string $id): RedirectResponse
    {
        $alert = Alert::withTrashed()->findOrFail($id);
        $alert->restore();
        $alert->update(['status' => true]);

        return back()->with('success', 'Alert restored successfully.');
    }
}
