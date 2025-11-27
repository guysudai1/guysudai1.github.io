var frm = false;
var data_sent = 0;
var uploaders = [];
var uploadersi = 0;
var in_id;
var allowed_photo_types = '*.jpeg;*.jpg;*.gif;*.png;*.doc;*.docx;*.pdf;*.txt;*.xls;*.ppt';
var formCurrentFile="";
var notuploaded = 0;

function FormUpdateUploadedFile(uploadedfile,original_name,input_id) {
	notuploaded--;
	//jQuery('input[name='+input_id+']').val(uploadedfile);
}

jQuery(document).ready(function(){
	jQuery('.customFormDate').datepicker({'dateFormat':'dd.mm.yy'});
	jQuery('.exite_dz_area.formFile').each(function(){
		in_id=jQuery(this).attr('id');
		var elClassName=jQuery(this).attr('class').replace(/ /gi,".");
		
		var cbAfterUploadFormFile='FormUpdateUploadedFile(formCurrentFile,"",in_id);';
		uploaders[uploadersi]=jQuery('.'+elClassName).dz({'acceptedFiles':'image/*,application/pdf,.pdf','maxFiles':1,'tumbsWidth':120,'tumbsHeight':40,'url':siteURL+'/Admin/saveFormFile.php','showTumbs':false,'cb':cbAfterUploadFormFile});
		//uploaders[uploadersi] = formshowuploader(allowed_photo_types,1,jQuery(this).attr('id'),0,'progress_'+jQuery(this).attr('id'));
		uploadersi++;
	});
	notuploaded=uploaders.length;
});

function beforeFormSubmit() {
	if(data_sent == 0)
	{
		data_sent = 1;
		jQuery.each(uploaders,function(index,uploader){
			if (uploader.myDropzone.files.length<1) notuploaded--;
			if (notuploaded<0) notuploaded=0;
			if (uploader.myDropzone.files[0]) {
				formCurrentFile=uploader.myDropzone.files[0].name;
				jQuery('input[name='+uploaders[index].attr("id")+']').val(formCurrentFile);
			}
 			uploader.startUpload();
		});
		setTimeout('checkBeforeFormSumbit()',500);
	}
}

function checkBeforeFormSumbit() {

	if(notuploaded == 0)
		doSubmitForm();
	else
		setTimeout('checkBeforeFormSumbit()',500);
}
var frm_button_css_bg;
var frm_button_val;
function waitForForm(start) {
	if (start==1) {
		jQuery("input[type=submit].frm_button").removeAttr("disabled");
		jQuery("input[type=submit].frm_button").val(frm_button_val);
		jQuery("input[type=submit].frm_button").css("background-image",frm_button_css_bg);
	}
	else {
		frm_button_css_bg=jQuery("input[type=submit].frm_button").css("background-image");
		frm_button_val=jQuery("input[type=submit].frm_button").val();
		
		jQuery("input[type=submit].frm_button").attr("disabled","disabled");
		jQuery("input[type=submit].frm_button").val(waitForSendLabel);
		jQuery("input[type=submit].frm_button").css("background-image","none");
	}
}

function submitForm(frmi){
	frm = frmi;
	Placeholder.submitted(frm);
	waitForForm(0);
	if(!hasFiles)
	{
		doSubmitForm();
		return false;
	}
	else
	{
		//jQuery(frm).submit();
		beforeFormSubmit();
		return false;
	}
}

function doSubmitForm() {
	var pars = jQuery(frm).serialize();
	pars+="&lp_scrollPercent="+window.top.lp_scrollPercent;
	jQuery.ajax({
		type: "POST",
		url: siteURL+"/sendCustomForm.php",
		data: pars,
		crossDomain:true,
		success: function(msg){
			jQuery('#form_result').html(msg);
			Placeholder.init({normal:"#"+inputTextColor});
			data_sent = 0;
			window.setTimeout('waitForForm(1)',2200);
		}
	});
}