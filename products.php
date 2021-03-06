<?php

require_once('init.php');
loadScripts();

$data = array("status" => "not set!");

 if (Utils::isGET()) {
    $pm = new ProductManager();
    $rows = $pm->listProducts();

    $html = "";
    if (!$rows || count($rows) == 0) {
        $html = "<tr><td>There are no results.</td></tr>";
    } else {

        foreach ($rows as $row) {
            $sku = $row['SKU'];
            $price = $row['item_price'];
            $desc = $row['description'];
            $stock =$row['Quantity'];
            $path = $row['path'];

            $html .= "<tr>
            <td><img src='$path' height='60' width='45'/></td>
            <td data-sku-desc='$sku'>$desc</td>
            <td><input data-sku-qty='$sku' type='number' value='1' min='1' max='10' step='1'/>/$stock</td>

            <td data-sku-price='$sku'>$price</td>
            <td><input data-sku-add='$sku' type='button' value='Add'/></td>
            </tr>";
        }

    }

    echo $html;
    return;

} else {
    $data = array("status" => "error", "msg" => "Only GET allowed.");

}

echo json_encode($data, JSON_FORCE_OBJECT);


?>
