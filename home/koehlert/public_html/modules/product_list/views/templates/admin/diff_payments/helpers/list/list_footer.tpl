{extends file="helpers/list/list_footer.tpl"}
{block name="footer"}
{if $tab_access['edit'] == '1'}
  <hr>
  <div class="form-inline">
    <div class="form-group">
      <label>
        <input type="checkbox" name="attach_last_reminder">
        {l s='Attach last reminder' mod='product_list'}
      </label>
      &nbsp;
    </div>
    
    <button name="action" value="export_massmail" class="btn btn-primary">{l s='Export to Mass mailing'}</button>
  </div>
  <p class="muted">
    This form will export customers of selected invoices to Mass mailing page.
    If 'Attach last reminder' checked, for each invoice last sent reminder will be attached, if it was sent. 
    Customer will receive only email, no matter how many his invoices selected.
    After click on "Export" page will be directed to Mass mailing page.
  </p>
{/if}

{/block}