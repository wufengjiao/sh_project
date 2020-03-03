$(function () {
    //项目成本--材料采购
    projectChange();
    $(".material_apply #project").change(function () {
        projectChange();
    });
    function projectChange() {
        $.ajax({
            type:'GET',
            dataType:'JSON',
            url:"/admin/project/getprogress",
            data:{
                id:$("#project option:selected").val(),
            },
            success:function (data) {
                // 渲染进度数目
                document.getElementById("progress_percent").innerHTML = data['expected']=0?0:(data['real'] / data['expected']) * 100;
                var unit = data['expected'] / 150;
                //设置整体宽度
                document.getElementById("white-progress").style.display='block';
                document.getElementById("progress").style.width = unit * data['real'];
            }
        });
    }
    var number = 0;
    //新增条目
    $(".material_apply .apply-btn").click(function () {
        //给table-container-content中的第一个空格添加序号
        document.getElementById("table-container-content")
            .getElementsByTagName("table")[0].getElementsByTagName("tr")[0].getElementsByTagName("td")[0].innerHTML = number + 1;
        //插入对象 table-container 下面，table-tail 的上面
        var content = document.getElementById("table-container-content").innerHTML;
        var table = document.getElementById("table-container");
        table.innerHTML = table.innerHTML + content;

        document.getElementById("table-container").style.display=null;
        number++;
    });

    //通过材料类别 修改 市场最低价
    $(".material_apply #category").change(function () {
        //获取执行对象选择的材料类别
        $.ajax({
            type:"GET",
            dataType:'JSON',
            url:'/admin/material/getLowprice',
            data:
                {
                    'material_id':this.value,
                },
            success:function (data) {
                console.log(1212);return
            }
        });
    });
    //通过市场单价和数量 填充购入总量

    //项目成本--材料采购 自定义
    // $(".attendace_view .screen-btn").click(function () {
    //     if ($(".attendace_view #filter-box").is(':visible')) {
    //         $(".attendace_view #filter-box").addClass('hide');
    //     } else {
    //         $(".attendace_view #filter-box").removeClass('hide');
    //     }
    // });

});
