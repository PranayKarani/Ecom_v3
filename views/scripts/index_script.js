$(document).ready(function () {

    // Hide category container on mouse leave
    $("#dept-category").mouseleave(function () {
        $("#category-products").hide();
    });

    // fetch and show category of the selected department
    $(".dept_link").click(function () {
        var dpt_name = $(this).text();
        $.post(
            "include/ajaxStaticClass.php",
            {
                dir: "views",
                class: "CategoryView",
                method: "show",
                params: dpt_name
            },
            function (data) {
                $("#category_container").html(data);
                $("#category-products").show();
                $(".category_link").click(function () {
                    var name = $(this).text();

                    $.post(
                        "include/ajaxStaticClass.php",
                        {
                            dir: "views",
                            class: "ProductView",
                            method: "getCategoryTopProducts",
                            params: name
                        },
                        function(data){
                            $("#category_products_container").html(data);
                            $(".category_product_link").click(function(){

                                var id = $(this).attr("id");

                                openProductInfo(id);

                            });
                        }
                    )

                });
            }
        )
    });


    $(".product_link").click(function(){

        var id = $(this).attr("id");

        openProductInfo(id);

    });

});
