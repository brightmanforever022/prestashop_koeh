<div class="bootstrap">
<div class="modal fade" tabindex="-1" role="dialog" id="shopCommentFormDialog"  aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title"  id="myModalLabel">{l s='Add note' mod='shopcomments'}</h4>
      		</div>
      		<div class="modal-body">
        	<form action="{$shop_comments_controller_url}&action=save" method="post">
        		<div class="form-group">
		            <textarea rows="4" class="form-control" name="message"></textarea>
        		</div>
        		<div class="form-group">
        			<input type="hidden" name="reference_type" value="{$shop_comment_reference}">
        			<input type="hidden" name="reference_id">
        			<button type="submit" class="btn btn-primary">{l s='Save note' mod='shopcomments'}</button>
        		</div>
        	</form>
      		</div>
    	</div>
  	</div>
</div>

<div id="shopCommentsGrid" class="panel panel-default" style="position:absolute;z-index:100;display:none;width:600px;"><div class="panel-body"></div></div>
</div>

<div hidden style="position:absolute;z-index:20;width:100px;" id="shopCommentsRecordActionsPanel">
  <button type="button" class="btn btn-warning btn-xs comment-archive">{l s='Archive' mod='shopcomments'}</button>
  <button type="button" class="btn btn-success btn-xs comment-activate">{l s='Activate' mod='shopcomments'}</button>
</div>


<script type="text/javascript">
<!--
var shopCommentsReferenceType = {$shop_comment_reference};
var shopCommentsControllerUrl = "{$shop_comments_controller_url}";
//-->
</script>