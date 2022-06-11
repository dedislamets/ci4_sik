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
    <h1 class="h3 mb-2 text-gray-800">Deputi</h1>
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
                            <th>Deputi</th>
                            <th>Extention</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?= $text ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Deputi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('deputi/create') ?>" method="post">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="status">Parent</label>
                        <select name="parent_id" id="parent_id" class="form-control" >
                            <option value="0">-</option>
                            <?php 
                              foreach($deputis as $row)
                              { 
                                if( empty($data) ? "" : $data['id_deputi'] === $row['id_deputi']){
                                  echo '<option value="'.$row['id_deputi'].'" selected >'.$row['nama_deputi'].'</option>';
                                }else{
                                  echo '<option value="'.$row['id_deputi'].'">'.$row['nama_deputi'].'</option>';
                                }
                              }
                              ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Deputi</label>
                        <input type="text" name="nama_deputi" class="form-control" id="nama_deputi" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Extention</label>
                        <input type="text" name="extention" class="form-control" id="extention" placeholder="" required>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Deputi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form1" action="" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Parent</label>
                        <select name="parent_id" id="parent_id_edit" class="form-control edit" >
                            <option value="0">-</option>
                            <?php 
                              foreach($deputis as $row)
                              { 
                                echo '<option value="'.$row['id_deputi'].'">'.$row['nama_deputi'].'</option>';
                        
                              }
                              ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Deputi</label>
                        <input type="text" name="nama_deputi" class="form-control edit" id="nama_deputi_edit" value="" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="extention">Extention</label>
                        <input type="text" name="extention" class="form-control edit" id="extention_edit" value=""  placeholder="Email" required>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit">Save</button>
                    <a href="" class="btn btn-danger" id="btnDelete" onclick="return confirm('Are you sure ?')">Delete</a>
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
<script type="text/javascript">
    $(function () {
        var
            $table = $('#dataTable'),
            rows = $table.find('tr');

        rows.each(function (index, row) {
            var
                $row = $(row),
                level = $row.data('level'),
                id = $row.data('id'),
                $columnName = $row.find('td[data-column="name"]'),
                children = $table.find('tr[data-parent="' + id + '"]');

            if (children.length) {
                var expander = $columnName.prepend('' +
                    '<span class="treegrid-expander fa fa-angle-right"></span>' +
                    '');

                children.hide();

                expander.on('click', function (e) {
                    var $target = $(e.target);
                    // debugger;
                    if ( !$target.is( "a" ) ) {
                        if ($target.hasClass('fa fa-angle-right')) {
                            $target
                                .removeClass('fa fa-angle-right')
                                .addClass('fa fa-angle-down');

                            children.show();
                        } else {
                            $target
                                .removeClass('fa fa-angle-down')
                                .addClass('fa fa-angle-right');

                            reverseHide($table, $row);
                        }
                    }
                });
            }

            $columnName.prepend('' +
                '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
                '');
        });

        // Reverse hide all elements
        reverseHide = function (table, element) {
            var
                $element = $(element),
                id = $element.data('id'),
                children = table.find('tr[data-parent="' + id + '"]');

            if (children.length) {
                children.each(function (i, e) {
                    reverseHide(table, e);
                });

                $element
                    .find('.fa-angle-down')
                    .removeClass('fa fa-angle-down')
                    .addClass('fa fa-angle-right');

                children.hide();
            }
        };
    });
</script>
<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
      // $('#dataTable').DataTable();
    });

    function showModal(val){
        $.get('deputi/get', { id: $(val).data('id') }, function(data){ 
            var json = JSON.parse(data);
            $("#nama_deputi_edit").val(json['nama_deputi']);
            $("#extention_edit").val(json['extention']);
            $("#parent_id_edit").val(json['parent_id']);
            
            $("#form1").attr('action','deputi/edit/' + $(val).data('id'));
            $("#btnDelete").attr('href','deputi/delete/' + $(val).data('id'));
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