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
            Data produk
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                <a href="<?php echo base_url()?>admin/Claporanproduk/cetakpdf" target="_blank"><button class="btn btn-success"><i class="glyphicon glyphicon-print"></i> </button></a>
                <div class="box-tools pull-right">

                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Jenis Produk</th>
                        <th>Stok Produk</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Jenis Produk</th>
                        <th>Stok Produk</th>
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
                    "url": "<?php echo site_url('admin/admin_produk/ajax_list')?>",
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

        function formatCurrency(num) {

            num = num.toString().replace(/\Rp|/g,'');
            if(isNaN(num))
                num = "0";
            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num*100+0.50000000001);
            cents = num%100;
            num = Math.floor(num/100).toString();
            if(cents<10)
                cents = "0" + cents;
            for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
                num = num.substring(0,num.length-(4*i+3))+'.'+
                num.substring(num.length-(4*i+3));
            return ((sign)?'':'-') + 'Rp ' + num + ',' + cents;

        }

        function show_produk(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('admin/admin_produk/ajax_show/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="idproduk"]').val(data.idproduk);
                    $('[name="kodeproduk"]').val(data.kodeproduk);
                    $('[name="barcode"]').val(data.barcode);
                    $('[name="namaproduk"]').val(data.namaproduk);
                    $('[name="hargajual"]').val(formatCurrency(data.hargajual));
                    $('[name="hargabeli"]').val(formatCurrency(data.hargabeli));
                    $('[name="discount"]').val(data.discount+" %");
                    $('[name="jenisproduk"]').val(data.jenisproduk);
                    $('[name="stok"]').val(data.stok+" produk");
                    $('[name="kodejenis"]').val(data.kodejenis);
                    $('[name="keuntungan"]').val(data.keuntungan);
                    $('[name="supplier"]').val(data.supplier);
                    $('[name="jenis"]').val(data.jenis);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Detail Data Produk'); // Set title to Bootstrap modal title

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



    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Detail Data produk</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="idproduk"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Kode Produk</label>
                                <div class="col-md-9">
                                    <input name="kodeproduk" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Barcode produk</label>
                                <div class="col-md-9">
                                    <input name="barcode" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama produk</label>
                                <div class="col-md-9">
                                    <input name="namaproduk" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Harga Jual</label>
                                <div class="col-md-9">
                                    <input name="hargajual" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Harga Beli</label>
                                <div class="col-md-9">
                                    <input name="hargabeli" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Discount</label>
                                <div class="col-md-9">
                                    <input name="discount" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Jenis produk</label>
                                <div class="col-md-9">
                                    <input name="jenisproduk" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Stok produk</label>
                                <div class="col-md-9">
                                    <input name="stok" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kode Jenis produk</label>
                                <div class="col-md-9">
                                    <input name="kodejenis" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Keuntungan</label>
                                <div class="col-md-9">
                                    <input name="keuntungan" placeholder="Stok produk" class="form-control" type="number" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Supplier</label>
                                <div class="col-md-9">
                                    <input name="supplier" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Jenis</label>
                                <div class="col-md-9">
                                    <input name="jenis" placeholder="Kriteria" class="form-control" type="text" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
<?php
$this->load->view('admin/template/foot');
?>