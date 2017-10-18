function initPaging() {
    var limitpage = 0;
    limitpage = parseInt($("#limit").val())+10;
    if ($("#totaldata").val() <= limitpage) {
        $(".btn-next").attr("disabled", true);
        $(".btn-last").attr("disabled", true);
    } else {
        $(".btn-next").attr("disabled", false);
        $(".btn-last").attr("disabled", false);
    }
}

function initPagingNews() {
    var limitpage = 0;
    limitpage = parseInt($("#limit").val())+5;
    if ($("#totaldata").val() <= limitpage) {
        $(".btn-next").attr("disabled", true);
        $(".btn-last").attr("disabled", true);
    } else {
        $(".btn-next").attr("disabled", false);
        $(".btn-last").attr("disabled", false);
    }
}
function initPagingPress() {
    var limitpage = 0;
    limitpage = parseInt($("#limit").val())+12;
    if ($("#totaldata").val() <= limitpage) {
        $(".btn-next").attr("disabled", true);
        $(".btn-last").attr("disabled", true);
    } else {
        $(".btn-next").attr("disabled", false);
        $(".btn-last").attr("disabled", false);
    }
}
function searchdata(id, baseUrl, controllerName,obj,funcName) {
    if (!funcName) {
        funcName = 'paging';
    }
//    var searchData = new Array();
//    $('.search_desc').each(function(index, value){
//        search={};
//        search[$(this).attr('field')] = $(this).val();
//        searchData.push(JSON.stringify(search));
//    });

    $.ajax({
        url : baseUrl+controllerName+"/"+funcName,
        type: "POST",
        dataType:'json',
        data : {
                page:'first',
                totaldata:$("#totaldata").val(),
                'pnum':$('.pnumber').val(),
                'search':$(obj).val(),
                'fields':$(obj).attr('field')
            },
        success: function(data)
        {
//                $("#static_content").html('');
            $("#"+id+" > tbody").html('');
            $("#"+id+" > tbody").html(data['template']);
            $("#limit").val(data['limit']);
            $(".pnumber").val(data['pnumber']);
            $("#totaldata").val(data['totaldata']);
            $("#totaldata_view").text(Math.ceil(data['totaldata']/10));
            
            initPaging();
        }
    });
}

function updatelist(id, baseUrl, cntlName, page, pagenumber,submenu) {
    var pnumber = 0;
    var writer = '';
    var smenu = '';
    if (pagenumber) {
        pnumber = pagenumber;
    } else {
        pnumber = $('.pnumber').val();
    }
    
    if (submenu) {
        smenu = submenu;
    }
    
    $.ajax({
        url : baseUrl+cntlName+"/paging",
        type: "POST",
        dataType:'json',
        data : { limit:$("#limit").val(),
                page:page,
                totaldata:$("#totaldata").val(),
                pnum:pnumber,
                search:$("#search_desc").val(), 
                writer:writer,
                submenu:smenu
        },
        success: function(data)
        {
            if ($("#"+id).children("tbody").length > 0) {
                $("#"+id+" > tbody").html('');
                $("#"+id+" > tbody").html(data['template']);
            } 
            else {
                $("#"+id+"").html('');
                $("#"+id+"").html(data['template']);
            }
            
            $("#limit").val(data['limit']);
            $(".pnumber").val(data['pnumber']);
            initPaging();
        }
    });
} 

function updatelistNews(id, baseUrl, cntlName, page, pagenumber,submenu) {
    var pnumber = 0;
    var smenu = '';
    if (pagenumber) {
        pnumber = pagenumber;
    }
    
    if (submenu) {
        smenu = submenu;
    }
    
    $.ajax({
        url : baseUrl+cntlName+"/paging",
        type: "POST",
        dataType:'json',
        data : { limit:$("#limit").val(),
                page:page,
                totaldata:$("#totaldata").val(),
                pnum:pnumber,
                search:$("#search_desc").val(), 
                submenu:smenu
        },
        success: function(data)
        {
            
            $("#"+id+"").html('');
            $("#"+id+"").html(data['template']);
            
            $("#limit").val(data['limit']);
            $(".pnumber").val(data['pnumber']);
            initPagingNews();
        }
    });
} 
function updatelistPress(id, baseUrl, cntlName, page, pagenumber,submenu) {
    var pnumber = 0;
    var smenu = '';
    if (pagenumber) {
        pnumber = pagenumber;
    }
    
    if (submenu) {
        smenu = submenu;
    }
    
    $.ajax({
        url : baseUrl+cntlName+"/paging",
        type: "POST",
        dataType:'json',
        data : { limit:$("#limit").val(),
                page:page,
                totaldata:$("#totaldata").val(),
                pnum:pnumber,
                search:$("#search_desc").val(), 
                submenu:smenu
        },
        success: function(data)
        {
            
            $("#"+id+"").html('');
            $("#"+id+"").html(data['template']);
            
            $("#limit").val(data['limit']);
            $(".pnumber").val(data['pnumber']);
            initPagingPress()();
        }
    });
} 