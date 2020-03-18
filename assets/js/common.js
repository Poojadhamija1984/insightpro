// common ajax function to get data using single parameter.
function call_ajax(datavalue,baseUrl,controllerName,functionName,appendto) {
	$.ajax({
		type:'POST',
		url:baseUrl+"/"+controllerName+"/"+functionName,
		    data: {
			datavalue:datavalue},   
		    success:function(datavalue){	
			$('#'+appendto).html("");
			$('#'+appendto).append(datavalue);
			$('#'+appendto).formSelect();
		}
	});
}


// common ajax function to get data using single parameter.
function call_ajaxforinputbox(datavalue,baseUrl,controllerName,functionName,appendto) {
	if(datavalue == 'add_new') {
		$('#formtxt').show();		
	} else {
		$('#formtxt').hide();
	}

	$.ajax({
		type:'POST',
		url:baseUrl+"/"+controllerName+"/"+functionName,
		    data: {
			//csrf_test_name:csrf,
			datavalue:datavalue},   
		    success:function(datavalue){		
			$('#'+appendto).val(datavalue);
			//$('#'+appendto).formSelect();
		}
	});
}


function postAjax(url, data) { // data in object form
    var dataSet = '';
    $.ajaxSetup({
        data: {
                csrf_test_name: $('#csrf_token').val()
        },
        async: false
    });
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function(res) {
                res = JSON.parse(res);
                $('input[name="csrf_test_name"]').val(res.csrfHash);
                dataSet = res.data;
        }
    });
    return dataSet;
}

function postAjaxFileUpload(url, data) { // data in object form 
    var dataSet = '';
    $(".page_loader").fadeIn("slow");
    $("body").addClass("content_loading");
	
	$.ajaxSetup({
		data: {
			csrf_test_name: $('#csrf_token').val()
		},
		async: false
	});
    
	$.ajax({
		url: url,
		type: 'POST',
        enctype: 'multipart/form-data',
		data: data,
        processData: false,  // Important!
        contentType: false,
        cache: false,
		success: function(res) {
            //remove loading icon
            $(".page_loader").fadeOut("slow");
            $("body").removeClass("content_loading");

            //page scroll to top
            $("html, body").animate({ scrollTop: 0 }, "slow");
    
			res = JSON.parse(res);
			$('input[name="csrf_test_name"]').val(res.csrfHash);
			dataSet = res.data;
		}
	});
    hideMessageBox();
	return dataSet;
}

function postAjax_With_Loder(url, data) { // data in object form
    var dataSet = '';
    $.ajaxSetup({
        data: {
            csrf_test_name: $('#csrf_token').val()
	},
	async: false
    });
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend: function () {
            $(".page_loader").fadeIn("slow");
            $("body").addClass("content_loading");
        },
        success: function(res) {
            res = JSON.parse(res);
            $('input[name="csrf_test_name"]').val(res.csrfHash);
            dataSet = res.data;
            $(".page_loader").fadeOut("slow");
            $("body").removeClass("content_loading");
        }
    });
    return dataSet;
}

function getAjax(url,data) { // data in object form
    $.ajax({
        url:url,
        type:'get',
        success:function (res) {
            return res;
        }
    });
}

function deleteAjax(message, url, deleteId) {
    var dataSet = '';
    $(".page_loader").fadeIn("slow");
    $("body").addClass("content_loading");
    
    $.ajaxSetup({
        data: {
            csrf_test_name: $('#csrf_token').val()
        },
        async: false
    });
    
    if(confirm(message)){
        $.ajax({
            url:url,
            type:'delete',
            data:{deleteId:deleteId},
            success:function(res){
                //remove loading icon
                $(".page_loader").fadeOut("slow");
                $("body").removeClass("content_loading");

                //page scroll to top
                $("html, body").animate({ scrollTop: 0 }, "slow");
                
                //parse Json data 
                res = JSON.parse(res);
                $('input[name="csrf_test_name"]').val(res.csrfHash);
                dataSet = res.data;
            }
        });
        hideMessageBox();
        return dataSet;
    }
    else{
        return false;
    }
}

function saveAjax(url, data) { // data in object form 
    var dataSet = '';
    $(".page_loader").fadeIn("slow");
    $("body").addClass("content_loading");
	
	$.ajaxSetup({
		data: {
			csrf_test_name: $('#csrf_token').val()
		},
		async: false
	});
    
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		success: function(res) {
            //remove loading icon
            $(".page_loader").fadeOut("slow");
            $("body").removeClass("content_loading");

            //page scroll to top
            $("html, body").animate({ scrollTop: 0 }, "slow");
    
			res = JSON.parse(res);
			$('input[name="csrf_test_name"]').val(res.csrfHash);
			dataSet = res.data;
		}
	});
    hideMessageBox();
	return dataSet;
}

function editAjax(url, data) { // data in object form
    var dataSet = '';
	$.ajaxSetup({
		data: {
			csrf_test_name: $('#csrf_token').val()
		},
		async: false
	});
    
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		success: function(res) {
            //page scroll to top
            $(".modal-content").animate({ scrollTop: 0 }, "slow");
            
			res = JSON.parse(res);
			$('input[name="csrf_test_name"]').val(res.csrfHash);
			dataSet = res.data;
		}
	});
    hideMessageBoxEdit();
	return dataSet;
}

function alertBox(msg) {
	M.Toast.dismissAll();
	M.toast({html: msg, classes: 'rounded'});
}

function hideMessageBox() {
    ///Hide success and error message after 5 seconds
    setTimeout(function() {
        $('.error_section').fadeOut('slow');
        $('.selectbox').formSelect();
        
        if($('#failure_section').hasClass('hide') === false) {
            $('#failure_section').addClass('hide');
        }
        if($('#success_section').hasClass('hide') === false) {
            $('#success_section').addClass('hide');
        }
        
    }, 5000); // <-- time in milliseconds
}

function hideMessageBoxEdit() {
    ///Hide success and error message after 5 seconds
    setTimeout(function() {
        $('.error_section').fadeOut('slow');
        $('.selectbox').formSelect();
        
        if($('#edit_failure_section').hasClass('hide') === false) {
            $('#edit_failure_section').addClass('hide');
        }
        if($('#edit_success_section').hasClass('hide') === false) {
            $('#edit_success_section').addClass('hide');
        }
        
    }, 5000); // <-- time in milliseconds
}

///Hide success and error message after 5 seconds
setTimeout(function() {
    $('.error_section').fadeOut('slow');
    $('.selectbox').formSelect();
}, 5000); // <-- time in milliseconds


