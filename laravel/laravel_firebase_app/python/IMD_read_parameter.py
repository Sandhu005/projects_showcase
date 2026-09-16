
import json
import os
import tempfile
from datetime import datetime, timedelta, timezone
import numpy as np
import paramiko
import xarray as xr

# ==========================
# SFTP & Target Setup
# ==========================
HOST = ""
PORT = 
USERNAME = ""
PASSWORD = ""
BASE_DIR = ""

# Target Coordinates: Nauni / Solan
TARGET_LAT = 30.865532535998263
TARGET_LON = 77.1702410213733

OUTPUT_JSON_FILE = ""


# IST Timezone setup (UTC + 5:30)
IST = timezone(timedelta(hours=5, minutes=30))


def get_latest_run_folder(sftp, base_dir):
    """Determines active IMD GFS run folder based on current IST time, with automatic fallback."""
    now_ist = datetime.now(IST)
    current_date = now_ist.date()

    if now_ist.hour < 8:
        prev_date = current_date - timedelta(days=1)
        expected_folder = prev_date.strftime("%Y%m%d") + "12"
    elif 8 <= now_ist.hour < 20:
        expected_folder = current_date.strftime("%Y%m%d") + "00"
    else:
        expected_folder = current_date.strftime("%Y%m%d") + "12"

    remote_path = f"{base_dir}/{expected_folder}"

    try:
        sftp.stat(remote_path)
        print(f"Using Active Run Directory: {expected_folder}")
        return remote_path, expected_folder
    except FileNotFoundError:
        print(f"Warning: Expected directory '{expected_folder}' not found. Searching latest...")

    all_dirs = [d for d in sftp.listdir(base_dir) if d.isdigit() and len(d) == 10]
    if all_dirs:
        latest_available = sorted(all_dirs)[-1]
        print(f"Fallback selected: Using directory '{latest_available}'")
        return f"{base_dir}/{latest_available}", latest_available

    raise FileNotFoundError("Could not find any valid GFS run directories on SFTP.")


def get_lat_lon_keys(ds):
    """Finds latitude and longitude coordinate names in the dataset."""
    lat_key = next((k for k in ["latitude", "lat", "y"] if k in ds.coords or k in ds.dims), None)
    lon_key = next((k for k in ["longitude", "lon", "x"] if k in ds.coords or k in ds.dims), None)
    return lat_key, lon_key


def sanitize_value(val):
    """Converts numpy values/NaNs into standard JSON-serializable Python types."""
    if isinstance(val, (np.ndarray, list)):
        val = np.nanmean(val) if len(val) > 0 else None

    if val is None or np.isnan(val) or np.isinf(val):
        return None

    return float(val)


# ==========================
# Connect to SFTP
# ==========================
print(f"1. Connecting to SFTP ({HOST})...")
transport = paramiko.Transport((HOST, PORT))
transport.connect(username=USERNAME, password=PASSWORD)
sftp = paramiko.SFTPClient.from_transport(transport)

REMOTE_DIR, ACTIVE_RUN_TAG = get_latest_run_folder(sftp, BASE_DIR)
all_files = sftp.listdir(REMOTE_DIR)

# Group files by timestamp tag (e.g., '2026072800.grib2')
file_groups = {}
for fname in all_files:
    if fname.endswith(".grib2"):
        parts = fname.split("_")
        if len(parts) >= 2:
            timestamp = parts[-1]
            file_groups.setdefault(timestamp, []).append(fname)

output_structure = {
    "metadata": {
        "source": "IMD GFS Forecast Model",
        "imd_run_tag": ACTIVE_RUN_TAG,
        "extracted_at": datetime.now(IST).isoformat(),
        "target_coordinates": {
            "latitude": TARGET_LAT,
            "longitude": TARGET_LON,
        },
    },
    "forecasts": [],
}

# ==========================
# Extract All Variables
# ==========================
for timestamp, files in sorted(file_groups.items()):
    print(f"\nProcessing timestamp group: {timestamp}")

    forecast_record = {
        "timestamp_tag": timestamp,
        "nearest_grid_point": {"grid_latitude": None, "grid_longitude": None},
        "all_variables": [],
    }

    for fname in files:
        remote_file_path = f"{REMOTE_DIR}/{fname}"
        fd, temp_path = tempfile.mkstemp(suffix=".grib2")
        os.close(fd)

        try:
            # Download file temporarily
            sftp.get(remote_file_path, temp_path)

            # Open GRIB2 dataset
            ds = xr.open_dataset(temp_path, engine="cfgrib", backend_kwargs={"indexpath": ""})
            lat_key, lon_key = get_lat_lon_keys(ds)

            if lat_key and lon_key:
                # Select point closest to target coordinates
                point_ds = ds.sel({lat_key: TARGET_LAT, lon_key: TARGET_LON}, method="nearest")

                # Store actual grid point coordinates
                if forecast_record["nearest_grid_point"]["grid_latitude"] is None:
                    forecast_record["nearest_grid_point"]["grid_latitude"] = float(point_ds[lat_key].values)
                    forecast_record["nearest_grid_point"]["grid_longitude"] = float(point_ds[lon_key].values)

                # Loop through EVERY variable present in this GRIB2 dataset
                for var_name in point_ds.data_vars:
                    da = point_ds[var_name]

                    raw_val = sanitize_value(da.values)
                    units = da.attrs.get("units", "unknown")
                    long_name = da.attrs.get("long_name", var_name)
                    short_name = da.attrs.get("GRIB_shortName", var_name)

                    # Conversion logic for common meteorology units
                    converted_val = raw_val
                    converted_unit = units

                    if raw_val is not None:
                        # Convert Kelvin to Celsius
                        if units in ["K", "kelvin"] or (raw_val > 150 and "temp" in long_name.lower()):
                            converted_val = round(raw_val - 273.15, 2)
                            converted_unit = "°C"
                        else:
                            converted_val = round(raw_val, 2)

                    forecast_record["all_variables"].append({
                        "variable_code": var_name,
                        "short_name": short_name,
                        "description": long_name,
                        "raw_value": raw_val,
                        "converted_value": converted_val,
                        "unit": converted_unit,
                        "source_file": fname,
                    })

            ds.close()

        except Exception as err:
            print(f"Error processing {fname}: {err}")
        finally:
            if os.path.exists(temp_path):
                os.remove(temp_path)

    output_structure["forecasts"].append(forecast_record)

sftp.close()
transport.close()

# Save complete JSON
with open(OUTPUT_JSON_FILE, "w") as f:
    json.dump(output_structure, f, indent=4)

print(f"\nSuccessfully extracted all variables to '{OUTPUT_JSON_FILE}'")