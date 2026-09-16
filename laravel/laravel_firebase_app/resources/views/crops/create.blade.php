@extends('layouts.dashboard')

@section('page')
    Add Crop
@endsection

@section('content')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-leaf" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Add Crop</h1>
                        <p class="text-muted mb-0">Create a new Crop with season & type.</p>
                    </div>
                </div>
                <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm"
                        href="{{ route('crops.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Crops List</a>
                </div>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-8">
                    <form class="panel needs-validation" novalidate action="{{ route('crops.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-leaf" aria-hidden="true"></i><span>Crop
                                        Details</span></h2>
                                <p class="text-muted mb-0">Create a new crop with the following information.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="crop_name">Crop Name</label><input
                                    class="form-control" id="crop_name" name="crop_name" type="text"
                                    value="{{ old('crop_name') }}" required>
                                <div class="invalid-feedback">Crop name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="crop_season">Season</label>
                                <select name="crop_season" id="crop_season" class="form-control" required>
                                    <option value="">Select a season</option>
                                    <option value="Kharif" {{ old('crop_season') == 'Kharif' ? 'selected' : '' }}>Kharif
                                        Season
                                    </option>
                                    <option value="Rabi" {{ old('crop_season') == 'Rabi' ? 'selected' : '' }}>Rabi Season
                                    </option>
                                    <option value="Zaid" {{ old('crop_season') == 'Zaid' ? 'selected' : '' }}>Zaid Season
                                    </option>
                                    <option value="Off Season" {{ old('crop_season') == 'Off Season' ? 'selected' : '' }}>
                                        Off
                                        Season</option>
                                </select>
                                <div class="invalid-feedback">Season is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="crop_type">Crop Type</label><input
                                    class="form-control" id="crop_type" name="crop_type" type="text"
                                    value="{{ old('crop_type') }}" required>
                                <div class="invalid-feedback">Crop type is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="variety">Variety</label>
                                <textarea class="form-control" id="variety" name="variety" rows="3" required>{{ old('variety') }}</textarea>
                                <div class="invalid-feedback">Variety is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="sowing_method">Sowing Method</label>
                                <textarea class="form-control" id="sowing_method" name="sowing_method" rows="3" required>{{ old('sowing_method') }}</textarea>
                                <div class="invalid-feedback">Sowing method is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="irrigation">Irrigation</label>
                                <textarea class="form-control" id="irrigation" name="irrigation" rows="3" required>{{ old('irrigation') }}</textarea>
                                <div class="invalid-feedback">Irrigation information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="fertilizers">Fertilizers</label>
                                <textarea class="form-control" id="fertilizers" name="fertilizers" rows="3" required>{{ old('fertilizers') }}</textarea>
                                <div class="invalid-feedback">Fertilizer information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="plant_protection">Plant Protection</label>
                                <textarea class="form-control" id="plant_protection" name="plant_protection" rows="3" required>{{ old('plant_protection') }}</textarea>
                                <div class="invalid-feedback">Plant protection information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="deficiency">Deficiency</label>
                                <textarea class="form-control" id="deficiency" name="deficiency" rows="3" required>{{ old('deficiency') }}</textarea>
                                <div class="invalid-feedback">Deficiency information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="weeds">Weeds</label>
                                <textarea class="form-control" id="weeds" name="weeds" rows="3" required>{{ old('weeds') }}</textarea>
                                <div class="invalid-feedback">Weed information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="advisory">Advisory</label>
                                <textarea class="form-control" id="advisory" name="advisory" rows="3" required>{{ old('advisory') }}</textarea>
                                <div class="invalid-feedback">Advisory information is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="crop_image">Upload Crop Image</label>
                                <input class="form-control" id="crop_image" name="crop_image" type="file"
                                    accept=".png,.jpg,.jpeg">
                                <div class="invalid-feedback">Invalid Image Format.</div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4"><a class="btn btn-outline-secondary"
                                href="users.html">Cancel</a><button class="btn btn-primary" type="submit"><i
                                    class="bi bi-leaf" aria-hidden="true"></i> Add Crop</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="panel h-100">
                        <h2 class="h5 mb-3 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Crops
                                Checklist</span></h2>
                        <div class="activity-list">
                            <div class="activity-item"><span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Fill Details</p>
                                    <p class="text-muted small mb-0">All details are mandatory.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Image is optional</p>
                                    <p class="text-muted small mb-0">Only png, jpg, and jpeg images are allowed.</p>
                                </div>
                            </div>

                            <div class="activity-item"><span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Avoid Duplicates</p>
                                    <p class="text-muted small mb-0">Ensure the crop name is unique.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection
