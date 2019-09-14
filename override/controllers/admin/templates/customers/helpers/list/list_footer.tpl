{extends file="helpers/list/list_footer.tpl"}
{block name="footer"}
<hr>
  <div class="form-inline">
    <button name="action" value="export_massmail" class="btn btn-primary">{l s='Export to Mass mailing'}</button>
  </div>
    <p class="muted">This form will export selected customers to Mass mailing page. 
    After click on "Export" page will be directed to Mass mailing page.
    </p>

{/block}