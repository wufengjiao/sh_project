<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>this is a title</title>
        <script>
        // function money(id){
        //     var test01 = document.getElementById("test01");
        //     var test02 = document.getElementById("test02");
        //     if (test01 <= test02 && (!isNaN(test01) || !isNaN(test02))){
        //         document.getElementById(id).setAttribute("style","color:red");
        //     }
        // }
        // $(function () {
        //     $( '.test01 .test02' ).blur( function(){
        //         var test01 = document.getElementById("test01");
        //         var test02 = document.getElementById("test02");
        //         if (test01 <= test02){
        //             document.getElementById("test01").setAttribute("style","color:red");
        //             document.getElementById("test02").setAttribute("style","color:red");
        //         }
        //     });
        // })
        //                $( '.expected_labor .expected_materials .expected_others' ).blur( function(){
        //                console.log(22222);return
        //                    var contract_price = document.getElementById("contract_price").value;
        //                    var perprofit = document.getElementById("perprofit").val;
        //                    var expected = contract_price * ( perprofit / 100);
        //
        //                    var expected_labor = document.getElementById("expected_labor").value;
        //                    var expected_materials = document.getElementById("expected_materials").value;
        //                    var expected_others = document.getElementById("expected_others").value;
        //                    var cur_sum = expected_labor + expected_materials + expected_others;
        //                    if(cur_sum > expected){
        //                            document.getElementById(id).setAttribute("style","color:red");
        //                    }
        //                } )
        //                function contMoney()
        //                {
        //                    var contract_price = document.getElementById("contract_price").value;
        //                    var perprofit = document.getElementById("perprofit").val;
        //                    var expected = contract_price * ( perprofit / 100);
        //                    console.log(expected);
        //                    var expected_labor = document.getElementById("expected_labor").value;
        //                    var expected_materials = document.getElementById("expected_materials").value;
        //                    var expected_others = document.getElementById("expected_others").value;
        //                    var cur_sum = expected_labor + expected_materials + expected_others;
        //                    if(cur_sum > expected){
        //                            document.getElementById(id).setAttribute("style","color:red");
        //                    }
        //                }

        </script>
    </head>
    <body>
       <div>
           较小值：<input type="text" id="test01" onblur="money(this.id)"><br/>
           较大值：<input type="text" id="test02" onblur="money(this.id)">
<!--           较小值：<input type="text" id="test01"><br/>-->
<!--           较大值：<input type="text" id="test02">-->
       </div>
    </body>
</html>
