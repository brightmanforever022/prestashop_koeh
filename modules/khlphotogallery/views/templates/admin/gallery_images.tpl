<ul style="list-style-type:none; margin:0;">
{foreach $gallery_images as $gallery_image}
<li style="width:207px; height:207px;float:left; margin: 3px; border: 1px solid gray; text-align: center; padding: 3px;">
<img src="{$images_base_url}{$gallery_image['filename']}" style="max-height: 200px; max-width: 200px;" >
</li>
{/foreach}
</ul>