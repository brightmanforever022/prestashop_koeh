<?php



class AdminPhotoGalleryController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'gallery_source';
        $this->list_id = 'gallery_source';
        $this->className = 'GallerySource';
        $this->identifier = 'id_gallery_source';
        $this->context = Context::getContext();
        $this->lang = false;
        
        $this->_defaultOrderBy = 'id_gallery_source';
        $this->_defaultOrderWay = 'ASC';
        $this->allow_export = false;
        $this->list_no_link = true;
        $this->addRowAction('delete');
        
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );
        
        
        $this->fields_list = array(
            'id_gallery_source' => array(
                'title' => $this->l('ID'), 
                'align' => 'center', 
                'class' => 'fixed-width-xs'
            ),
            'name' => array(
                'title' => $this->l('Name'),
            ),
            'kind' => array(
                'title' => $this->l('Type'),
            ),
        );
    }

    public function renderList()
    {
        $this->getList($this->context->language->id);
        $sourceIds = array();
        foreach( $this->_list as $item){
            $sourceIds[] = $item['id_gallery_source'];
        }
        
        $galleryItemsList = array();
        if(count($sourceIds)){
            $galleryItemsList = Db::getInstance()->executeS('
                SELECT gi.*, gs.*
                FROM '. _DB_PREFIX_ .'gallery_source gs 
                INNER JOIN '. _DB_PREFIX_ .'gallery_item gi ON gi.id_gallery_source = gs.id_gallery_source
                WHERE gi.id_gallery_source IN('. implode(',', $sourceIds) .')
            ');
        }
        
        
        $this->context->smarty->assign(array(
            'images_base_url' => $this->module->getPath() . 'photos/',
            'gallery_images' => $galleryItemsList
        ));
        
        return parent::renderList() . 
            $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/gallery_images.tpl'));
    }
    
    /**
     * @return string
     */
    public function renderForm()
    {

        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => 'Place item number',
                    'name' => 'place_code',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'place_code_yes',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'place_code_no',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => 'Place price',
                    'name' => 'place_price',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'place_price_yes',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'place_price_no',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    
                ),
                array(
                    'type' => 'switch',
                    'label' => 'Place QR code',
                    'name' => 'place_qr_code',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'place_qr_code_yes',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'place_qr_code_no',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    
                ),
                
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Sources'),
                    'name' => 'sources',
                    'lang' => false,
                    'required' => false,
                    'rows' => '30',
                    'hint' => $this->l('Use this field for SKU, web url of the folder or file. URLs considered as encoded')
                ),
            )
        );
        
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );
        
        $this->context->smarty->assign(array(
            'GGL_DRV_CLIENT_ID' => Configuration::get('KHLPGAL_GGL_DRV_CLIENT_ID'),
            'GGL_DRV_API_KEY' => Configuration::get('KHLPGAL_GGL_DRV_API_KEY')
        ));
        
        $this->context->controller->addJS($this->module->getPath() .'views/gdrive.js');
        
        return parent::renderForm() . $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/gallery_form.tpl'));
        
    }
    
    public function postProcess()
    {
        if( isset($_POST['submitAddgallery_source']) ){
            $galleryManager = new GalleryManager();
            //$sourceObjects = array();
            $sourcesStrs = explode("\n", $_POST['sources']);
            
            $downloadParams = array(
                'place_code' => ($_POST['place_code'] == '1' ? 1 : null),
                'place_price' => ($_POST['place_price'] == '1' ? 1 : null),
                'place_qr_code' => ($_POST['place_qr_code'] == '1' ? 1 : null)
            );

            if( is_array($sourcesStrs) ){
                foreach($sourcesStrs as $sourceStr){
                    $sourceStr = trim($sourceStr);
                    if( empty($sourceStr) ){
                        continue;
                    }
                    
                    $sourceObject = $this->parseSourceString($sourceStr);
                    if( $sourceObject instanceof GallerySource ){
                        $sourceObject->cached = 0;
                        try{
                            $sourceObject->save();
                        }
                        catch( Exception $e ){
                            $this->errors[] = $e->getMessage();
                        }
                        //$sourceObjects[] = $sourceObject;
                        $messages = $galleryManager->downloadFromSource($sourceObject, $downloadParams);

                        if( count($messages['errors']) ){
                            foreach($messages['errors'] as $messageError){
                                $this->errors[] = $messageError;
                            }
                        }
                        if( count($messages['notes']) ){
                            foreach( $messages['notes'] as $messageNote ){
                                $this->informations[] = $messageNote;
                            }
                        }
                    }
                    else{
                        $this->errors[] = 'String can not be recognized "'.trim($sourceStr).'"';
                    }
                }
            }
            //$this->redirect_after = self::$currentIndex.'&token='.$this->token;
        }
        else{
            parent::postProcess();
        }
        
    }
    
    public function ajaxProcessGdriveDownloadFolder()
    {
        $galleryManager = new GalleryManager();
        $gdFolderId = $_POST['gfolder_id'];
        $gdAccessToken = $_POST['access_token'];
        $gdFolderName = $_POST['gfolder_name'];
        
        $sourceObject = new GallerySource();
        $sourceObject->kind = GallerySource::KIND_GDRIVE;
        $sourceObject->cached = false;
        $sourceObject->name = 'Google drive folder "'.$gdFolderName.'"';
        
        try{
            $sourceObject->save();
        }
        catch( Exception $e ){
            $this->errors[] = $e->getMessage();
        }
        
        $messages = $galleryManager->downloadFromGoogleDriveFolder($sourceObject, array(
            'gdFolderId' => $gdFolderId,
            'gdAccessToken' => $gdAccessToken
        ));
        
        if( count($messages['errors']) ){
            echo '<ul class="alert alert-danger"><li>'. implode('</li><li>', $messages['errors']). '</li></ul>';
        }
        if( count($messages['notes']) ){
            echo '<ul class="alert alert-success"><li>'. implode('</li><li>', $messages['notes']). '</li></ul>';
        }
        
        
    }

    
    /**
     * 
     * @param string $string
     * @return GallerySource|boolean
     */
    protected function parseSourceString($string)
    {
        $gallerySource = new GallerySource();
        
        $skusOutofRules = array('0146_Twilight_Blue');
        
        if( in_array($string, $skusOutofRules) ){
            $gallerySource->kind = GallerySource::KIND_SKU;
            $gallerySource->name = $string;
            return $gallerySource;
        }
        elseif( preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $string) ){
            $gallerySource->kind = GallerySource::KIND_SKU;
            $gallerySource->name = $string;
            return $gallerySource;
        }
        elseif( ($urlParts = GalleryManager::parseUrl($string)) !== false ){
            if( !empty($urlParts['file']) ){
                $gallerySource->path = $string;
                $name = $urlParts['scheme'] .'://'.$urlParts['host']. urldecode($urlParts['path']) 
                    . (isset($urlParts['arg']) ? '?'.$urlParts['arg'] : '' )
                    . (isset($urlParts['anchor']) ? '#'.$urlParts['anchor'] : '' )
                ;
                $gallerySource->name = $name;
                $gallerySource->kind = GallerySource::KIND_LINK;
                return $gallerySource;
            }
            elseif( !empty($urlParts['path']) ){
                $gallerySource->kind = GallerySource::KIND_FOLDER;
                return $gallerySource;
            }
        }
        
        return false;
    }
    
}