$(document).ready(function(e){
   var id;
    $.ajax({
        url:'ajax.php',
        type: 'post',
        data: {
            type:"allData"
        },
        success:function(data,status){
            $("#tbl").html(data);

           
        }
    });

    function fetch_data(pageId){
        $.ajax({
            url:'ajax.php',
            type:'post',
            data: {
                pageId:pageId
            },
            success: function(data, status){
                $("#tbl").html(data);
            }

        });
    }




    function pagination(totalpages, currentPages){
        var pagelist = "";
        if(totalpages>1){
                currentPages=parseInt(currentPages);
                pagelist+=` <ul class="pagination justify-content-center">`;

                const prevClass=currentPages==1?"disabled":"";

                pagelist+=` <li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${currentPages-1}">Prevouse</a></li> `;

                for(let p=1; p<=totalpages;p++){
                    const activeClass=currentPages==p?"active":"";
                pagelist+=`<li class="page-item "><a class="page-link" href="#" id="${p}" data-page="${p}">${p}</a></li>`;
                }

                const nextClass=currentPages==totalpages?"disabled":"";

                pagelist+=`  <li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${currentPages+1}">Next</a></li> `;


                pagelist+=`</ul>`;
                
            }

            $("#pagination").html(pagelist);
    }


    $(document).on('click', 'ul.pagination li a', function(e){
        e.preventDefault();
        const pagenum=$(this).data("page");
        $("#currentpage").val(pagenum);
        getusers();
        $(this).parent().siblings().removeClass("active");
        $(this).parent().addClass("active");
       
    });


    function getusers(){
        var pageno=$("#currentpage").val();
        $.ajax({
            url:"ajax.php",
            type:'post',
            dataType:"json",
            data:{page:pageno,type:'getallusers'},
            beforeSend: function(){
                console.log("wait...");
            },
            success: function(data,status){
                $("#tbl").html(data);
                let totaluser= $("#row").val();

                let totalpages=Math.ceil(parseInt(totaluser)/4);
                const currentPages=$("#currentpage").val();
                pagination(totalpages,currentPages);
            },
            error: function(request, error){
                console.log(arguments);
                console.log("error " + error);
            }
        });
    }

    function getRowCount(){
        $.ajax({
            url:"ajax.php",
            type:"post",
            data:{
                type:"getrowcount"
            },
            success:function(data,status){
            
                $("#row").val(data);
            },
            error:function(request, error){console.log(arguments); console.log("error " + error);}
        });
    }
    getRowCount();
    getusers();
});