function refresh(div_id,url)
{
    var rtn_data = $.ajax({
        type : 'post',
        url  : url,
        cache: false,
        async: false,
        success:function (data){
            return data.replace(/(^\s*)|(\s*$)/g, "");
        }
    }).responseText;
    $("#"+div_id).html(rtn_data);
}

function getAjaxData(url){
	var rtn_data = $.ajax({
        type : 'post',
        url  : url,
        cache: false,
        async: false,
        success:function (data){
            return data.replace(/(^\s*)|(\s*$)/g, "");
        }
    }).responseText;
	return rtn_data;
}