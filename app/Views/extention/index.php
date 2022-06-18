<?= $this->extend('layouts/admin') ?>

<?php $this->section('styles') ?>
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?> " rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Extention</h1>
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?php if(!empty(user())){ ?>
                <button type="button" class="btn btn-primary" id="btnAdd">
                Add
                </button>
            <?php } ?>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Direktorat</th>
                            <th>Unit</th>
                            <th>Keterangan</th>
                            <th>Extention</th>
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
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Extention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form1" action="<?= base_url('extention/create') ?>" method="post">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="status">Direktorat</label>
                        <select name="direktorat" id="direktorat" class="form-control" required >
                            <option value="0">-</option>
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
                        <select name="unit" data-id=0 id="unit" class="form-control" required>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Extention</label>
                        <input type="text" name="extention" class="form-control" id="extention" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Keterangan</label>
                        <textarea rows="3" name="keterangan" class="form-control" id="keterangan" placeholder="">
                        </textarea>
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
                    "url": "<?php echo site_url('extention/ajaxList') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],
            });

    });
 
    $(".btn-edit").on('click', function (event) {
        
        $(".btn-submit").css("display","block");
    })
    $(".btn-lihat").on('click', function (event) {
        alert('lihat');
        $("#exampleModalLabel").text("View Extention");
        $(".btn-submit").css("display","none");
    })

    $("#direktorat").change(function(e, params){              
        $.get('<?= base_url()?>/unit/getbydir', { id: $(this).val()  }, function(data){ 
            var json = JSON.parse(data);
            $('#unit').empty();            
            $.each(json,function(i,value){
                $('#unit').append('<option value="'+value.id+'">'+value.nama_unit+'</option>');
                
            })
            if($("#unit").data('id') > 0){
                $("#unit").val($("#unit").data('id'));
            }
        });
    });
    $("#btnAdd").on('click', function (event) {
        $("#unit").data('id',0);
        $("#exampleModalLabel").text("Add Extention");
        $("#keterangan").val('');
        $('#addModal').modal({backdrop: 'static', keyboard: false}) ;
    })
    function showModal(val){
        $("#unit").data('id',0);
        $("#exampleModalLabel").text("Edit Extention");
        $.get('extention/get', { id: $(val).data('id') }, function(data){ 
            var json = JSON.parse(data);
            $("#extention").val(json['extention']);
            $("#keterangan").val(json['keterangan']);
            $("#unit").data('id',json['id_unit']);

            $("#direktorat").val(json['id_direktorat']);
            $("#direktorat").change();
            
            $("#form1").attr('action','extention/edit/' + $(val).data('id'));
            $('#addModal').modal({backdrop: 'static', keyboard: false}) ;

            <?php if(empty(user())){ ?>
                $(".edit").attr("disabled","disabled");
                $(".btn-submit").css("display","none");
            <?php } ?>
        });
    }
 
</script>
<?php $this->endSection()?>