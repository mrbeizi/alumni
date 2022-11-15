@extends('layouts.beadmin')
@section('title','Pertanyaan')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('admin.dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-kuisioner.index')}}">@yield('title')</a>
      </li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
</nav>
</div>
@endsection

@section('content')
<div class="container flex-grow-1">
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div class="mb-3">
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle bx-spin-hover"></i></a>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Code</th>
                                  <th>Questions</th>
                                  <th>Ops</th>
                                  <th>Req</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>

                    <!-- MULAI MODAL FORM TAMBAH/EDIT-->
                    <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-judul"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12">                                                
                                                <input type="hidden" name="id" id="id">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="kode_kuisioner" class="form-label">Kode Kuisioner*</label>
                                                        <input type="text" class="form-control" id="kode_kuisioner" name="kode_kuisioner" value="" placeholder="Kode Kuisioner" />
                                                        <span class="text-danger" id="kodeKuisionerErrorMsg"></span>
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="nama_data" class="form-label">Pertanyaan*</label>
                                                        <textarea id="nama_data" name="nama_data" rows="2" cols="10"class="form-control"></textarea>
                                                        <span class="text-danger" id="namaDataErrorMsg"></span>
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="kategori" class="form-label">Kategori*</label>
                                                        <select class="form-select" id="kategori" name="kategori" aria-label="Default select example">
                                                            <option value="">- Choose -</option>
                                                            <option value="1">Wajib</option>
                                                            <option value="0">Opsional</option>
                                                        </select>
                                                        <span class="text-danger" id="kategoriErrorMsg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="no_urut" class="form-label">No Urut*</label>
                                                            <input type="number" class="form-control" id="no_urut" name="no_urut" value="" />
                                                            <span class="text-danger" id="noUrutErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="is_selected" class="form-label">Ada Pilihan</label>
                                                            <select class="form-select" id="is_selected" name="is_selected" aria-label="Default select example">
                                                                <option value="">- Choose -</option>
                                                                <option value="1">Ya</option>
                                                                <option value="0">Tidak</option>
                                                            </select>
                                                            <span class="text-danger" id="isSelectedErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="is_required" class="form-label">Wajib Isi</label>
                                                            <select class="form-select" id="is_required" name="is_required" aria-label="Default select example">
                                                                <option value="">- Choose -</option>
                                                                <option value="1">Ya</option>
                                                                <option value="0">Tidak</option>
                                                            </select>
                                                            <span class="text-danger" id="isRequiredErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            

                                            <div class="col-sm-offset-2 col-sm-12">
                                                <hr class="mt-2">
                                                <div class="float-sm-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Save</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL -->
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // DATATABLE
    $(document).ready(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: "{{ route('data-kuisioner.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode_kuisioner',name: 'kode_kuisioner'},
                {data: 'nama_data',name: 'nama_data'},
                {data: 'isSelected',name: 'isSelected'},
                {data: 'is_required',name: 'is_required', render: function(type, row,row){ return (row.is_required == 1) ? "Yes" : "No";}},
                {data: 'action',name: 'action'},
            ]
        });
    });

    //TOMBOL TAMBAH DATA
    $('#tombol-tambah').click(function () {
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Add new data");
        $('#tambah-edit-modal').modal('show');
    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('data-kuisioner.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table').DataTable().ajax.reload(null, true);
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Data saved successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    },
                    error: function(response) {
                        $('#kodeKuisionerErrorMsg').text(response.responseJSON.errors.kode_kuisioner);
                        $('#namaDataErrorMsg').text(response.responseJSON.errors.namaData);
                        $('#noUrutErrorMsg').text(response.responseJSON.errors.no_urut);
                        $('#isSelectedErrorMsg').text(response.responseJSON.errors.is_selected);
                        $('#isRequiredErrorMsg').text(response.responseJSON.errors.is_required);
                        $('#kategoriErrorMsg').text(response.responseJSON.errors.kategori);
                        $('#tombol-simpan').html('Save');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Data failed to save!',
                            type: 'error',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    }
                });
            }
        })
    }

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('data-kuisioner/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#kode_kuisioner').val(data.kode_kuisioner);
            $('#nama_data').val(data.nama_data);
            $('#kategori').val(data.kategori);
            $('#no_urut').val(data.no_urut);
            $('#is_selected').val(data.is_selected);
            $('#is_required').val(data.is_required);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "data-kuisioner/" + dataId,
                        type: 'DELETE',
                        data: {id:dataId},
                        dataType: 'json'
                    }).done(function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your data has been deleted.',
                            type: 'success',
                            timer: 2000
                        })
                        $('#table').DataTable().ajax.reload(null, true);
                    }).fail(function() {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong with ajax!',
                            type: 'error',
                            timer: 2000
                        })
                    });
                });
            },
        });
    });

</script>

@endsection