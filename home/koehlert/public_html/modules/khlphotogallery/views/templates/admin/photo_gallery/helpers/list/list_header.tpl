{extends file="helpers/list/list_header.tpl"}
{block name="preTable"}
<button type="button" class="btn btn-danger" id="gallery_sourceDeleteSelected">Delete selected</button>
<script type="text/javascript">
$('#gallery_sourceDeleteSelected').click(function(){
    if( !confirm('Delete selected items?') ){
        return false;
    }

    sendBulkAction($(this).closest('form').get(0), 'submitBulkdelete{$table}', 0);
});


</script>
{/block}
