function eXite_logger(ses_time=0,lead=0,mobile_data=0) {
	var u=top.location.href;
	var d=window.location.hostname;
	var x=document.referrer;
	if (typeof v_b_u==="undefined") v_b_u="";
	if (v_b_u!="") u=v_b_u;
	console.log(d);
	var data={d:'{"k":"'+d+'","url":"'+u+'","hit":"1","ref":"","s_time":"'+ses_time+'","lead":"0","isMobile":"'+mobile_data+'","r":"'+x+'"}'};
	if (lead==1) data={d:'{"k":"'+d+'","url":"'+u+'","hit":"0","ref":"","s_time":"'+ses_time+'","lead":"1","isMobile":"'+mobile_data+'","r":"'+x+'"}'};
	//jQuery.post('https://www.exite.co.il/logger/?api_key=8835284-JNMJ-JSYBR33421AA-9828673&act=s',data);
	navigator.sendBeacon('https://log.exite.co/?api_key=8835284-JNMJ-JSYBR33421AA-9828673&act=s',JSON.stringify(data));
}
function eXite_eventLog(data) {

}