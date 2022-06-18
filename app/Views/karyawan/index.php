<?= $this->extend('layouts/admin') ?>

<?php $this->section('styles') ?>
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?> " rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Karyawan</h1>
    <?php
        if(session()->getFlashData('success')){
        ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        }
        ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?php if(!empty(user())){ ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                Add
                </button>
            <?php } ?>
            <button type="button" id="btnFilter" class="btn btn-success" data-toggle="modal" data-target="#filterModal">
            Filter
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Agama</th>
                            <th>Status</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Add Contact Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('dashboard/create') ?>" method="post">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" >
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="HP" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" >
                            <option value="single">Single</option>  
                            <option value="menikah">Menikah</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" rows="2" class="form-control" id="address" placeholder="Alamat" required> </textarea> 
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" name="agama" class="form-control" id="address" placeholder="Agama" >
                    </div>
                    <div class="form-group">
                        <label for="status">Unit</label>
                        <select name="id_unit" id="id_unit" class="form-control" >
                            <?php 
                              foreach($unit as $row)
                              { 
                                if( empty($data) ? "" : $data['id'] === $row['id']){
                                  echo '<option value="'.$row['id'].'" selected >'.$row['nama_unit'].'</option>';
                                }else{
                                  echo '<option value="'.$row['id'].'">'.$row['nama_unit'].'</option>';
                                }
                              }
                              ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Pencarian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formFilter" method="post">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group row copy-rw" id="div1">
                        <div class="col-sm-5">
                            <select name="filter_1" class="form-control">
                                <option value="name">Nama Lengkap</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="agama">Agama</option>
                                <option value="status">Status</option>
                                <option value="nama_unit">Unit</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="input_1" class="form-control " placeholder="" value="">
                        </div>
                        <div class="col-sm-1">
                            <a href="javascript:void(0)" class="remove" ><i class="fas fa-fw fa-minus-circle" style="padding-top: 10px;"></i></a>
                        </div>
                    </div>
                    <div class="form-group baris" style="text-align: right;">
                        <a href="javascript:void(0)" id="btnBaris">+ baris</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form1" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name_edit" class="form-control edit" id="name_edit" value="" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email_edit" class="form-control edit" id="email_edit" value=""  placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone_edit" class="form-control edit" id="phone_edit" value=""  placeholder="Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status_edit" id="status_edit" class="form-control edit" >
                            <option value="single" >Single</option>  
                            <option value="menikah" >Menikah</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address_edit" rows="2" class="form-control edit" id="address_edit" placeholder="Alamat" required ></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" name="agama_edit" class="form-control edit" id="agama_edit" placeholder="Agama" value="">
                    </div>
                    <div class="form-group">
                        <label for="status">Unit</label>
                        <select name="id_unit_edit" id="id_unit_edit" class="form-control edit" >
                            <?php 
                              foreach($unit as $row)
                              { 
                                echo '<option value="'.$row['id'].'">'.$row['nama_unit'].'</option>';
                        
                              }
                              ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?php $this->section('scripts')?>
<!-- Page level plugins -->
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    var table;
    $(document).ready(function() {
        table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('dashboard/ajaxList') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],
            });

    });
 
    $(".btn-edit").on('click', function (event) {
        $(".edit").removeAttr("disabled");
        $(".btn-submit").css("display","block");
    })
    $("#btnBaris").on('click', function (event) {
        var $div = $('div[id^="div"]:last').clone(true);
        var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
        $div.find('[name*="filter_"]').prop('name', 'filter_'+num );
        $div.find('[name*="input_"]').val('');
        $div.find('[name*="input_"]').prop('name', 'input_'+num );
        var $klon = $div.prop('id', 'div'+num );
        
        $klon.insertBefore(".baris");
    })
    $(".remove").on('click', function (event) {
        $(this).parent().parent().remove();
    })

    $("#btnCari").on('click', function (event) {
        var data = $("#formFilter").serialize();

        table.ajax.url("<?= site_url('dashboard/ajaxList') ?>?" + data).load();

    })

    function showModal(val){
        $.get('dashboard/get', { id: $(val).data('id') }, function(data){ 
            var json = JSON.parse(data);
            $("#name_edit").val(json['name']);
            $("#email_edit").val(json['email']);
            $("#address_edit").val(json['address']);
            $("#id_unit_edit").val(json['id_unit']);
            $("#status_edit").val(json['status']);
            $("#phone_edit").val(json['phone']);
            $("#agama_edit").val(json['agama']);
            $("#form1").attr('action','dashboard/edit/' + $(val).data('id'));
            // $("#id_barang").val(data[0]['id_barang']);
            $('#editModal').modal({backdrop: 'static', keyboard: false}) ;

            <?php if(empty(user())){ ?>
                $(".edit").attr("disabled","disabled");
                $(".btn-submit").css("display","none");
            <?php } ?>
        });
    }
 
</script>
<?php $this->endSection()?>