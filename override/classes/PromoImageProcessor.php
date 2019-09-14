<?php

require_once _PS_TOOL_DIR_ .'phpqrcode/phpqrcode.php';

class PromoImageProcessor
{
    public $imagePath;
    
    public $imageInfo;
    
    protected $refPriceTextDimensions = null;
    
    protected $imageResource;
    
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
        
        $this->imageInfo = getimagesize($this->imagePath);
        if( $this->imageInfo === false ){
            throw new Exception( 'Unable to get image info : "'.$this->imagePath.'"' );
        }
        
        
        $this->imageResource = @imagecreatefromjpeg($this->imagePath);
        if( !$this->imageResource ){
            throw new Exception( 'Failed init image from: "'.$this->imagePath.'"' );
        }
    }
    
    public function placeRefPriceText($text)
    {
        $blackColor = imagecolorallocate($this->imageResource, 0, 0, 0);
        $whiteColor = imagecolorallocate($this->imageResource, 255, 255, 255);
        
        $fontPath = _PS_FONT_DIR . 'OpenSans-Semibold.ttf';
        $fontSize = 30;
        
        // box's size for text
        $textBoundBox = imagettfbbox ($fontSize, 0, $fontPath, $text);
        $textWidth = abs($textBoundBox[4] - $textBoundBox[0]);
        $textHeight = abs($textBoundBox[5] - $textBoundBox[1]);
        // coordinates for box
        $imageTextX = $this->imageInfo[0] - $textWidth - $fontSize;
        $imageTextY = $this->imageInfo[1] - $textHeight - $fontSize;
        
        $this->refPriceTextDimensions = array('x','y','w','h');
        $this->refPriceTextDimensions['x'] = $imageTextX;
        $this->refPriceTextDimensions['y'] = $imageTextY;
        $this->refPriceTextDimensions['w'] = $textWidth;
        $this->refPriceTextDimensions['h'] = $textHeight;
        
        $textShadowOnImage = imagettftext($this->imageResource, $fontSize, 0, $imageTextX+2, $imageTextY+2, $whiteColor, $fontPath, $text);
        $textOnImage = imagettftext($this->imageResource, $fontSize, 0, $imageTextX, $imageTextY, $blackColor, $fontPath, $text);
        
        if( $textOnImage === false ){
            throw new Exception( 'Text not added to : "'.$this->imagePath.'"' );
        }
        
        return true;
    }
    
    public function placeQRCode($codeText)
    {
        $tempFilePath = _PS_TMP_IMG_DIR_ . DIRECTORY_SEPARATOR . uniqid() .'.png';
        QRcode::png($codeText, $tempFilePath, QR_ECLEVEL_M, 4, 0, false, true);

        $barcodeImageInfo = getimagesize($tempFilePath);
        if( !isset($barcodeImageInfo[0]) || empty($barcodeImageInfo[0]) || !isset($barcodeImageInfo[1]) || empty($barcodeImageInfo[1]) ){
            @unlink($tempFilePath);
            throw new Exception('Barcode file "'.$tempFilePath.'" invalid');
        }
        
        $barcodeImageRes = imagecreatefrompng($tempFilePath);
        if( $barcodeImageRes === false ){
            @unlink($tempFilePath);
            throw new Exception('Image not initied from barcode stream');
        }
        
        if( is_array($this->refPriceTextDimensions) && count($this->refPriceTextDimensions) ){
            $barcodePosX = $this->refPriceTextDimensions['x'] + $this->refPriceTextDimensions['w'] 
                - $barcodeImageInfo[0];
            $barcodePosY = $this->refPriceTextDimensions['y'] - $barcodeImageInfo[1] - ($barcodeImageInfo[1] / 2);
        }
        else{
            $barcodePosX = $this->imageInfo[0] - $barcodeImageInfo[0] - ($barcodeImageInfo[0] / 2);
            $barcodePosY = $this->imageInfo[1] - $barcodeImageInfo[1] - ($barcodeImageInfo[1] / 2);
        }
        
        imagealphablending($barcodeImageRes, false);
        imagesavealpha($barcodeImageRes, true);
        imagealphablending($this->imageResource, false);
        imagesavealpha($this->imageResource, true);
        
        $white = imagecolorallocatealpha($barcodeImageRes, 0, 0, 0, 127);
        imagecolortransparent($barcodeImageRes, $white);
        
        if( !imagecopymerge($this->imageResource, $barcodeImageRes, $barcodePosX, $barcodePosY, 0, 0, 
            $barcodeImageInfo[0], $barcodeImageInfo[1], 100))
        {
            @unlink($tempFilePath);
            throw new Exception('Barcode not positionaed on destination');
        }
        
        imagedestroy($barcodeImageRes);
        @unlink($tempFilePath);
        
        return true;
    }
    
    public function save()
    {
        if( !imagejpeg($this->imageResource, $this->imagePath) ){
            imagedestroy($this->imageResource);
            throw new Exception( 'Image not saved to : "'.$this->imagePath.'"' );
        }
        imagedestroy($this->imageResource);
        return true;
    }
}