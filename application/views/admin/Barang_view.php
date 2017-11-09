<?php
$this->load->view('admin/template/head');
?>
    <!--tambahkan custom css disini-->
    <link href="<?php echo base_url('asset/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/AdminLTE-2.0.5/plugins/datepicker//bootstrap-datepicker.min.css')?>" rel="stylesheet">
<?php
$this->load->view('admin/template/topbar');
$this->load->view('admin/template/sidebar');
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Barang
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Add Data Barang</button>
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Sub Kategori Barang</th>
                        <!-- <th style="width:25px;">Deskripsi Barang</th> -->
                        <th>Harga Barang</th>
                        <th>Stok Barang</th>
                        <th style="width:25px;">Foto Barang</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Sub Kategori Barang</th>
                        <!-- <th>Deskripsi Barang</th> -->
                        <th>Harga Barang</th>
                        <th>Stok Barang</th>
                        <th>Foto Barang</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


    </section><!-- /.content -->

<?php
$this->load->view('admin/template/js');
?>
    <!--tambahkan custom js disini-->
    <script src="<?php echo base_url('asset/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('asset/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('asset/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript">
 
        var save_method; //for save method string
        var table;
        var base_url = '<?php echo base_url();?>';
         
        $(document).ready(function() {
         
            //datatables
            table = $('#table').DataTable({ 
         
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
         
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('admin/Barang/ajax_list')?>",
                    "type": "POST"
                },
         
                //Set column definition initialisation properties.
                "columnDefs": [
                    { 
                        "targets": [ -1 ], //last column
                        "orderable": false, //set not orderable
                    },
                    { 
                        "targets": [ -2 ], //2 last column (photo)
                        "orderable": false, //set not orderable
                    },
                ],
         
            });
         
            //datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true,
                todayHighlight: true,  
            });
         
            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
         
        });
         
         
         
        function add_barang()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add barang'); // Set Title to Bootstrap modal title
         
            $('#photo-preview1').hide(); // hide photo preview modal
         
            $('#label-photo1').text('Upload Photo'); // label photo upload

            $('#photo-preview2').hide(); // hide photo preview modal
         
            $('#label-photo2').text('Upload Photo'); // label photo upload

            $('#photo-preview3').hide(); // hide photo preview modal
         
            $('#label-photo3').text('Upload Photo'); // label photo upload
        }
         
        function edit_barang(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
         
         
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('admin/Barang/ajax_edit')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
         
                    $('[name="id_barang"]').val(data.id_barang);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="id_kategori_barang"]').val(data.id_kategori_barang);
                    $('[name="id_subkategori"]').val(data.id_subkategori);
                    $('[name="diskripsi_barang"]').val(data.diskripsi_barang);
                    $('[name="berat_barang"]').val(data.berat_barang);
                    $('[name="harga_barang"]').val(data.harga_barang);
                    $('[name="stok_barang"]').val(data.stok_barang);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit barang'); // Set title to Bootstrap modal title
         
                    $('#photo-preview1').show(); // show photo preview modal
                    $('#photo-preview2').show(); // show photo preview modal
                    $('#photo-preview3').show(); // show photo preview modal
         
                    if(data.foto1_barang)
                    {
                        $('#label-photo1').text('Change Photo'); // label photo upload
                        $('#photo-preview1 div').html('<img src="'+base_url+'asset/galery/'+data.foto1_barang+'" class="img-responsive">'); // show photo
                        $('#photo-preview1 div').append('<input type="checkbox" name="remove_photo1" value="'+data.foto1_barang+'"/> Remove photo when saving'); // remove photo
         
                    }
                    else
                    {
                        $('#label-photo1').text('Upload Photo'); // label photo upload
                        $('#photo-preview1 div').text('(No photo)');
                    }

                    if(data.foto2_barang)
                    {
                        $('#label-photo2').text('Change Photo'); // label photo upload
                        $('#photo-preview2 div').html('<img src="'+base_url+'asset/galery/'+data.foto2_barang+'" class="img-responsive">'); // show photo
                        $('#photo-preview2 div').append('<input type="checkbox" name="remove_photo2" value="'+data.foto2_barang+'"/> Remove photo when saving'); // remove photo
         
                    }
                    else
                    {
                        $('#label-photo2').text('Upload Photo'); // label photo upload
                        $('#photo-preview2 div').text('(No photo)');
                    }

                    if(data.foto3_barang)
                    {
                        $('#label-photo3').text('Change Photo'); // label photo upload
                        $('#photo-preview3 div').html('<img src="'+base_url+'asset/galery/'+data.foto3_barang+'" class="img-responsive">'); // show photo
                        $('#photo-preview3 div').append('<input type="checkbox" name="remove_photo3" value="'+data.foto3_barang+'"/> Remove photo when saving'); // remove photo
         
                    }
                    else
                    {
                        $('#label-photo3').text('Upload Photo'); // label photo upload
                        $('#photo-preview3 div').text('(No photo)');
                    }
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
         
        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }
         
        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;
         
            if(save_method == 'add') {
                url = "<?php echo site_url('admin/Barang/ajax_add')?>";
            } else {
                url = "<?php echo site_url('admin/Barang/ajax_update')?>";
            }
         
            // ajax adding data to database
         
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url : url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data)
                {
         
                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
                }
            });
        }
         
        function delete_barang(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('admin/Barang/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
         
            }
        }
         
        </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Data Barang</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id_barang"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Barang</label>
                                <div class="col-md-9">
                                    <input name="nama_barang" placeholder="Nama Barang" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pilih Kategori</label>
                                <div class="col-md-9">
                                    <select name="id_kategori_barang" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php
                                        foreach($katbarang as $a){
                                            echo "<option value='".$a->id_kategori_barang."'>".$a->nama_kategori_barang."</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pilih Sub Kategori</label>
                                <div class="col-md-9">
                                    <select name="id_subkategori" class="form-control" required>
                                        <option value="">-- Pilih Sub Kategori --</option>
                                        <?php
                                        foreach($subkatbarang as $b){
                                            echo "<option value='".$b->id_subkategori."'>".$b->nama_subkategori."</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Desikripsi Barang</label>
                                <div class="col-md-9">
                                    <textarea name="diskripsi_barang" cols="57" rows="5" required></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Berat Barang</label>
                                <div class="col-md-9">
                                    <input name="berat_barang" placeholder="Berat Barang dalam bentuk Gram(gr)" class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Harga Barang</label>
                                <div class="col-md-9">
                                    <input name="harga_barang" placeholder="Harga Barang" class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Stok Barang</label>
                                <div class="col-md-9">
                                    <input name="stok_barang" placeholder="Stok Barang" class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group" id="photo-preview1">
                                <label class="control-label col-md-3">Photo 1</label>
                                <div class="col-md-9">
                                    (No photo)
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" id="label-photo1">Upload Photo 1 </label>
                                <div class="col-md-9">
                                    <input name="foto1_barang" type="file">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group" id="photo-preview2">
                                <label class="control-label col-md-3">Photo 2</label>
                                <div class="col-md-9">
                                    (No photo)
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" id="label-photo2">Upload Photo 2 </label>
                                <div class="col-md-9">
                                    <input name="foto2_barang" type="file">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group" id="photo-preview3">
                                <label class="control-label col-md-3">Photo 3</label>
                                <div class="col-md-9">
                                    (No photo)
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" id="label-photo3">Upload Photo 3 </label>
                                <div class="col-md-9">
                                    <input name="foto3_barang" type="file">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
<?php
$this->load->view('admin/template/foot');
?>