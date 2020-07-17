    //项目成本--材料采购
    projectChange();
    $(".material_apply #project").change(function() {
        projectChange();
    });

    function projectChange() {
        $.post('/admin/project/getprogress', {
            'id': $("#project option:selected").val(),
            _token: LA.token,
        }, function(data) {
            // 渲染进度数目
            document.getElementById("progress_percent").innerHTML = data['expected'] = 0 ? 0 : (data['real'] / data['expected']) * 100;
            var unit = data['expected'] / 150;
            //设置整体宽度
            document.getElementById("white-progress").style.display = 'block';
            document.getElementById("progress").style.width = unit * data['real'];
        });
    }

    var number = 0;
    //新增条目
    $(".material_apply .apply-btn").click(function() {

        document.getElementById("table-container-content").getElementsByTagName("table")[0].getElementsByTagName("tr")[0].getElementsByTagName("td")[0].innerHTML = number + 1; //添加序号
        document.getElementById("table-container-content").getElementsByTagName("table")[0].getElementsByTagName("tr")[0].id = "row" + (number + 1); //修改新行的id属性
        var currentRow = "#row" + (number + 1);
        var content = $(currentRow).prop("outerHTML"); //包含id行在内，不用html()函数
        $("#table-container").append(content); //尾部添加
        document.getElementById("table-container").style.display = null;
        number++;
    });

    //通过材料类别 修改 市场最低价
    function changeLowprice(category) {
        //获取当前材料类别
        var select_index = category.selectedIndex; //选中项的索引值
        var category_id = category.options[select_index].value;
        var project_id = $("#project option:selected").val();

        //获取执行对象选择的材料类别
        $.post('/admin/material/getLowprice', {
            'category_id': category_id,
            'project_id': project_id,
            _token: LA.token, //删除会显示419错误
        }, function(data) {
            //渲染数据给该列的市场最低价
            //父级id并查找出当前行的
        });
    }
    //通过市场单价和数量 填充购入总量
    $("#table-container #market_price").change(function() {
        console.log(1212, $(this));
    });