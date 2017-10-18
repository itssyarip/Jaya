function add_users(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"user_admin/add/"+id);
    } else {
        window.location.replace(baseUrl+"user_admin/add");
    }
    
}

function add_data(baseUrl, ctrlName, id,funcName) {
    if (!funcName || funcName === '') {
        funcName ='add';
    }
    if (id && id != '') {
        window.location.replace(baseUrl+ctrlName+"/"+funcName+"/"+id);
    } else {
        window.location.replace(baseUrl+ctrlName+"/"+funcName);
    }
    
}

function add_menu(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"menu/add/"+id);
    } else {
        window.location.replace(baseUrl+"menu/add");
    }
    
}

function add_content(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"content/add/"+id);
    } else {
        window.location.replace(baseUrl+"content/add");
    }
    
}

function delete_menu(baseUrl,controllerName,page) {
    if (!page) {
        page = 'index';
    }
    var dataDelete = new Array();
    $(".delcheck").each(function(){
        if($(this).is(":checked")) {
            var rawData = {
                id:$(this).val()
            };
            dataDelete.push(rawData);
            }
    });
    
    if (dataDelete.length > 0) {
        var confirmBox = confirm("Anda Yakin ingin menghapus Data ?");
        if (confirmBox==true) {
            $.ajax({
               url : baseUrl+controllerName+"/delete",
               type: "POST",
               dataType:'json',
               data : {
                   dataDelete : dataDelete

            //                asrs_data:JSON.stringify(data_tables)
                   },
               success: function(data){
                   if (data['success']) {
                       alert(data['message']);
                        if (data['url'] == '') {
                            window.location.replace(baseUrl+controllerName+"/"+page);
                        } else {
                            window.location.replace(baseUrl+controllerName+'/'+data['url']);
                        }
                   }

               }
            });
        } 
        
    }

}

function auth_edit(baseUrl, groupCode) {
    window.location.replace(baseUrl+"group/auth_edit/"+groupCode);
}

function cancelButton(baseUrl,controller) {
    window.location=baseUrl+controller+"/index";
}

function delpeserta(t) {
    $(t).parent().parent().remove();
}

function export_data(baseUrl,controller) {
    $.ajax({
        url : baseUrl+controller+"/export_csv",
        type: "POST",
        dataType:'html',
        data : {
//                search:$(obj).val() 
            },
        success: function(data)
        {
        }
    });
}

function get_parent(baseUrl, controller, obj) {
    $(obj).autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: baseUrl + controller + "/get_parent",
                data: {
                    parentid: $("#parent_id").val()
                },
                success: response,
                dataType: 'json',
                
                delay: 100
            });
        },
        minLength: 3
    });
    $(obj).autocomplete( "option", "appendTo", ".tesmodal" );
}

function get_account(baseUrl, controller, obj) {
    $.ajax({
        url : baseUrl+controller+"/get_account",
        type: "POST",
        dataType:'html',
        data : {
                id_bse:$(obj).val() 
            },
        success: function(data)
        {
        }
    });
}