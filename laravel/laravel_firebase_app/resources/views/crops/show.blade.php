@extends('layouts.dashboard')

@section('page')
    Crop Details
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-leaf-fill" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Management</p>
                        <h1 class="h3 mb-1">Crop Details</h1>
                        <p class="text-muted mb-0">Inspect crop information, details, and related data.
                        </p>
                    </div>
                </div>

                <div class="heading-actions">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('crops.index') }}"><i
                            class="bi bi-arrow-left" aria-hidden="true"></i> Back to
                        Crops List</a>

                    @can('manage crops')
                        <a class="btn btn-primary btn-sm" href="{{ route('crops.create') }}"><i class="bi bi-plus"
                                aria-hidden="true"></i> Add Crop</a>
                    @endcan
                </div>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="row g-3">
                <div class="col-12 col-xl-4">
                    <div class="panel h-100 text-center profile-card">
                        <div class="profile-cover"><img src="{{ url('images/png/dasher-ui-bootstrap-5.jpg') }}"
                                alt="User workspace preview"></div>
                        <div class="profile-hero">
                            <img class="avatar-img avatar-xl profile-photo"
                                src="{{ url('images/crops/' . $data->crop_image) }}" alt="{{ $data->crop_name }}">
                            <h2 class="h5 mb-1">{{ $data->crop_name }}</h2>
                            {{-- <p class="text-muted mb-3">{{ $data->crop_season }}</p> --}}
                            @if ($data->status === 'active')
                                <span class="badge text-bg-success">Active</span>
                            @else
                                <span class="badge text-bg-danger">Inactive</span>
                            @endif

                            <div class="info-list mt-4 text-start">
                                <div><span>Season</span><strong>{{ $data->crop_season }}</strong></div>
                                <div><span>Type</span><strong>{{ $data->crop_type }}</strong></div>
                                <div><span>Created at</span><strong>{{ $data->created_at->format('M j, Y') }}</strong></div>
                                <div><span>Updated at</span><strong>{{ $data->updated_at->format('M j, Y') }}</strong>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    {{-- <div class="panel mb-3">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-leaf-fill"
                                        aria-hidden="true"></i><span>Crop Overview</span></h2>
                                <p class="text-muted mb-0">Inspect crop information, details, and related data.</p>
                            </div>

                            @can('manage crops')
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#formModal">Edit Crop</button>
                            @endcan

                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mini-card">
                                    <span>Season</span><strong>{{ $data->crop_season }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Type</span><strong>{{ $data->crop_type }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mini-card"><span>Created
                                        at</span><strong>{{ $data->created_at->format('M j, Y') }}</strong></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-book"
                                        aria-hidden="true"></i><span>Detailed information</span></h2>
                            </div>
                             @can('manage crops')
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#formModal">Edit Crop</button>
                            @endcan
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <span class="activity-dot bg-primary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Variety</p>
                                    <p class="text-muted small mb-0">{{$data->variety}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-success"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Sowing Method</p>
                                    <p class="text-muted small mb-0">{{$data->sowing_method}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-warning"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Irrigation</p>
                                    <p class="text-muted small mb-0">{{$data->irrigation}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-secondary"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Fertilizers</p>
                                    <p class="text-muted small mb-0">{{$data->fertilizers}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-info"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Plant Protection</p>
                                    <p class="text-muted small mb-0">{{$data->plant_protection}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-danger"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Deficiency</p>
                                    <p class="text-muted small mb-0">{{$data->deficiency}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-light"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Weeds</p>
                                    <p class="text-muted small mb-0">{{$data->weeds}}</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <span class="activity-dot bg-dark"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">Advisory</p>
                                    <p class="text-muted small mb-0">{{$data->advisory}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @can('manage crops')
        {{-- Edit Form Model --}}
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form class="panel needs-validation" novalidate action="{{ route('crops.update', $data->id) }}"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <div class="panel-header">
                            <div>
                                <h2 class="h5 mb-1 section-title"><i class="bi bi-leaf" aria-hidden="true"></i><span>Update Crop
                                        Details</span></h2>
                                <p class="text-muted mb-0">Update crop information with validated fields.</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="crop_name">Name</label><input
                                    class="form-control" id="crop_name" name="crop_name" type="text"
                                    value="{{ old('crop_name', $data->crop_name) }}" required>
                                <div class="invalid-feedback">Name is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="crop_season">Season</label>
                                <select name="crop_season" id="crop_season" class="form-control" required>
                                    <option value="">Select a season</option>
                                    <option value="Kharif"
                                        {{ old('crop_season', $data->crop_season) == 'Kharif' ? 'selected' : '' }}>Kharif
                                        Season
                                    </option>
                                    <option value="Rabi"
                                        {{ old('crop_season', $data->crop_season) == 'Rabi' ? 'selected' : '' }}>Rabi Season
                                    </option>
                                    <option value="Zaid"
                                        {{ old('crop_season', $data->crop_season) == 'Zaid' ? 'selected' : '' }}>Zaid Season
                                    </option>
                                    <option value="Off Season"
                                        {{ old('crop_season', $data->crop_season) == 'Off Season' ? 'selected' : '' }}>Off
                                        Season</option>
                                </select>
                                <div class="invalid-feedback">Season is required.</div>
                            </div>

                            <div class="col-md-6"><label class="form-label" for="crop_type">Type</label><input
                                    class="form-control" id="crop_type" name="crop_type" type="text"
                                    value="{{ old('crop_type', $data->crop_type) }}" required>
                                <div class="invalid-feedback">Type is required.</div>
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

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-leaf" aria-hidden="true"></i>
                                Update Crop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
