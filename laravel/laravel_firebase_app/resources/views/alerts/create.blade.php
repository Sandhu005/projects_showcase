@extends('layouts.dashboard')

@section('page')
    Create Alert
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Create Alert</h1>
                        <p class="text-muted mb-0">Create a new alert for farmers.</p>
                    </div>
                </div>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('alerts.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to Alerts</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-8">
                    <form class="panel" action="{{ route('alerts.store') }}" method="post">
                        @csrf
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><span>Alert Details</span></h2>
                                <p class="text-muted mb-0">Set the alert message, location, and validity period.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="title_en">English Title</label>
                                <input class="form-control" id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="title_hi">Hindi Title</label>
                                <input class="form-control" id="title_hi" name="title_hi" value="{{ old('title_hi') }}" required>
                            </div>
                            {{-- <div class="col-md-6"><label class="form-label" for="state">State</label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select a state</option>
                                    <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh
                                    </option>
                                    <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand
                                    </option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div> --}}
                            <div class="col-md-6">
                                <label class="form-label" for="valid_from">Valid From</label>
                                <input class="form-control" id="valid_from" name="valid_from" type="date" value="{{ old('valid_from') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="valid_until">Valid Until</label>
                                <input class="form-control" id="valid_until" name="valid_until" type="date" value="{{ old('valid_until') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description_en">English Description</label>
                                <textarea class="form-control" id="description_en" name="description_en" rows="4" required>{{ old('description_en') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description_hi">Hindi Description</label>
                                <textarea class="form-control" id="description_hi" name="description_hi" rows="4" required>{{ old('description_hi') }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a class="btn btn-outline-secondary" href="{{ route('alerts.index') }}">Cancel</a>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-plus-lg" aria-hidden="true"></i> Create Alert</button>
                        </div>
                    </form>
                </div>
                 <div class="col-12 col-xl-4">
                    <div class="panel h-100">
                        <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Alert
                                Checklist</span></h2>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Fill Details</p>
                                    <p class="text-muted small mb-0">Title and description are mandatory.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Valid From is optional</p>
                                    <p class="text-muted small mb-0">You can select valid from if you want to send advisroy from a specific date.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Valid Until is optional</p>
                                    <p class="text-muted small mb-0">You can select valid until if you want to end advisroy on a specific date.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection