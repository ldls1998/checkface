<?php
  $page_title = 'Lista de ventas';
  require_once('includes/load.php');
  
   page_require_level(3);
?>

<?php
$sales = find_all_sale();
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>


  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas la ventas</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Agregar venta</a>
          </div>
        </div>

        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Nombre del producto </th>
                <th class="text-center" style="width: 15%;"> Cantidad</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Fecha </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
             </tr>
            </thead>
          <tbody>
              <?php foreach ($sales as $sale):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk($sale['name']); ?></td>
                <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
                <td class="text-center"><?php echo $sale['date']; ?></td>
                <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-edit"></span>
                      </a>
                      <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </div>
                </td>
              </tr>
              <?php endforeach;?>
          </tbody>
         </table>
            </div>

        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Generar la boleta </span>
            

            <div class="card">
              <img class="card-img-top" src="holder.js/100x180/" alt="">
              <div class="card-body">
              

// codigo de la boleta ********
              <?php
$cliente = "Luis Cabrera Benito";
$remitente = "Carlos Bustamante";
$web = "https://parzibyte.me/blog";
$mensajePie = "Gracias por su compra";
$numero = 1;
$descuento = 0;
$porcentajeImpuestos = 16;
$productos = [
    [
        "precio" => 3,
        "descripcion" => "Gaseosa Pepsi",
        "cantidad" => 4,
    ],
    [
        "precio" => 2,
        "descripcion" => "Chocolate Sublime Clasico 30g.",
        "cantidad" => 5,
    ],
];

date_default_timezone_set('America/Lima');
$zonahoraria=new DateTime();
$fecha = date("Y-m-d  g:i a");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./bs3.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 ">
            <h1>Factura</h1>
        </div>
        <div class="col-xs-2">
            <img class="img img-responsive" src="./parzibyte.jpg" alt="Logotipo">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-10">
            <h1 class="h6"><?php echo $remitente ?></h1>
            <h1 class="h6"><?php echo $web ?></h1>
        </div>
        <div class="col-xs-2 text-center">
            <strong>Fecha</strong>
            <br>
            <?php echo $fecha ?>
            <br>
            <strong>Factura No.</strong>
            <br>
            <?php echo $numero ?>
        </div>
    </div>
    <hr>
    <div class="row text-center" style="margin-bottom: 2rem;">
        <div class="col-xs-6">
            <h1 class="h2">Cliente</h1>
            <strong><?php echo $cliente ?></strong>
        </div>
        <div class="col-xs-6">
            <h1 class="h2">Remitente</h1>
            <strong><?php echo $remitente ?></strong>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subtotal = 0;
                foreach ($productos as $producto) {
                    $totalProducto = $producto["cantidad"] * $producto["precio"];
                    $subtotal += $totalProducto;
                    ?>
                    <tr>
                        <td><?php echo $producto["descripcion"] ?></td>
                        <td><?php echo number_format($producto["cantidad"], 2) ?></td>
                        <td>$<?php echo number_format($producto["precio"], 2) ?></td>
                        <td>$<?php echo number_format($totalProducto, 2) ?></td>
                    </tr>
                <?php }
                $subtotalConDescuento = $subtotal - $descuento;
                $impuestos = $subtotalConDescuento * ($porcentajeImpuestos / 100);
                $total = $subtotalConDescuento + $impuestos;
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Subtotal</td>
                    <td>$<?php echo number_format($subtotal, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Descuento</td>
                    <td>$<?php echo number_format($descuento, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Subtotal con descuento</td>
                    <td>$<?php echo number_format($subtotalConDescuento, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Impuestos</td>
                    <td>$<?php echo number_format($impuestos, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">
                        <h4>Total</h4></td>
                    <td>
                    <h4>$<?php echo number_format($total, 2) ?></h4>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        </div>
 
              
// hasta aqui el codigo de la boleta*******

            
            
          
  

          </div>
        </div>

        
        


          </div>
        </div>
      </div>
<?php include_once('layouts/footer.php'); ?>
