// JavaScript Document
function switch_table(obj,num,showid){
	for(var n=1;n<=num;n++){
		document.getElementById(obj+'_'+n).style.display = 'none';
	}
//	document.getElementById('myid_2').style.display = 'none';
	document.getElementById(obj+'_'+showid).style.display = '';
}

function delete_entry(form_id, id){
	var form = document.getElementById(form_id);
	if(confirm('hi')){
		document.getElementById('id').value = id;
		form.submit();
	}
}