<!-- Modal -->
<div id="h3_md_salesman_filter_target_salesman_selling_price" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Salesman</h4>
            </div>
            <div class="modal-body">
                <table id="h3_md_salesman_filter_target_salesman_selling_price_datatable" class="table table-striped table-bordered table-hover table-condensed" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NPK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <script>
                $(document).ready(function() {
                    h3_md_salesman_filter_target_salesman_selling_price_datatable = $('#h3_md_salesman_filter_target_salesman_selling_price_datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        order: [],
                        ajax: {
                            url: "<?= base_url('api/md/h3/salesman_filter_target_salesman_selling_price') ?>",
                            dataSrc: "data",
                            type: "POST",
                            data: function(d){
                                d.filters = salesmanFilter.salesmans;
                            }
                        },
                        columns: [
                            { data: 'index', orderable: false, width: '3%' },
                            { data: 'npk' },
                            { data: 'nama_lengkap' },
                            { data: 'jabatan' },
                            { data: 'action', orderable: false, className: 'text-center', width: '3%' }
                        ],
                    });
                });
                </script>
            </div>
        </div>
    </div>
</div>