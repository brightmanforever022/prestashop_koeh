<?php

class GalleryItem extends ObjectModel
{
    public $id_gallery_source;
    
    public $filename;
    
    
    public static $definition = array(
        'table' => 'gallery_item',
        'primary' => 'id_gallery_item',
        'fields' => array(
            'id_gallery_source' => array(
                'type' => self::TYPE_INT,
                'required' => true
            ),
            'filename' => array(
                'type' => self::TYPE_STRING,
                'required' => true
            )
        )
    );
}

