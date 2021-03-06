<table data-role="table" data-mode="columntoggle">
        <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Estado</th>
                <th rowspan="2">Clasificación</th>
                <th rowspan="2">Fecha Factura</th>
                <th colspan="2" data-priority="3">Proveedor</th>
                <th rowspan="2">Tipo Factura</th>
                <th rowspan="2" data-priority="2">N° Factura</th>
                <th rowspan="2" data-priority="1">Importe Neto</th>
<?php
foreach ($tipo_impuestos as $ti) {
    echo "<th colspan='2'  data-priority='5'>$ti</th>";
}
?>
                <th class="total" rowspan="2">Total</th>
                <th class="faltapagar" rowspan="2" data-priority="2">Falta pagar</th>
                <th class="obs" rowspan="2" data-priority="3">Observación</th>
            </tr>
            <tr>
                <td>Nombre</td>
                <td>CUIT</td>
                <?php
                foreach ($tipo_impuestos as $ti) {
                    echo "<td>Neto</td><td>Imp.</td>";
                }
                ?>
            </tr>
        </thead>

        <tbody>
<?php
foreach ($gastos as $g) {
    $classpagado = 'pagado';
    $faltaPagar = $g['Gasto']['importe_total'] - $g['Gasto']['importe_pagado'];
    if ($g['Gasto']['importe_pagado'] < $g['Gasto']['importe_total']) {
        $classpagado = 'no-pagado';
    }

    $class = !empty($g['Gasto']['cierre_id']) ? 'closed' : 'open';
    ?>
                <tr class="<?php echo $classpagado . " " . $class; ?>"><?php
                
                echo "<td>". $g['Gasto']['id'] ."</td>";

                 $estado = !empty($g['Gasto']['cierre_id']) ? 'cerrado' : 'abierto';
                 echo "<td>$estado</td>";

                if (!empty($g['Clasificacion'])) {
                    echo "<td>" . $g['Clasificacion']['name'] . "</td>";
                } else {
                    echo "<td>Sin Clasificar</td>";
                }

                echo "<td class='fecha'>" . $g['Gasto']['fecha'] . "</td>";


                if (!empty($g['Proveedor'])) {
                    echo "<td>" . $g['Proveedor']['name'] . "</td>";
                    echo "<td>" . $g['Proveedor']['cuit'] . "</td>";
                } else {
                    echo "<td></td>";
                    echo "<td></td>";
                }

                if (!empty($g['TipoFactura'])) {
                    echo "<td>" . $g['TipoFactura']['name'] . "</td>";
                } else {
                    echo "<td></td>";
                }

                echo "<td>" . $g['Gasto']['factura_nro'] . "</td>";
                echo "<td>" . $this->Number->currency( $g['Gasto']['importe_neto'] ) . "</td>";
                ?>

                    <?php
                    foreach ($tipo_impuestos as $tid => $ti) {
                        if (!empty($g['Impuesto'])) {
                            echo "<td>" . $this->Number->currency( mostrarNetoDe($tid, $g['Impuesto']) ). "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        if (!empty($g['Impuesto'])) {
                            echo "<td>" . $this->Number->currency( mostrarImpuestoDe($tid, $g['Impuesto']) ) . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                    }

                    echo "<td class='total'>" . $this->Number->currency( $g['Gasto']['importe_total'] ). "</td>";

                    echo "<td class='faltapagar'>" . $this->Number->currency( $faltaPagar ) . "</td>";
                    echo "<td class='obs'>" . $g['Gasto']['observacion'] . "</td>";
                }
                ?>
            </tr>
        </tbody>
    </table>