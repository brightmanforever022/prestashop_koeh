/**
 * 
 */
var commentRecordActionsPanelHide = false;
$(function(){
	//console.log($('body').width());
	var commentsArchiveIconClass = null;
	var shopCommentsContainerWidth = $('#content div.table-responsive-row table.table').width();
	if(shopCommentsReferenceType == 1){
		var commentsContainerSelector = 'body.admincustomers table.customer';
		commentsArchiveIconClass = 'icon-comments';
	}
	else if(shopCommentsReferenceType == 2){
		var commentsContainerSelector = 'body.admindiffpayments table.order_invoice';
	}

	$('#shopCommentFormDialog').modal({'show':false});
	var commentAddIconClass = 'icon-comment-o';
	$(commentsContainerSelector + ' td.note').each(function(){
		$(this).append('&nbsp;<i class="'+commentAddIconClass+'" title="Add note"></i>');
		
		if( shopCommentsReferenceType == 1 ){
			$(this).append('&nbsp;<i class="icon-comments customer-comments" title="View archive"></i>');
		}
	});
	$(commentsContainerSelector + ' tbody').on('click', 'i.'+commentAddIconClass, function(event){
		if(shopCommentsReferenceType == 1){
			var refIdMatch = $(event.target).parents('tr').attr('id').match(/\d+/);
			var refId = refIdMatch[0];
		}
		else if(shopCommentsReferenceType == 2){
			var refId = $(event.target).parents('tr').attr('documentid');
		}

		$('#shopCommentFormDialog input[name="reference_id"]').val(refId);
		$('#shopCommentFormDialog').modal('show');
	});
	$(commentsContainerSelector + ' tbody, body.adminorders #orderViewCustomerComments').on('click', 'i.icon-comments', function(event){
		var refId = null;
		var listContainer = null;
		var commentsStatus = null;
		if(shopCommentsReferenceType == 1){
			if( (typeof id_order != 'undefined') && (typeof id_customer != 'undefined') ){
				refId = id_customer;
				listContainer = $(this).parents('#orderViewCustomerComments').find('div.shop-comments-table-container');
			}
			else{
				var refIdMatch = $(event.target).parents('tr').attr('id').match(/\d+/);
				refId = refIdMatch[0];
				listContainer = $(this).parent().find('div.shop-comments-table-container');
			}
		}
		else if(shopCommentsReferenceType == 2){
			refId = $(event.target).parents('tr').attr('documentid');
		}
		
		if($(this).hasClass('comments-all')){
			//commentsStatus = null;
			$(this).removeClass('comments-all').addClass('comments-active');
		}
		else if($(this).hasClass('comments-active')){
			//commentsStatus = 1;
			$(this).removeClass('comments-active').addClass('comments-all');
		}
		
		if(listContainer.find('table').hasClass('comments-status-active')){
			commentsStatus = null;
		}
		else if( listContainer.find('table').hasClass('comments-status-all') ){
			commentsStatus = 1;
		}

		shopCommentsManager.list(listContainer, shopCommentsReferenceType, refId, commentsStatus);
	});

	/*$('body.adminorders #content table.shop-comments-table tr').on('hover', function(event){
		$(this).find('td').last().append('lala');
	});*/
	$('body.admincustomers #content td.note, body.adminorders #content div.shop-comments-table-container')
	.on('mouseenter', 'table.shop-comments-table tr', function(event){
		commentRecordActionsPanelHide = false;
		var commentCurrentStatus = $(this).hasClass('status-active') ? 1 : 0;
		var elOffset = $(this).offset();
		$('#shopCommentsRecordActionsPanel')
		.css({
			top: elOffset.top + 'px',
			left: elOffset.left + 'px'
		})
		.show()
		.data('reference_type', $(this).parents('table').data('reference_type'))
		.data('reference_id', $(this).parents('table').data('reference_id'))
		.data('comment_id', $(this).data('comment_id'))
		;
		if(commentCurrentStatus){
			$('#shopCommentsRecordActionsPanel button.comment-activate').hide();
			$('#shopCommentsRecordActionsPanel button.comment-archive').show();
		}
		else{
			$('#shopCommentsRecordActionsPanel button.comment-activate').show();
			$('#shopCommentsRecordActionsPanel button.comment-archive').hide();

		}
		shopCommentsManager.setCurrentData($(this).parents('div.shop-comments-table-container'), $(this).parents('table').data('reference_type'), $(this).parents('table').data('reference_id'));
	})
	.on('mouseleave', function(event){
		commentRecordActionsPanelHide = true;
		setTimeout(function(){
			if(!commentRecordActionsPanelHide){
				return;
			}
			$('#shopCommentsRecordActionsPanel').data('reference_type', '0').data('reference_id','0').hide();
		}, 100);
	});
	$('body.admincustomers #content, body.adminorders #content')
	.on('mouseenter', '#shopCommentsRecordActionsPanel', function(event){
		commentRecordActionsPanelHide = false;
		$(this).show();
	})
	.on('mouseleave', '#shopCommentsRecordActionsPanel', function(event){
		commentRecordActionsPanelHide = true;
		$(this).hide();
	});
	$('#shopCommentsRecordActionsPanel').on('click', 'button', function(event){
		var commentId = $(this).parent().data('comment_id');
		if( $(this).hasClass('comment-archive') ){
			if( confirm('Confirm archiving of this comment?') ){
				shopCommentsManager.archive(commentId);
			}
		}
		else if( $(this).hasClass('comment-activate') ){
			shopCommentsManager.activate(commentId);
		}
	});

	$('body.admindiffpayments table.order_invoice tbody').on('hover', 'i.icon-comments.customer-comments', function(event){
		//console.log(event);
		if(event.type == 'mouseleave'){
			$('#shopCommentsGrid').hide();
			return;
		}

		var targetOffset = $(event.target).offset();
		$('#shopCommentsGrid .panel-body').html('Loading comments');
		$('#shopCommentsGrid').css({
			display: 'block',
			top: (targetOffset.top + 20) +'px',
			left: (targetOffset.left - 600)+'px'
		});
		var customerCommentsList = $(event.target).next('table.shop-comments-table').clone();
		customerCommentsList.show();
		$('#shopCommentsGrid .panel-body').html(customerCommentsList);
		
	});
});

