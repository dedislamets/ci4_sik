<?= $this->extend('layouts/admin') ?>

<?php $this->section('styles') ?>
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?> " rel="stylesheet">
<style type="text/css">
    .treegrid-indent {
        width: 0px;
        height: 16px;
        display: inline-block;
        position: relative;
    }

    .treegrid-expander {
        width: 0px;
        height: 16px;
        display: inline-block;
        position: relative;
        left:-17px;
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Unit</h1>
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
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="85">#</th>
                            <th>Unit</th>
                            <th>Direktorat</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($deputis as $key => $deputi) : ?>
                        <tr>
                            <td><?= ++$key ?></td>
                            <td><?= $deputi['nama_unit'] ?></td>
                            <td><?= $deputi['nama_direktorat'] ?></td>
                            <td >
                                <?php if(!empty(user())){ ?>
                                    <button type="button" class="btn btn-primary btn-edit" data-id="<?= $deputi['id'] ?>" onclick="showModal(this)">Edit</button>
                                    
                                    <a href="<?= base_url('unit/delete/'.$deputi['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('unit/create') ?>" method="post">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Parent</label>
                        <select name="id_direktorat" id="id_direktorat" class="form-control" >
                            <?php 
                              foreach($direktorat as $row)
                              { 
                                if( empty($data) ? "" : $data['id'] === $row['id']){
                                  echo '<option value="'.$row['id'].'" selected >'.$row['nama_direktorat'].'</option>';
                                }else{
                                  echo '<option value="'.$row['id'].'">'.$row['nama_direktorat'].'</option>';
                                }
                              }
                              ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Unit</label>
                        <input type="text" name="nama_unit" class="form-control" id="nama_unit" placeholder="" required>
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

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form1" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Parent</label>
                        <select name="id_direktorat" id="id_direktorat_edit" class="form-control" >
                            <?php 
                              foreach($direktorat as $row)
                              { 
                                if( empty($data) ? "" : $data['id'] === $row['id']){
                                  echo '<option value="'.$row['id'].'" selected >'.$row['nama_direktorat'].'</option>';
                                }else{
                                  echo '<option value="'.$row['id'].'">'.$row['nama_direktorat'].'</option>';
                                }
                              }
                              ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Unit</label>
                        <input type="text" name="nama_unit" class="form-control edit" id="nama_unit_edit" value="" placeholder="" required>
                    </div>
                </div>
                <div class="modal-footer">
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
    $(document).ready(function() {
      $('#dataTable').DataTable();
    });

    function showModal(val){
        $.get('unit/get', { id: $(val).data('id') }, function(data){ 
            var json = JSON.parse(data);
            $("#nama_unit_edit").val(json['nama_unit']);
            
            $("#form1").attr('action','unit/edit/' + $(val).data('id'));
            $("#btnDelete").attr('href','unit/delete/' + $(val).data('id'));
            $('#editModal').modal({backdrop: 'static', keyboard: false}) ;
            <?php if(empty(user())){ ?>
                $(".edit").attr("disabled","disabled");
                $(".btn-submit").css("display","none");
                $("#btnDelete").css("display","none");
            <?php } ?>
        });
    }
</script>
<?php $this->endSection()?>