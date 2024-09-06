<?php if($this->input->post('nama_wilayah_filter') == $nama_wilayah_filter): ?>
<button class="btn btn-xs btn-flat btn-danger" type='button' onclick='return pilih_wilayah_filter_monitoring_supply(<?= $data ?>, "reset_filter")' data-dismiss='modal'><i class="fa fa-trash-o"></i></button>
<?php else: ?>
<button class="btn btn-xs btn-flat btn-success" type='button' onclick='return pilih_wilayah_filter_monitoring_supply(<?= $data ?>, "add_filter")' data-dismiss='modal'><i class="fa fa-check"></i></button>
<?php endif; ?>