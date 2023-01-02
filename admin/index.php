<?php
session_start();
if (!isset($_SESSION['password']) || $_SESSION['password'] != 'jasanet') {
    header('Location: login.php');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>

    <title>Admin</title>
</head>

<body>

    <div class="container">
        <img style="height: 5rem;
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5rem;
    margin-bottom: 5rem;" src="https://jasanet-online.com/assets/img/logo2.png" alt="logo">

        <span id="message"></span>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9">Data</div>
                    <div class="col col-sm-3">
                        <button type="button" id="add_data" class="btn btn-success btn-sm float-end">Tambah</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="sample_data">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>URL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<div class="modal" tabindex="-1" id="action_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamic_modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus />
                        <span id="nama_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="text" name="url" id="url" class="form-control" />
                        <span id="url_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="action_button">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        load_data();

        function load_data() {
            var seconds = new Date() / 1000;

            $.getJSON("../data.json?" + seconds + "", function(data) {

                data.sort(function(a, b) {

                    return a.id - b.id;

                });

                var data_arr = [];

                for (var count = 0; count < data.length; count++) {
                    var sub_array = {
                        'nama': data[count].nama,
                        'url': data[count].url,
                        'action': '<button type="button" class="btn btn-warning btn-sm edit" data-id="' + data[count].id + '">Edit</button>&nbsp;<button type="button" class="btn btn-danger btn-sm delete" data-id="' + data[count].id + '">Hapus</button>'
                    };

                    data_arr.push(sub_array);
                }

                $('#sample_data').DataTable({
                    data: data_arr,
                    order: [],
                    columns: [{
                            data: "nama"
                        },
                        {
                            data: "url"
                        },
                        {
                            data: "action"
                        }
                    ],
                    pageLength: 25
                });

            });
        }

        $('#add_data').click(function() {

            $('#dynamic_modal_title').text('Tambah Data');

            $('#sample_form')[0].reset();

            $('#action').val('Tambah');

            $('#action_button').text('Tambah');

            $('.text-danger').text('');

            $('#action_modal').modal('show');

        });

        $('#sample_form').on('submit', function(event) {

            event.preventDefault();

            $.ajax({
                url: "action.php",
                method: "POST",
                data: $('#sample_form').serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#action_button').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#action_button').attr('disabled', false);
                    if (data.error) {
                        if (data.error.nama_error) {
                            $('#nama_error').text(data.error.nama_error);
                        }
                        if (data.error.url_error) {
                            $('#url_error').text(data.error.url_error);
                        }
                    } else {
                        $('#message').html('<div class="alert alert-success">' + data.success + '</div>');

                        $('#action_modal').modal('hide');

                        $('#sample_data').DataTable().destroy();

                        load_data();

                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                }
            });

        });

        $(document).on('click', '.edit', function() {

            var id = $(this).data('id');

            $('#dynamic_modal_title').text('Edit Data');

            $('#action').val('Edit');

            $('#action_button').text('Edit');

            $('.text-danger').text('');

            $('#action_modal').modal('show');

            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    id: id,
                    action: 'fetch_single'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#nama').val(data.nama);
                    $('#url').val(data.url);
                    $('#id').val(data.id);
                }
            });

        });

        $(document).on('click', '.delete', function() {

            var id = $(this).data('id');

            if (confirm("Yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {
                        action: 'delete',
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#message').html('<div class="alert alert-success">' + data.success + '</div>');
                        $('#sample_data').DataTable().destroy();
                        load_data();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                });
            }

        });

    });
</script>