var shopCommentsManager = {
	currentCommentListContianer: null,
	currentReferenceType : null,
	currentReferenceId : null,
	setCurrentData: function(jCommentListContainer, referenceType, referenceId){
		this.currentCommentListContianer = jCommentListContainer;
		this.currentReferenceType = referenceType;
		this.currentReferenceId = referenceId;
	},
	archive: function(commentId){
		this.changeStatus(commentId, 0);
		/*var urlParams = {id: commentId};
		$.ajax({
			url: shopCommentsControllerUrl + '&action=archive',
			method: 'POST',
			data: urlParams,
			dataType: 'json',
			cache: false,
			success: function(response){
				if(response.status == 'error'){
					alert(response.message);
				}
				shopCommentsManager.list(shopCommentsManager.currentCommentListContianer, shopCommentsManager.currentReferenceType, shopCommentsManager.currentReferenceId, 1);
			}
		});*/
	},
	activate: function(commentId){
		this.changeStatus(commentId, 1);
	},
	changeStatus: function(commentId, newStatus){
		var urlParams = {id: commentId, status: newStatus};
		$.ajax({
			url: shopCommentsControllerUrl + '&action=change_status',
			method: 'POST',
			data: urlParams,
			dataType: 'json',
			cache: false,
			success: function(response){
				if(response.status == 'error'){
					alert(response.message);
				}
				shopCommentsManager.list(shopCommentsManager.currentCommentListContianer, shopCommentsManager.currentReferenceType, shopCommentsManager.currentReferenceId, 1);
			}
		});
		
	},
	list: function(container, referenceType, referenceId, status){
		var urlParams = {reference_type: referenceType, reference_id: referenceId, status};
		$.ajax({
			url: shopCommentsControllerUrl + '&action=list',
			method: 'GET',
			data: urlParams,
			dataType: 'html',
			cache: true,
			success: function(response){
				$(container).html(response);
			}
		});

	}
};