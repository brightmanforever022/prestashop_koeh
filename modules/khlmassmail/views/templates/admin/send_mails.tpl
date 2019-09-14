
<div class="panel">
  <p>This form send emails to customers exported from Customers or Diff payments page. 
  Select template and click Send.
  </p>
  <div class="row">
    <div class="col-lg-6">
      <div class="form-inline">
        <div class="form-group">
          {l s='Number of receivers' mod='khlmassmail'}: {$receivers_count} 
          &nbsp;
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#massmailReceiverList"
            >{l s='View' mod='khlmassmail'}</button>
        </div>
        <div class="form-group">
          {html_options name='id_template' options=$mail_templates_list id='id_template'}
          &nbsp;
        </div>
        <button id="massmailStart" type="button" class="btn btn-primary">{l s='Send mails' mod='khlmassmail'}</button>
      </div>
    
    </div>
    <div class="col-lg-6">
      <div class="well" id="reportWell" hidden>
        <p>Status: <span class="mailing-status">Idle</span></p>
        <ul class="list-group" id="reportList">
          <li class="list-group-item"> <span class="badge badge-queue">{$receivers_count}</span> Queue </li>
          <li class="list-group-item"> <span class="badge badge-sent">0</span> Sent </li>
          <li class="list-group-item"> <span class="badge badge-errors">0</span> Errors </li>
        </ul>
      </div>

    </div>
  </div>
  <div class="row" id="massmailReceiverList" hidden>
    <div class="col-lg-12">
      <hr>
      <ul class="list-group clearfix">
    	{foreach $receivers_list as $receiver_data}
        <li class="list-group-item col-lg-3">
			{$receiver_data.customer_first_name} {$receiver_data.customer_last_name}<br> {$receiver_data.email}
        </li>
    	{/foreach}
      </ul>
      <hr class="clearfix">
      <form method="post" action="{$currentIndex|escape:'html':'UTF-8'}&amp;token={$smarty.get.token}">
      <button type="submit" class="btn btn-danger" name="action" value="delete_receivers">{l s='Delete all' mod='khlmassmail'}</button>
      </form>
    </div> 
  </div>
</div>

<script type="text/javascript">
var massmailControllerUrl = "{$massmail_controller_url}";
$(function(){
	KhlMassMailing.init();
});

</script>