<div id="custhtmlcarosel{$id}" class="block carousel slide carousel-fade">
    {if isset($widget_heading)&&!empty($widget_heading)}
    <h4 class="page-subheading">
        {$widget_heading}
    </h4>
    {/if}
    {if $show_controls AND count($customercarousel )>1}
	<a class="carousel-control left" href="#custhtmlcarosel{$id}"   data-slide="prev"></a>
	<a class="carousel-control right" href="#custhtmlcarosel{$id}"  data-slide="next"></a>
    {/if}
    <div class="carousel-inner">
    {foreach from=$customercarousel  name="mypLoop" key=key item=item}
        <div class="item {if $smarty.foreach.mypLoop.index == $startSlide}active{/if}">
            <h4 class="title-custhtml">{$item.title}</h4>
            {$item.content}           
        </div>

    {/foreach}   
    </div>
</div>
<script type="text/javascript">
{literal}
$(document).ready(function() {
    $('#custhtmlcarosel{/literal}{$id}{literal}').each(function(){
        $(this).carousel({
            pause: true,
            interval: {/literal}{$interval}{literal}
        });
    });
     
});

{/literal}
</script>