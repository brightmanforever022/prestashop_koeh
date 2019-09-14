<?php

require_once _PS_TOOL_DIR_ .'CurlWrapper/CurlWrapper.php';

class GalleryManager
{
    const PHOTO_FOLDER = 'khlphotogallery/photos';
    
    protected $curlWrapper;
    
    /**
     * 
     * @param GallerySource $gallerySource
     */
    public function downloadFromSource(GallerySource $gallerySource, $additionalParams = array())
    {
        
        $messages = array(
            'errors' => array(),
            'notes' => array()
        );
        if( $gallerySource->kind == GallerySource::KIND_LINK ){
            
            try{
                $sourceData = $this->downloadFromUrl($gallerySource->path);
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                if( _PS_MODE_DEV_ ){
                    $messages['errors'][] = $e->getTraceAsString();
                }
                return $messages;
            }

            $urlParts = self::parseUrl($gallerySource->name);
            $filename = $urlParts['file'];
            $randStr = uniqid();
            $filenameNew = preg_replace('#\.([^\.]+)$#', '-'.$randStr .'.$1', $filename);

            try{
                $this->store($sourceData->body, $filenameNew);
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                return $messages;
            }
            
            $galleryItem = new GalleryItem();
            $galleryItem->id_gallery_source = $gallerySource->id;
            $galleryItem->filename = $filenameNew;
            
            try{
                $galleryItem->save();
            }
            catch( Exception $e ){
                return $messages['errors'][] = $e->getMessage();
            }
            
            $messages['notes'][] = 'Downloaded image from "'. $gallerySource->name .'"';
        }
        elseif( $gallerySource->kind == GallerySource::KIND_SKU ){
            $productImageData = Db::getInstance()->getRow('
                SELECT p.id_product, i.id_image, p.supplier_reference
                FROM '._DB_PREFIX_.'product p 
                INNER JOIN '._DB_PREFIX_.'image i ON p.id_product = i.id_product
                WHERE p.supplier_reference = "'. pSQL($gallerySource->name) .'"
                    AND i.cover = 1
            ');
            if( !is_array($productImageData) || empty($productImageData['id_image']) ){
                $messages['errors'] = 'Image not found for "'. $gallerySource->name .'"';
                return $messages;
            }
            
            $imageFileName = str_replace(' ', '-', $gallerySource->name);
            
            $imageUrl = Context::getContext()->link->getImageLink($imageFileName, $productImageData['id_image']);
            
            try{
                $sourceData = $this->downloadFromUrl($imageUrl);
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                if( _PS_MODE_DEV_ ){
                    $messages['errors'][] = $e->getTraceAsString();
                }
                return $messages;
            }
            
            $randStr = uniqid();
            $filenameNew = preg_replace('#\.([^\.]+)$#', '-'.$randStr .'.$1', $imageFileName .'.jpg');
            
            try{
                $this->store($sourceData->body, $filenameNew);
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                return $messages;
            }
            
            if( !empty($additionalParams['place_code'])
                || !empty($additionalParams['place_price'])
                || !empty($additionalParams['place_qr_code'])
            ){
                
                try{
                    $this->processAdditionalParams($additionalParams, $productImageData, $filenameNew);
                }
                catch( Exception $e ){
                    $messages['errors'][] = $e->getMessage();
                    return $messages;
                }
                
            }
            
            
            $galleryItem = new GalleryItem();
            $galleryItem->id_gallery_source = $gallerySource->id;
            $galleryItem->filename = $filenameNew;
            
            try{
                $galleryItem->save();
            }
            catch( Exception $e ){
                return $messages['errors'][] = $e->getMessage();
            }
            
            $messages['notes'][] = 'Downloaded image for "'. $gallerySource->name .'"';
            
        }
        
        return $messages;
    }
    
    public function downloadFromGoogleDriveFolder(GallerySource $gallerySource, $additionalParams = array())
    {
        $messages = array(
            'errors' => array(),
            'notes' => array()
        );
        $siteUrl = Context::getContext()->shop->getBaseURL(true, true);
        $gdApiKey = Configuration::get('KHLPGAL_GGL_DRV_API_KEY');
        $folderContentUrl = "https://www.googleapis.com/drive/v3/files?q='{$additionalParams['gdFolderId']}'+in+parents&key={$gdApiKey}&pageSize=1000";
        
        //$messages = array();
        
        if( empty($this->curlWrapper) ){
            $this->curlWrapper = new CurlWrapper();
        }
        
        $this->curlWrapper->reset();
        $this->curlWrapper->addHeader('Authorization', 'Bearer '.$additionalParams['gdAccessToken']);
        $this->curlWrapper->addHeader('Referer', $siteUrl);
        
        if( _PS_MODE_DEV_ ){
            $this->curlWrapper->addOption(CURLOPT_SSL_VERIFYPEER, false);
        }
        
        try{
            $folderResponse = $this->curlWrapper->get($folderContentUrl);
            $transferInfo = $this->curlWrapper->getTransferInfo();
        }
        catch( Exception $e ){
            $messages['errors'][] = 'Request failed "'.$folderContentUrl.'". '. $e->getMessage() ;
            return $messages;
        }
        
        if( $transferInfo['http_code'] != 200 ){
            $messages['errors'][] = 'Request failed. Response code: '. $transferInfo['http_code'] . '. '. $folderContentUrl;
            return $messages;
        }
        
        $folderContent = json_decode($folderResponse);
        
        foreach( $folderContent->files as $i => $file ){
            if( _PS_MODE_DEV_ && $i > 3 ){
                break;
            }
            if( !preg_match('#^image/jpe?g$#', $file->mimeType) ){
                continue;
            }
            
            $fileContentUrl = "https://www.googleapis.com/drive/v3/files/{$file->id}?alt=media";
            try{
                $fileResponse = $this->curlWrapper->get($fileContentUrl);
                $transferInfo = $this->curlWrapper->getTransferInfo();
            }
            catch( Exception $e ){
                $messages['errors'][] = 'Request failed "'.$fileContentUrl.'". '. $e->getMessage();
                continue;
            }
            
            if( ($transferInfo['http_code'] != 200) ){
                $fileError = 'Error requesting "'. $file->name .'":'
                    .' HTTP code = '. $transferInfo['http_code'] .') ';
                if( preg_match('#application/json#', $transferInfo['content_type']) ){
                    $fileResponseErrors = json_decode($fileResponse);
                    $fileError .= $fileResponseErrors->errors->message;
                }
                $messages['errors'][] = $fileError;
                continue;
            }
            
            $randStr = uniqid();
            $filenameNew = preg_replace('#\.([^\.]+)$#', '-'.$randStr .'.$1', $file->name);
            
            try{
                $this->store($fileResponse, $filenameNew);
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                continue;
            }
            
            $galleryItem = new GalleryItem();
            $galleryItem->id_gallery_source = $gallerySource->id;
            $galleryItem->filename = $filenameNew;
            
            try{
                $galleryItem->save();
            }
            catch( Exception $e ){
                $messages['errors'][] = $e->getMessage();
                continue;
            }
            
            $messages['notes'][] = 'Downloaded image "'. $file->name .'"';
            
        }
        
        return $messages;
    }
    
    protected function processAdditionalParams($additionalParams, $productImageData, $imageName)
    {
        $text = '';
        $productReference = $productImageData['supplier_reference'];
        $productPrice = Product::getPriceStatic($productImageData['id_product'], false);
        $productPriceFormatted = number_format($productPrice, 0) . ',-€';
        
        if( !empty($additionalParams['place_code']) && !empty($additionalParams['place_price']) ){
            $text .= $productReference . "\n\r". $productPriceFormatted;
        }
        elseif( !empty($additionalParams['place_code']) ){
            $text .= $productReference;
        }
        elseif( !empty($additionalParams['place_price']) ){
            $text .= $productPriceFormatted;
        }
        
        $imageFullPath = $this->getPhotosFolder() . DIRECTORY_SEPARATOR . $imageName;
        
        $promoImage = new PromoImageProcessor($imageFullPath);
        
        if( strlen($text) ){
            $promoImage->placeRefPriceText($text);
        }
        
        if( !empty($additionalParams['place_qr_code']) ){
            $promoImage->placeQRCode($productReference);
        }
        
        $promoImage->save();
        
        
    }
    
    protected function downloadFromUrl($url, $headers = array())
    {
        $responseData = new stdClass();
        $responseData->body = null;
        $responseData->transfer_info = null;
        
        if( empty($this->curlWrapper) ){
            $this->curlWrapper = new CurlWrapper();
        }
        
        $this->curlWrapper->reset();

        try{
            $response = $this->curlWrapper->get($url);
            $responseData->body = $response;
            $responseData->transfer_info = $this->curlWrapper->getTransferInfo();
        }
        catch( Exception $e ){
            throw new Exception( 'Request failed "'.$url.'". '. $e->getMessage() );
        }
        
        if( $responseData->transfer_info['http_code'] != 200 ){
            throw new Exception( 'Request failed. Response code: '. $responseData->transfer_info['http_code'] . '. '. $url);
        }
        
        if( !preg_match('#^image/jpe?g$#', $responseData->transfer_info['content_type']) ){
            throw new Exception( 'Returned response is not an image. Content type is: '. $responseData->transfer_info['content_type'] .' '. $url );
        }
        
        return $responseData;
    }
    
    public function store($binStr, $name)
    {
        $filePath = _PS_MODULE_DIR_ . self::PHOTO_FOLDER . DIRECTORY_SEPARATOR . $name;
        
        if( file_put_contents($filePath, $binStr) === false){
            throw new Exception('File can not be saved "'.$filePath.'"');
        }
        
        return true;
    }
    
    protected function getPhotosFolder()
    {
        return _PS_MODULE_DIR_ . self::PHOTO_FOLDER;
    }
    
    public function placeAnnotation()
    {
        
    }
    
    public function unstore($name)
    {
        $filePath = _PS_MODULE_DIR_ . self::PHOTO_FOLDER . DIRECTORY_SEPARATOR . $name;
        
        return @unlink($filePath);
    }
    

    /**
     * @return array|false
     * Returns:
     Array
     (
     [0] => me:you@sub.site.org:29000/pear/validate.html?happy=me&sad=you#url
     [scheme] =>
     [1] =>
     [login] => me
     [2] => me
     [pass] => you
     [3] => you
     [host] => sub.site.org
     [4] => sub.site.org
     [subdomain] => sub
     [5] => sub
     [domain] => site.org
     [6] => site.org
     [extension] => org
     [7] => org
     [port] => 29000
     [8] => 29000
     [path] => /pear/validate.html
     [9] => /pear/validate.html
     [file] => validate.html
     [10] => validate.html
     [arg] => happy=me&sad=you
     [11] => happy=me&sad=you
     [anchor] => url
     [12] => url
     )
     */
    public static function parseUrl($url)
    {
        $r  = "^(?:(?P<scheme>\w+)://)?";
        $r .= "(?:(?P<login>\w+):(?P<pass>\w+)@)?";
        $r .= "(?P<host>(?:(?P<subdomain>[\w\.]+)\.)?" . "(?P<domain>\w+\.(?P<extension>\w+)))";
        $r .= "(?::(?P<port>\d+))?";
        $r .= "(?P<path>[\w/]*/(?P<file>[[\w\-\_\.\s\%]+(?:\.\w+)?)?)?";
        $r .= "(?:\?(?P<arg>[\w=&]+))?";
        $r .= "(?:#(?P<anchor>\w+))?";
        $r = "!$r!";
        
        $out = array();
        if( preg_match ( $r, $url, $out ) ){
            return $out;
        }
        else{
            return false;
        }
        
    }
    
}

