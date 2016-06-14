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
                // what happens when you click the category
                $(".category_link").click(function () {
                    var name = $(this).attr('datatype');

                    $.post(
                        "include/ajaxStaticClass.php",
                        {
                            dir: "views",
                            class: "ProductView",
                            method: "showCategoryTopProducts",
                            params: name
                        },
                        function(data){
                            $("#category_products_container").html(data);
                            $(".category_product_link").click(function(){

                                var id = $(this).attr("id");

                                openProductInfo(id);

                            });
                        }
                    );
                });

                $(".view_all").click(function () {


                    var name = $(this).attr("id");
                    var url = "category.php?category=" + name;
                    //window.location.href = "category.php?category=" + name;
                    $(location).attr('href', url);

                });

            }
        )
    });


    $(".product_link").click(function(){

        var id = $(this).attr("id");

        openProductInfo(id);

    });

});
