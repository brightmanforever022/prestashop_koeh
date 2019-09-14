<?php

require_once _PS_TOOL_DIR_ . 'mpdf/mpdf.php';
require_once _PS_TOOL_DIR_ . 'ashberg-barcode/php-barcode.php';

class ProductLabel
{
    static public function generatePdf($labelsData)
    {
        set_time_limit(0);
        
        $imgUrl = 'https://www.koehlert.com/img/koehlert-logo-label.jpg';
        $sizesTable = array(
            32 => array('D' => '32', 'FR' => '34', 'IT' => '38', 'UK' => '6', 'US' => '2'),
            34 => array('D' => '34', 'FR' => '36', 'IT' => '40', 'UK' => '8', 'US' => '4'),
            36 => array('D' => '36', 'FR' => '38', 'IT' => '42', 'UK' => '10', 'US' => '6'),
            38 => array('D' => '38', 'FR' => '40', 'IT' => '44', 'UK' => '12', 'US' => '8'),
            40 => array('D' => '40', 'FR' => '42', 'IT' => '46', 'UK' => '14', 'US' => '10'),
            42 => array('D' => '42', 'FR' => '44', 'IT' => '48', 'UK' => '16', 'US' => '12'),
            44 => array('D' => '44', 'FR' => '46', 'IT' => '50', 'UK' => '18', 'US' => '14'),
            46 => array('D' => '46', 'FR' => '48', 'IT' => '52', 'UK' => '20', 'US' => '16'),
            48 => array('D' => '48', 'FR' => '50', 'IT' => '54', 'UK' => '22', 'US' => '18'),
            50 => array('D' => '50', 'FR' => '52', 'IT' => '56', 'UK' => '24', 'US' => '20'),
            52 => array('D' => '52', 'FR' => '54', 'IT' => '58', 'UK' => '26', 'US' => '22'),
            54 => array('D' => '54', 'FR' => '56', 'IT' => '60', 'UK' => '28', 'US' => '24'),
            56 => array('D' => '56', 'FR' => '58', 'IT' => '62', 'UK' => '30', 'US' => '26'),
        );
        
        $mpdf = new mPDF('utf-8', array(41,89), 0, '', 2, 2, 5, 5, 0, 0);
        
        $html = "";
        
        foreach($labelsData as $k => $val) {
            
            if($k){
                $html .= "<pagebreak>";
            }
            
            $ean13 = $val['ean13'];
            
            $barcodeStream = null;
            if( !empty($ean13) ){
                //$barcode = new Barcode($ean13, 2);
                ob_start();
                //$barcode->display();
                barcode_print($ean13,'ANY',2,'png');
                $barcodeStream = ob_get_contents();
                ob_end_clean();
            }
            
            $copies = intval($val['quantity']);
            
            for( $li = 0; $li < $copies; $li++ ){
                if($li){
                    $html .= "<pagebreak>";
                }
                
                $html .= "<div style='padding-top:5px;'><img src='$imgUrl' alt=''></div>";
                //$html .= "<div><br></div>";
                $html .= "<div style='font-family: Arial; font-size: 12px; text-align: center; font-weight: bold; margin-top: 15px'>Artikelnr. / Style:</div>";
                $html .= "<div style='font-family: Arial; font-size: 12px; text-align: center;'>".$val['supplier_reference']."</div>";
                //$html .= "<br>";
                $html .= "<div style='font-family: Arial; font-size: 12px; text-align: center; font-weight: bold; margin-top: 15px'>Farbe / Color:</div>";
                // echo "<br>";
                $html .= "<div style='font-family: Arial; font-size: 12px; text-align: center; padding: 0px'>".$val['name']. "</div>";
                $html .= "<hr style='color:black;'>";
                $html .= "<table style='width:100%'>
                <tr>
                <td style='font-family: Arial; font-size: 12px;text-align: left;width:33%;'><b>D</b><br>{$sizesTable[$val['size']]['D']}</td>
                <td style='font-family: Arial; font-size: 12px;text-align: center;width:33%;'><b>FR</b><br>{$sizesTable[$val['size']]['FR']}</td>
                <td style='font-family: Arial; font-size: 12px;text-align: right;width:33%;'><b>IT</b><br>{$sizesTable[$val['size']]['IT']}</td>
                </tr>
                <tr><td colspan='10'></td></tr>
                <tr>
                <td style='font-family: Arial; font-size: 12px;text-align: left;width:33%;'><b>UK</b><br>{$sizesTable[$val['size']]['UK']}</td>
                <td style='font-family: Arial; font-size: 12px;text-align: center;width:33%;'><b>US</b><br>{$sizesTable[$val['size']]['US']}</td>
                <td style='font-family: Arial; font-size: 12px;text-align: right;width:33%;'></td>
                </tr>
                
                </table>";
                if(!empty($barcodeStream)){
                    $html .= "<div style='margin-top:25px;'><img src='data: image/png;base64,". base64_encode( $barcodeStream ) ."'></div>";
                }
            }
        }
        
        //$html = ob_get_contents();
        
        //ob_end_clean();
        
        //echo $html;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        
        die;
        
    }
}

