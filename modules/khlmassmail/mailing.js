/**
 * 
 */
var KhlMassMailing = {
	sendingInProcess: false,
	timeoutSeconds: 10,
	timeoutHandle: null,
	mailsSendLimit: 5,
	reportData: {
		queue: 0,
		sent: 0,
		errors: 0
	},
	init: function(){
		window.addEventListener('beforeunload', (event) => {
			if( !KhlMassMailing.sendingInProcess ){
				return true;
			}
			if( confirm('Emails send in process, exit page will abort it. Are you sure to exit the page?') ){
				return true;
			}
			// Cancel the event as stated by the standard.
			event.preventDefault();
			// Chrome requires returnValue to be set.
			event.returnValue = '';
			
		});
		$('#massmailStart').on('click', function(){
			if( ($('#id_template').val().length == 0) || ($('#id_template').val() == '0') ){
				alert('Template not selected');
				return;
			}
			if( !confirm('Confirm start sending emails?') ){
				return;
			}
			$('#reportWell').show();
			KhlMassMailing.sendingInProcess = true;
			KhlMassMailing.requestMailsSend();
		});
	},
	setSendTimeout: function(){
		$('#reportWell').find('.mailing-status').text('Timeout');
		this.timeoutHandle = setTimeout(function(){
			KhlMassMailing.requestMailsSend();
		}, this.timeoutSeconds * 1000);
	},
	requestMailsSend: function(){
		$('#reportWell').find('.mailing-status').text('Sending');
		var params = {'limit':this.mailsSendLimit,'id_template':$('#id_template').val()};
		$.ajax({
			url: massmailControllerUrl + '&ajax=1&action=send_emails',
			type: 'POST',
			dataType: 'json',
			data: params
		})
		.done(function(response){
			if( !response.success ){
				alert(response.message);
				return;
			}
			KhlMassMailing.printReport(response.report);
			
			if( response.report.queue > 0 ){
				KhlMassMailing.setSendTimeout();
			}
			else{
				KhlMassMailing.sendingInProcess = false;
				$('#reportWell').find('.mailing-status').text('Finished');
			}
		});
	},
	printReport: function(sentReport){
		this.reportData.queue = sentReport.queue;
		this.reportData.sent += sentReport.sent;
		this.reportData.errors += sentReport.errors;
		
		$('#reportList').find('.badge-queue').text(this.reportData.queue);
		$('#reportList').find('.badge-sent').text(this.reportData.sent);
		$('#reportList').find('.badge-errors').text(this.reportData.errors);
	}
};