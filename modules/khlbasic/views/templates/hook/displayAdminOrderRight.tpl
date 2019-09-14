<div class="col-lg-12">
	<div class="panel">
    <a href="{$order_images_download_url}" class="btn btn-primary" target="_blank">Download order images</a>
    &nbsp;
    <a href="{$order_eans_download_url}" class="btn btn-primary" target="_blank">Download order EANs</a>
    </div>
</div>

<div class="col-lg-12">
	<div class="panel">
	<div class="panel-body">
	<form action="{$link->getAdminLink('AdminOrders')}&id_order={$id_order}" method="post">
		<div class="col-lg-3"><label>Order type</label></div>
		<div class="col-lg-7">{html_options name='id_order_type' options=$order_types selected=$order_type_selected}</div>
		<div class="col-lg-2">
			<button type="submit" name="submitIdOrderType" class="btn btn-default">{l s='Save' mod='khlbasic'}</button>
		</div>
	</form>
	</div>
    </div>
</div>