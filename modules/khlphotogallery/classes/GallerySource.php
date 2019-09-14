<?php

class GallerySource extends ObjectModel
{
    public $kind;
    
    public $cached;
    
    public $name;
    
    /**
     * Encoded URL 
     * @var string
     */
    public $path;
    
    const KIND_SKU = 1;
    const KIND_LINK = 2;
    const KIND_FOLDER = 3;
    const KIND_GDRIVE = 4;
    
    public static $definition = array(
        'table' => 'gallery_source',
        'primary' => 'id_gallery_source',
        'fields' => array(
            'kind' => array(
                'type' => self::TYPE_INT,
                'required' => true
            ),
            'cached' => array(
                'type' => self::TYPE_INT,
                'required' => true
            ),
            'name' => array(
                'type' => self::TYPE_STRING,
                'required' => true
            )
        )
    );
    
    public function delete()
    {
        $galleryManager = new GalleryManager();
        
        $galleryItemsList = Db::getInstance()->executeS('
            SELECT *
            FROM '. _DB_PREFIX_ .'gallery_item
            WHERE id_gallery_source = '. $this->id .'
        ');
        
        foreach($galleryItemsList as $galleryItemData){
            $galleryItem = new GalleryItem($galleryItemData['id_gallery_item']);
            $galleryManager->unstore($galleryItem->filename);
            $galleryItem->delete();
        }
        
        return parent::delete();
        
    }
}

