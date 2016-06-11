function search_products(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "SearchView",
            method: "showProductsSearch",
            params: search
        },
        function (data) {
            $("#search_results_box").html(data).show();
            $(".search_result_link").click(function () {
                var x = $(this);
                var id = x.find("input[name='id']").val();

                window.location.replace("manageProduct.php?id=" + id);

            });
            $(".input_basic").on("input", function () {
                $("#submit_basic").attr('disabled', false);
                var keywords = $("#category").val() + " " + $("#brand").val() + " " + $("#product_name").val();
                $("#keywords").val(keywords);
            });
            $(".input_advance").on("input", function () {
                $("#submit_advance").attr('disabled', false);
            });

            $("#submit_basic").click(function () {

                // TODO check for empty fields
                $("#submit_basic").attr('disabled', true);
                var basic_details = [];
                $('.input_basic').each(function (i) {
                    var name = $(this).attr("id");
                    var value = $(this).val();
                    var obj = {};
                    obj[name] = value;
                    basic_details.push(obj);
                });
                var json = JSON.stringify(basic_details);
                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "controllers",
                        class: "ProductController",
                        method: "updateBasicProductDetails",
                        params: json
                    },
                    function (data) {
                        console.info("json: " + json);
                        console.info("SQL: " + data);
                    }
                );

            });

            $("#submit_advance").click(function () {

                // TODO check for empty fields
                $("#submit_advance").attr('disabled', true);
                var advanced_details = [];
                $('.input_advance').each(function (i) {
                    var name = $(this).attr("id");
                    var value = $(this).val();
                    var obj = {};
                    obj[name] = value;
                    advanced_details.push(obj);
                });
                var json = JSON.stringify(advanced_details);

                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "controllers",
                        class: "ProductController",
                        method: "updateAdvanceProductDetails",
                        params: json
                    },
                    function (data) {
                        console.info("json: " + json);
                        console.info("SQL: " + data);
                    }
                );


            });

        }
    )
}


$(document).ready(function () {

    // init
    search_products('');

    // on products search
    $(".search_bar").on("input", function () {
        var search = $(this).val();
        search_products(search);
    });

    $("#new_product_category").change(function () {
        $("#add_new_product_button").attr('disabled', false);
    });

    $("#add_new_product_button").click(function () {
        var category = $("#new_product_category").val();
        $(this).attr('disabled', true);
        $("#right_center").load(
            "include/ajaxStaticClass.php",
            {
                dir: "views",
                class: "ProductView",
                method: "show_ui_for_new",
                params: category
            },
            function (data) {

                $(".input_basic_new").on("input", function () {
                    var keywords = $("#new_product_category").val() + " " + $("#new_brand").val() + " " + $("#new_product_name").val();
                    $("#new_keywords").val(keywords);
                });

                $("#submit_new").click(function () {

                    var formComplete = true;
                    var lastID = null;

                    // get basic stuff
                    var basic_details = [];
                    $('.input_basic_new').each(function (i) {
                        var name = $(this).attr("id");
                        var value = $(this).val();
                        if (value == '' || value == null) {
                            formComplete = false;
                        }
                        var obj = {};
                        obj[name] = value;
                        basic_details.push(obj);
                    });
                    var json_basic = JSON.stringify(basic_details);

                    if (formComplete) {
                        // basic
                        console.info("BASIC");
                        $.post(
                            "include/ajaxStaticClass.php",
                            {
                                dir: "controllers",
                                class: "ProductController",
                                method: "addNewBasicProductDetails",
                                params: json_basic
                            },
                            function (data) {
                                console.info("json: " + json_basic);
                                lastID = data;

                                // get advnace stuff
                                var advance_details = [];
                                advance_details.push({
                                    product_id: lastID
                                });
                                $('.input_advance_new').each(function (i) {
                                    var name = $(this).attr("id");
                                    var value = $(this).val();
                                    if (value == '' || value == null) {
                                        formComplete = false;
                                    }
                                    var obj = {};
                                    obj[name] = value;
                                    advance_details.push(obj);
                                });
                                var json_advance = JSON.stringify(advance_details);

                                // advanced
                                console.info("ADVANCE");
                                $.post(
                                    "include/ajaxStaticClass.php",
                                    {
                                        dir: "controllers",
                                        class: "ProductController",
                                        method: "addNewAdvancedProductDetails",
                                        params: json_advance
                                    },
                                    function (data) {
                                        console.info("json: " + json_advance);
                                        console.info("SQL: " + data);
                                        search_products('');
                                    }
                                );

                            }
                        );
                    } else {
                        alert("Incomplete form");
                    }

                });
            }
        )
    });

    $("#delete_product_button").click(function () {
        var pID = $("#product_id").val();
        //var table_name = "c__" + $("#category").val();
        //var obj = {
        //    "pID": pID,
        //    "table": table_name
        //};
        //var arr = [];
        //arr.push(obj);
        //var json = JSON.stringify(arr);

        $.post(
            "include/ajaxStaticClass.php",
            {
                dir: "controllers",
                class: "ProductController",
                method: "deleteProduct",
                params: pID
            }, function (data) {
                search_products('');
            }
        );
    });


    $("#add_new_brand_button").click(function () {
        var b_name = $("#new_brand_name").val();
        if(b_name=='' || b_name == null){
            alert("Incomplete details");
        } else{

            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "BrandController",
                    method: "addNewBrand",
                    params: b_name
                },
                function(data){
                    alert(data);
                }
            )

        }
    });

});