@extends('layouts.dashboard')

@section('page')
    Weather Forecast
@endsection

@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">Data</p>
                        <h1 class="h3 mb-1">Weather</h1>
                        <p class="text-muted mb-0">Weather data from IMD.</p>
                    </div>
                </div>
                <div>
                    <label for="location" class="form-label text-primary fw-bold">Select Location</label>
                    <select class="form-control form-control-sm table-search" name="location" id="location">
                        <option value="">Select Location</option>
                        @foreach ($stationResponse as $station)
                            <option value="{{ $station['id'] }}">{{ $station['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <section class="panel mb-4">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>GDD/AGDD
                                Forecast</span></h2>
                    </div>
                    {{-- <input class="form-control form-control-sm table-search" type="search"
                        placeholder="Search orders" data-table-search="ordersTable" aria-label="Search orders"> --}}
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="gddTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>T.Max(°C)</th>
                                <th>T.Min(°C)</th>
                                <th>GDD</th>
                                <th>AGDD</th>
                            </tr>
                        </thead>
                        <tbody id="gddData">
                            {{-- GDD data will be populated here --}}
                            <tr>
                                <td colspan="2" class="text-center text-primary">
                                    Please choose a location to view the GDD data.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Weather
                                Forecast</span></h2>
                        {{-- <p class="text-muted mb-0">IMD data.</p> --}}
                    </div>
                    {{-- <input class="form-control form-control-sm table-search" type="search"
                        placeholder="Search orders" data-table-search="ordersTable" aria-label="Search orders"> --}}
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                        <thead>
                            <tr>
                                <th>Valid Time</th>
                                <th>Rainfall</th>
                                <th>Cloud Cover</th>
                                <th>Temperature</th>
                                <th>Max Temperature</th>
                                <th>Min Temperature</th>
                            </tr>
                        </thead>
                        <tbody id="weatherData">
                            {{-- Weather data will be populated here --}}
                            <tr>
                                <td colspan="6" class="text-center text-primary">
                                    Please choose a location to view the weather forecast data.
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div id="weatherPagination" class="mt-3 text-center"></div>
                </div>
            </section>
        </div>
    </main>

    <script>
        const locationSelect = document.getElementById('location');
        const weatherDataContainer = document.getElementById('weatherData');
        const gddDataContainer = document.getElementById('gddData');

        let weatherPredictions = [];
        let currentPage = 1;
        const recordsPerPage = 10;

        locationSelect.addEventListener('change', function() {

            const selectedLocation = this.value;

            // Clear everything if no location selected
            if (!selectedLocation) {
                weatherDataContainer.innerHTML = '';
                gddDataContainer.innerHTML = '';
                document.getElementById('weatherPagination').innerHTML = '';
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Weather URL
            |--------------------------------------------------------------------------
            */

            const weatherUrl = "{{ route('weather.data', ':location') }}"
                .replace(':location', encodeURIComponent(selectedLocation));

            /*
            |--------------------------------------------------------------------------
            | GDD URL
            |--------------------------------------------------------------------------
            */

            const gddUrl = "{{ route('gdd.data', ':location') }}"
                .replace(':location', encodeURIComponent(selectedLocation));


            /*
            |--------------------------------------------------------------------------
            | Loading
            |--------------------------------------------------------------------------
            */

            weatherDataContainer.innerHTML = `
            <tr>
                <td colspan="10" class="text-center">
                    Loading weather data...
                </td>
            </tr>
        `;

            gddDataContainer.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">
                    Loading GDD data...
                </td>
            </tr>
        `;


            /*
            |--------------------------------------------------------------------------
            | Fetch Weather Data
            |--------------------------------------------------------------------------
            */

            fetch(weatherUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {

                    if (!response.ok) {
                        throw new Error('HTTP Error: ' + response.status);
                    }

                    return response.json();
                })
                .then(result => {

                    if (!result.success) {
                        throw new Error(result.message || 'Unable to load weather data');
                    }

                    weatherPredictions = result.data?.predictions || [];

                    currentPage = 1;

                    renderTable();
                    renderPagination();
                })
                .catch(error => {

                    console.error('Weather Error:', error);

                    weatherDataContainer.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center text-danger">
                        Failed to load weather data.
                    </td>
                </tr>
            `;

                    document.getElementById('weatherPagination').innerHTML = '';
                });


            /*
            |--------------------------------------------------------------------------
            | Fetch GDD Data
            |--------------------------------------------------------------------------
            */

            fetch(gddUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {

                    if (!response.ok) {
                        throw new Error('HTTP Error: ' + response.status);
                    }

                    return response.json();
                })
                .then(result => {

                    console.log('GDD Response:', result);

                    if (!result.success) {
                        throw new Error(
                            result.message || 'Unable to load GDD data'
                        );
                    }

                    const gddData = result.data?.records || [];

                    gddDataContainer.innerHTML = '';

                    if (gddData.length === 0) {

                        gddDataContainer.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">
                            No GDD data available
                        </td>
                    </tr>
                `;

                        return;
                    }

                    gddData.forEach(item => {

                        const row = document.createElement('tr');

                        row.innerHTML = `
                    <td>${item.date ?? '-'}</td>
                    <td>${item.tmax ?? '-'}</td>
                    <td>${item.tmin ?? '-'}</td>
                    <td>${item.gdd ?? '-'}</td>
                    <td>${item.agdd ?? '-'}</td>
                `;

                        gddDataContainer.appendChild(row);
                    });
                })
                .catch(error => {

                    console.error('GDD Error:', error);

                    gddDataContainer.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        Failed to load GDD data.
                    </td>
                </tr>
            `;
                });
        });


        /*
        |--------------------------------------------------------------------------
        | Render Weather Table
        |--------------------------------------------------------------------------
        */

        function renderTable() {

            weatherDataContainer.innerHTML = '';

            if (weatherPredictions.length === 0) {

                weatherDataContainer.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center">
                        No weather data available
                    </td>
                </tr>
            `;

                return;
            }

            const start = (currentPage - 1) * recordsPerPage;
            const end = start + recordsPerPage;

            const pageData = weatherPredictions.slice(start, end);

            pageData.forEach(item => {

                const variables = item.variables || {};

                const row = document.createElement('tr');

                row.innerHTML = `
                <td>
                    ${formatDate(item.valid_time)}
                </td>

                <td>
                    ${variables.tp ?? '-'}
                </td>

                <td>
                    ${variables.tcc != null ? variables.tcc + '%' : '-'}
                </td>

                <td>
                    ${kelvinToCelsius(variables.t2m)}
                </td>

                <td>
                    ${kelvinToCelsius(variables.tmax)}
                </td>

                <td>
                    ${kelvinToCelsius(variables.tmin)}
                </td>
            `;

                weatherDataContainer.appendChild(row);
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        function renderPagination() {

            const pagination =
                document.getElementById('weatherPagination');

            pagination.innerHTML = '';

            const totalPages =
                Math.ceil(weatherPredictions.length / recordsPerPage);

            if (totalPages <= 1) {
                return;
            }

            // Previous
            const previousButton =
                document.createElement('button');

            previousButton.type = 'button';
            previousButton.className =
                'btn btn-sm btn-outline-primary me-1';

            previousButton.textContent = 'Previous';

            previousButton.disabled =
                currentPage === 1;

            previousButton.addEventListener('click', function() {

                if (currentPage > 1) {

                    currentPage--;

                    renderTable();
                    renderPagination();
                }
            });

            pagination.appendChild(previousButton);


            // Page numbers
            for (let page = 1; page <= totalPages; page++) {

                const pageButton =
                    document.createElement('button');

                pageButton.type = 'button';

                pageButton.className =
                    `btn btn-sm ${
                    page === currentPage
                        ? 'btn-primary'
                        : 'btn-outline-primary'
                } me-1`;

                pageButton.textContent = page;

                pageButton.addEventListener('click', function() {

                    currentPage = page;

                    renderTable();
                    renderPagination();
                });

                pagination.appendChild(pageButton);
            }


            // Next
            const nextButton =
                document.createElement('button');

            nextButton.type = 'button';

            nextButton.className =
                'btn btn-sm btn-outline-primary';

            nextButton.textContent = 'Next';

            nextButton.disabled =
                currentPage === totalPages;

            nextButton.addEventListener('click', function() {

                if (currentPage < totalPages) {

                    currentPage++;

                    renderTable();
                    renderPagination();
                }
            });

            pagination.appendChild(nextButton);
        }


        /*
        |--------------------------------------------------------------------------
        | Format UTC Time → IST
        |--------------------------------------------------------------------------
        */

        function formatDate(dateString) {

            if (!dateString) {
                return '-';
            }

            const date = new Date(dateString);

            if (isNaN(date.getTime())) {
                return dateString;
            }

            return date.toLocaleString('en-IN', {
                timeZone: 'Asia/Kolkata',
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Kelvin → Celsius
        |--------------------------------------------------------------------------
        */

        function kelvinToCelsius(value) {

            if (value === null || value === undefined) {
                return '-';
            }

            return `${(Number(value) - 273.15).toFixed(1)} °C`;
        }

        document.addEventListener('DOMContentLoaded', function() {

            // Select the first actual location
            if (locationSelect.options.length > 1) {

                locationSelect.selectedIndex = 1;

                // Trigger change event
                locationSelect.dispatchEvent(new Event('change'));
            }

        });
    </script>
@endsection
