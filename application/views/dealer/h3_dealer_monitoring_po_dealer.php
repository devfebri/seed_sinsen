<style type="text/css">
    .myTable1 {
        margin-bottom: 0px;
    }

    .myt {
        margin-top: 0px;
    }

    .isi {
        height: 25px;
        padding-left: 4px;
        padding-right: 4px;
    }

    .vertical-text {
        writing-mode: lr-tb;
        text-orientation: mixed;
    }

    .rotate {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
    }

    #mySpan {
        writing-mode: vertical-lr;
        transform: rotate(180deg);
    }
</style>

<base href="<?php echo base_url(); ?>" />
<?php
if ($set == "view") {
?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $title; ?>
            </h1>

            <ol class="breadcrumb">
                <li><a href="panel/home"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="">H2</li>
                <li class="">3 Axis Analysis</li>
                <li class="active"><?php echo ucwords(str_replace("_", " ", $isi)); ?></li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="post" action="dealer/h3_dealer_monitoring_po_dealer/downloadReport" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control datepicker" name="tgl1" value="<?= date('Y-m-d') ?>" id="tanggal1">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control datepicker" name="tgl2" value="<?= date('Y-m-d') ?>" id="tanggal2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Pilihan Format</label>
                                        <div class="col-sm-4">
                                            <select class="form-select form-control" name="type" aria-label="Default select example">
                                                <option value="">-pilih-</option>
                                                <option selected value="Hotline">Hotline</option>
                                                <option value="Reguler">Reguler</option>
                                                <option value="Fix">Fix</option>
                                                <option value="Urgent">Urgent</option>
                                            </select>
                                            <br>
                                            <span class="badge font-sm" style="background-color: green;"><i>Pilihan format baru selesai yang hotline</i></span>
                                        </div>
                                    </div>

                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="col-sm-12" align="center">
                                        <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-download"></i> Download .xls</button>
                                        <!-- <button type="submit" id="btnLoad"  name="process" value="load"  class="btn btn-primary btn-flat"><i class="fa fa-eye"></i> Load</button> -->

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->

            </body>

            </html>
        </section>
    </div>
<?php } ?>