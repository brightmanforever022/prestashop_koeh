<script type="text/javascript">
	if (!dhxWins.isWindow("toolsSCGridsEditorPro")){

		toolsSCGridsEditorPro = dhxWins.createWindow("toolsSCGridsEditorPro", 100, 50, $(window).width()-100, $(window).height()-100);
		toolsSCGridsEditorPro.setIcon('lib/img/table_gear.png','lib/img/table_gear.png');
		toolsSCGridsEditorPro.setText("<?php echo _l('Interface customization Pro: Custom fields management') ?>");
		toolsSCGridsEditorPro.attachEvent("onClose", function(win){
				toolsSCGridsEditorPro.hide();
				return false;
			});
		$.get("index.php?ajax=1&act=all_win-gridseditorpro_init",function(data){
				$('#jsExecute').html(data);
			});
		
	}else{
		$.get("index.php?ajax=1&act=all_win-gridseditorpro_init",function(data){
				$('#jsExecute').html(data);
			});
		toolsSCGridsEditorPro.show();
	}
</script>