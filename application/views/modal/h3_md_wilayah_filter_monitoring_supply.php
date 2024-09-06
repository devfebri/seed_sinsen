<!-- Modal -->
<div id="h3_md_wilayah_filter_monitoring_supply" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Customer</h4>
        </div>
        <div class="modal-body">
            <table id="h3_md_wilayah_filter_monitoring_supply_datatable" class="table table-striped table-bordered table-hover table-condensed" style="width: 100%">
                <thead>
                    <tr>
                        <th>Wilayah</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <script>
            $(document).ready(function() {
                h3_md_wilayah_filter_monitoring_supply_datatable = $('#h3_md_wilayah_filter_monitoring_supply_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "<?= base_url('api/md/h3/wilayah_h3_filter_monitoring_supply') ?>",
                        dataSrc: "data",
                        type: "POST",
                        data: function(d){
                            d.nama_wilayah_filter = $('#nama_wilayah_filter').val();
                        }
                    },
                    columns: [
                        { data: 'daerah_h3' },
                        { data: 'action', orderable: false, className: 'text-center', width: '3%' }
                    ],
                });
            });
            </script>
        </div>
        </div>
    </div>
</div>