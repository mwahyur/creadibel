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
            Data Sub Kategori Barang
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-success" onclick="add_subkategori()"><i class="glyphicon glyphicon-plus"></i> Add Data Sub Kategori Barang</button>
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Kategori Barang</th>
                        <th>Nama Sub Kategori Barang</th>
                        <th>Deskripsi Sub Kategori Barang</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Kategori Barang</th>
                        <th>Nama Sub Kategori Barang</th>
                        <th>Deskripsi Sub Kategori Barang</th>
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

        $(document).ready(function() {

            //datatables
            table = $('#table').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('admin/Subkategori_barang/ajax_list')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [ -1 ], //last column
                        "orderable": false, //set not orderable
                    },
                ],

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



        function add_subkategori()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Kategori Barang'); // Set Title to Bootstrap modal title
        }

        function edit_subkategori(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('admin/Subkategori_barang/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="id_subkategori"]').val(data.id_subkategori);
//                    document.getElementById(data.kecamatan).selected="true";
                    $('[name="id_kategori_barang"]').val(data.id_kategori_barang);
                    $('[name="nama_subkategori"]').val(data.nama_subkategori);
                    $('[name="deskripsi_subkategori"]').val(data.deskripsi_subkategori);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Data Kategori Barang'); // Set title to Bootstrap modal title

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
                url = "<?php echo site_url('admin/Subkategori_barang/ajax_add')?>";
            } else {
                url = "<?php echo site_url('admin/Subkategori_barang/ajax_update')?>";
            }

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
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

        function delete_subkategori(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('admin/Subkategori_barang/ajax_delete')?>/"+id,
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
                    <h3 class="modal-title">Form Data Sub Kategori Barang</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id_subkategori"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Pilih Kategori</label>
                                <div class="col-md-9">
                                    <select name="id_kategori_barang" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php
                                        foreach($kategori as $a){
                                            echo "<option value='".$a->id_kategori_barang."'>".$a->nama_kategori_barang."</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Sub Kategori</label>
                                <div class="col-md-9">
                                    <input name="nama_subkategori" placeholder="Nama Kategori" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Desikripsi Sub Kategori</label>
                                <div class="col-md-9">
                                    <textarea name="deskripsi_subkategori" cols="57" rows="5" required></textarea>
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