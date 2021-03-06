<?php
if ( empty($modelName) ) {
    $modelName = Inflector::classify($this->name);
}
echo $this->Form->create($modelName, array(
    'url' => array('controller' => $this->name,'action' => $this->action), 
    'type' => 'get', 
    'name' => 
    'gasto_x_mes'
    ));
?>

<style>
    .ui-field-contain .ui-select {
        width: 90%;
    }
    
</style>

<div class="row">
    <div class="col-sm-2">
        <?php
        echo $this->Form->input('tipo_cierre', array(
            'label' => 'Estado',
            'options' => array(
                'a' => 'Abierto',
                'c' => 'Cerrado',
            ),
            'label' => false,
            'empty' => 'Estado',
            'placeholder' => 'Estado',
            ));
        ?>
    </div>

    <?php if (!empty($proveedores)) { ?>
    <div class="col-sm-2">
        <?php
            echo $this->Form->input('proveedor_id', array(
                'label'=>false, 
                'empty' => 'Proveedor',
                'placeholder' => 'Proveedor'));
                ?>
        
    </div>
    <?php } ?>


     <?php if (!empty($clasificaciones)) { ?>
    <div class="col-sm-2">
       <?php
        echo $this->Form->input('clasificacion_id', array(
            'empty' => 'Clasificacion',
            'label'=>false));
        ?>
    </div>
    <?php } ?>

    
    <div class="col-sm-2">
        <?php
        echo $this->Form->input('fecha_desde', array('label'=>false, 'type' => 'date', 'placeholder'=>'Desde'));
        ?>
    </div>
    <div class="col-sm-2">
        <?php
        echo  $this->Form->input('fecha_hasta', array('label'=>false, 'placeholder'=>'Hasta', 'type' => 'date'));
        ?>
    </div>
    <div class="col-sm-1">
        <?php
        echo  $this->Form->input('importe_neto', array('label'=>false, 'placeholder'=>'Neto', 'required' => false, 'type' => 'number'));
        ?>
    </div>
    <div class="col-sm-1">
        <?php
        echo  $this->Form->button('Buscar', array('class'=>'btn btn-primary', 'type'=>'submit'));
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<?php echo $this->Form->end(); ?>