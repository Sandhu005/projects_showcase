@extends('layouts.dashboard')

@section('page')
    Crops List
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-card-checklist" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">List</p>
                        <h1 class="h3 mb-1">Crops List</h1>
                        <p class="text-muted mb-0">All crops in the system.</p>
                    </div>
                </div>
                <div class="heading-actions"><button class="btn btn-outline-secondary btn-sm" type="button"><i
                            class="bi bi-download" aria-hidden="true"></i> Export</button><button
                        class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus"
                            aria-hidden="true"></i> Create Report</button>
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
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-card-checklist" aria-hidden="true"></i><span>Crops
                                Details</span></h2>
                        <p class="text-muted mb-0">Manage and view all crops in the system.</p>
                    </div><input class="form-control form-control-sm table-search" type="search" placeholder="Search crops"
                        data-table-search="cropsTable" aria-label="Search crops">
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th>Crop Name</th>
                                <th>Season</th>
                                <th>Type</th>
                                {{-- <th>Variety</th> --}}
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crops as $crop)
                                <tr>
                                    <td>
                                        <div class="table-media"><img class="product-thumb"
                                                src="{{ url('images/crops/' . $crop->crop_image) }}"
                                                alt="Wireless Headset"><span>{{ $crop->crop_name }}</span></div>
                                    </td>

                                    <td>{{ $crop->crop_season }}</td>

                                    <td>{{ $crop->crop_type }}</td>

                                    {{-- <td>{{ Str::words($crop->variety, 3, '...') }}</td> --}}

                                    <td>
                                        @if ($crop->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="d-flex justify-content-end">
                                        <a class="btn btn-light btn-sm" href="{{ route('crops.show', $crop->id) }}"><i
                                                class="bi bi-eye"></i></a>

                                        @can('manage crops')
                                            @if ($crop->status == 'active')
                                                <form action="{{ route('crops.destroy', $crop->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('crops.restore', $crop->id) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-light btn-sm ms-1" type="submit"><i
                                                            class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
@endsection
