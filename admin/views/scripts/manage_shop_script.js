function search_shops(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ASearchView",
            method: "showShopSearch",
            params: search
        },
        function (data) {
            $("#search_results_box").html(data).show();
            $(".search_result_link").click(function () {
                var x = $(this);
                var id = x.find("input[name='id']").val();
                window.location.replace("manageMarket.php?id=" + id);
            });

            $(".input").on("input", function () {
                $("#submit_update").attr('disabled', false);
            });


            $("#submit_update").click(function () {

                var formEmpty = false;

                $("#submit_update").attr('disabled', true);

                var details = [];
                $('.input').each(function (i) {
                    var name = $(this).attr("id");
                    var value = $(this).val();
                    if (value == '' || value == null) {
                        formEmpty = true;
                    }
                    var obj = {};
                    obj[name] = value;
                    details.push(obj);
                });
                var json = JSON.stringify(details);

                if(formEmpty){
                    alert("incomplete form");
                } else {
                    $.post(
                        "include/ajaxStaticClass.php",
                        {
                            dir: "controllers",
                            class: "AShopController",
                            method: "updateDetails",
                            params: json
                        },
                        function (data) {
                            console.info("JSON:\n " + json);
                            console.info("SQL:\n " + data);
                        }
                    );
                }


            });

        }
    )
}

$('document').ready(function () {

    search_shops('');

    $(".search_bar").on("input", function () {
        var search = $(this).val();
        search_shops(search);
    });

    $("#submit_new").click(function () {

        var formEmpty = false;

        $("#submit_new").attr('disabled', true);

        var details = [];
        $('.input_new').each(function (i) {
            var name = $(this).attr("id");
            var value = $(this).val();
            if (value == '' || value == null) {
                formEmpty = true;
            }
            var obj = {};
            obj[name] = value;
            details.push(obj);
        });
        var json = JSON.stringify(details);

        if(formEmpty){
            alert("incomplete form");
        } else {
            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "AShopController",
                    method: "addNewShop",
                    params: json
                },
                function (data) {
                    console.info("JSON:\n " + json);
                    console.info("SQL:\n " + data);
                    search_shops('');
                }
            );
        }


    });

    $(".input_new").on("input", function(){
        $("#submit_new").attr('disabled', false);
    });

    $("#delete_shop_button").click(function(){

        var id = $("#shop_id").val();

        $.post(
            "include/ajaxStaticClass.php",
            {
                dir: "controllers",
                class: "AShopController",
                method: "removeShop",
                params: id
            }, function(data){
                console.info("Deleted shop no."+id+".\nData: " + data);
                search_shops('');
            });

    });

});