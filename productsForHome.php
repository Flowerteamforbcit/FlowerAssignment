<?php

require_once('init.php');
loadScripts();

$data = array("status" => "not set!");

if (Utils::isGET() && !Utils::isPOST()) {
    $pm = new ProductManager();
    $rows = $pm->listProducts();

    $html = "";
    if (!$rows || count($rows) == 0) {
        $html = "<tr><td>There are no results.</td></tr>";
    } else {

       // foreach ($rows as $row) {
            for($i = 0; $i < 4; $i++){

            $path = $rows[$i]['path'];
            $sku = $rows[$i]['SKU'];
            $price = $rows[$i]['item_price'];
            $desc = $rows[$i]['description'];


            $html .= "		<div class='col-md-3 thumbnailwrapper ' >
			<a href='#' class='thumbnail'>
			<div class='panel panel-default'>
				 <img src=$path alt=$desc style='width:150px;height:150px'>
				 <br/>
				<p data-sku-desc='$sku'>$desc</p>
				<!--
				<p>model# $sku</p>
				-->
				<strong>$</strong><strong data-sku-price='$sku'>$price</strong>
				
			</a>			
			<input data-sku-add='$sku' type='button' value='Add to cart' class='btn btn-primary btn-block'/>
			</div>
		</div>";

        }

    }

    echo $html;
    return;

} else {

        $pm = new ProductManager();
        $rows = $pm->listProducts();

        $html = "";
        if (!$rows || count($rows) == 0) {
            $html = "<tr><td>There are no results.</td></tr>";
        } else {

            foreach ($rows as $row) {
                $path = $row['path'];
                $sku = $row['SKU'];
                $price = $row['item_price'];
                $desc = $row['description'];


                $html .= "		<div class='col-md-3 thumbnailwrapper ' >
			<a href='#' class='thumbnail'>
			<div class='panel panel-default'>
				 <img src=$path alt=$desc style='width:150px;height:150px'>
				 <br/>
				<p data-sku-desc='$sku'>$desc</p>
				<!--
				<p>model# $sku</p>
				-->
				<strong>$</strong><strong data-sku-price='$sku'>$price</strong>
				
			</a>			
			<input data-sku-add='$sku' type='button' value='Add to cart' class='btn btn-primary btn-block'/>
			</div>
		</div>";

            }

        }

        echo $html;
        return;
}
echo json_encode($data, JSON_FORCE_OBJECT);


?>