/**
 * 
 */
$(function(){
	var khlgdprAgreed = Cookies.get('khlgdpr_agreed');
	if( (typeof khlgdprAgreed == 'undefined') || !khlgdprAgreed ){
		$('#khlgdprMessageContainer').show();
	}
	$('#khlgdprMessageContainer').on('click', '#khlgdprMessageBtnAgree', function(){
		Cookies.set('khlgdpr_agreed', true, {expires:30});
		$('#khlgdprMessageContainer').hide();
	});
});