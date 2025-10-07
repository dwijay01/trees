<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
        /* ## General Styling ## */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* ## Card Styling (Pengganti Bootstrap Card) ## */
        .card {
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }
        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-body {
            padding: 1.25rem;
        }
        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fc;
            border-top: 1px solid #e3e6f0;
            text-align: right;
        }

        /* ## Layout Grid (Pengganti Bootstrap Row/Col) ## */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-md-4 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        /* ## Form Styling ## */
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: inline-block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-sizing: border-box; /* Menjamin padding tidak menambah lebar */
        }

        /* ## Button Styling ## */
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            cursor: pointer;
            margin-left: 5px;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        
        /* ## Table Styling ## */
        #tabel_lahan {
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">Filter Data Lahan</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_kota">Kota</label>
                        <select id="filter_kota" name="filter_kota" class="form-control">
                            <option value="">-- Semua Kota --</option>
                            <?php foreach ($kota as $k) : ?>
                                <option value="<?= $k->city; ?>"><?= $k->city; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_kecamatan">Kecamatan</label>
                        <select id="filter_kecamatan" name="filter_kecamatan" class="form-control">
                            <option value="">-- Semua Kecamatan --</option>
                            <?php foreach ($kecamatan as $kec) : ?>
                                <option value="<?= $kec->kecamatan; ?>"><?= $kec->kecamatan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_desa">Desa</label>
                        <select id="filter_desa" name="filter_desa" class="form-control">
                            <option value="">-- Semua Desa --</option>
                            <?php foreach ($desa as $d) : ?>
                                <option value="<?= $d->village; ?>"><?= $d->village; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
				<div class="col-md-4">
                    <div class="form-group">
                        <label for="filter_identifikasi">Identifikasi DB</label>
                        <select id="filter_identifikasi" name="filter_identifikasi" class="form-control">
                            <option value="">-- Semua Data --</option>
                            <option value="1">-- Sudah Ada Di Geko --</option>
							<option value="2">-- Belum Ada Di Geko --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" id="tombol_filter" class="btn btn-primary">Terapkan Filter</button>
            <button type="button" id="tombol_reset" class="btn btn-secondary">Reset Filter</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Lahan</div>
        <div class="card-body">
            <table id="tabel_lahan" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Lahan</th>
                        <th>Desa</th>
                        <th>Petani</th>
                        <th>Planting Area</th>
                        <th>Land Area</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
	

    <div class="card">
        <div class="card-header">Ringkasan Hasil Filter</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Jumlah Total Lahan: <span id="total_lahan">0</span> 🏞️</h4>
                </div>
                <div class="col-md-6">
                    <h4>Jumlah Total Petani: <span id="total_petani">0</span> 👨‍🌾</h4>
                </div>
            </div>
        </div>
    </div>
    <br>

    

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            var tabel = $('#tabel_lahan').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('Lahan/LoadData') ?>",
                    "type": "POST",
                    "data": function(d) {
                        d.filter_kota = $('#filter_kota').val();
                        d.filter_kecamatan = $('#filter_kecamatan').val();
                        d.filter_desa = $('#filter_desa').val();
						d.filter_identifikasi = $('#filter_identifikasi').val();
                    }
                },
                "columns": [{
                        "data": null,
                        "searchable": false,
                        "orderable": false,
                        "render": function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { "data": "lahan_no" },
                    { "data": "village" },
                    { "data": "farmer_temp" },
                    { "data": "planting_area" },
                    { "data": "land_area" }
                ],
				"drawCallback": function(settings) {
                    // Ambil data JSON yang dikembalikan oleh server
                    var json = settings.json;
                    
                    // Cek jika data JSON ada
                    if (json) {
                        // Update teks pada elemen span
                        $('#total_lahan').text(json.totalLahan);
                        $('#total_petani').text(json.totalPetani);
                    }
				}
            });

            $('#tombol_filter').on('click', function() {
                tabel.ajax.reload();
            });

            $('#tombol_reset').on('click', function() {
                $('#filter_kota').val('');
                $('#filter_kecamatan').val('');
                $('#filter_desa').val('');
                tabel.ajax.reload();
            });
        });
    </script>
</body>
</html>