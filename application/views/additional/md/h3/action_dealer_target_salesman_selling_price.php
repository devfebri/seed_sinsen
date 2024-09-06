<?php
    $state = '';

    if(count($this->input->post('selected_id_dealer')) > 0){
        if(in_array($id_dealer, $this->input->post('selected_id_dealer'))){
            $state = 'disabled';
        }
    }
?>
<button <?= $state ?> onclick='return pilih_dealer_target_salesman_selling_price(<?= $data ?>)' data-dismiss='modal' class="btn btn-xs btn-flat btn-success" type="button"><i class="fa fa-check"></button>