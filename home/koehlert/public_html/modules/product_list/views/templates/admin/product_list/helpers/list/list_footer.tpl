{extends file="helpers/list/list_footer.tpl"}

{block name="footer"}
<div class="panel-footer">
	<div class="form-inline">
		<div class="form-group">
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="reference">
		  		{l s='Item number'}
			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="price">
		  		{l s='Item Price'}
			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="qr_code">
		  		{l s='QR code'}
			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="stock">
		  		{l s='Item stock'}
			</label>

		</div>
		&nbsp;
		<button class="btn btn-primary" name="action" value="photos_download" type="submit">{l s='Download photos'}</button>
		&nbsp;
		<button class="btn btn-primary" name="action" value="prodimg_pdf" id="prodimg_pdf" type="submit">{l s='Create PDF mailing'}</button>
	</div>
</div>
<div class="panel-footer">
	<button name="action" value="sticker_print_dymo" id="sticker_print_dymo" type="button" class="btn btn-primary">{l s='CK Etikett Dymo'}</button>
	<button name="action" value="sticker_print_pdf" id="sticker_print_pdf" type="submit" class="btn btn-primary">{l s='CK Etikett PDF'}</button>
	&nbsp;
	<button name="action" value="sticker_exhb_print_dymo" id="sticker_exhb_print_dymo" type="button" class="btn btn-primary">{l s='CK Messe Etikett Dymo'}</button>
	<button name="action" value="sticker_exhb_print_pdf" id="sticker_exhb_print_pdf" type="submit" class="btn btn-primary">{l s='CK Messe Etikett PDF'}</button>
	&nbsp;
	<button name="action" value="export_excel" id="export_excel" type="submit" class="btn btn-primary">{l s='Export to Excel'}</button>
</div>

<div class="modal fade" id="salesGraphPopup" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xxl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sale stats</h4>
        <p></p>
      </div>
      <div class="modal-body">
		<div id="salesGraphLeft"></div>
      </div>
    </div>
  </div>
</div>
{/block}