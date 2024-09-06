<?php if($this->input->post('id_department_filter') == $id_department): ?>
<button class="btn btn-xs btn-flat btn-danger" type='button' onclick='return pilih_department_filter_salesman_target_salesman_selling_price(<?= $data ?>, "reset_filter")' data-dismiss='modal'><i class="fa fa-trash-o"></i></button>
<?php else: ?>
<button class="btn btn-xs btn-flat btn-success" type='button' onclick='return pilih_department_filter_salesman_target_salesman_selling_price(<?= $data ?>, "add_filter")' data-dismiss='modal'><i class="fa fa-check"></i></button>
<?php endif; ?>