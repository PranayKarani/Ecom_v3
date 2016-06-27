function searchProducts(search) {

    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ProductView",
            method: "showSearchDropdownProducts",
            params: search
        },
        function (data) {
            $("#search_suggestions").show();
            $("#search_product_suggestions").html(data);
            $(".search_product_link").click(function () {

                var id = $(this).attr("id");
                var category = $(this).find("input[name='product_category_name']").val();
                var s_text = $("#search_bar").val();

                //openProductInfo(id);
                var link = "search.php?category=" + category;
                console.info("-" + link);
                $(location).attr('href', link);

            });
        }
    );

}

function searchCategories(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "CategoryView",
            method: "showSearchedCategories",
            params: search
        },
        function (data) {
            $("#search_category_suggestions").html(data);
            $(".search_category_link").click(function () {

                var name = $(this).attr("id");

                window.location.href = "category.php?category=" + name;

            });
        }
    );
}

function searchShops(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ShopView",
            method: "showSearchedShops",
            params: search
        },
        function (data) {
            $("#search_shop_suggestions").html(data);
            $(".search_shop_link").click(function () {

                var id = $(this).attr("id");
                window.location.href = "shop.php?id=" + id;

            });
        }
    );
}

$('document').ready(function () {

    $("#search_suggestions").mouseleave(function () {
        $("#search_suggestions").hide();
    }).hide();

    $("#search_bar")
        .on("input", function () {
            var search = $(this).val();
            if (search.trim().length == 0) {
                $("#search_suggestions").hide();
            } else {
                searchProducts(search);
                searchCategories(search);
                searchShops(search);
            }
        })
        // on enter press
        .keypress(function (ev) {
            if (ev.which === 13) {
                var s_text = $(this).val();
                if (s_text.length > 0) {
                    var category = $(".search_product_link:first").find("input[name='product_category_name']").val();
                    var link = "search.php?category=" + category + "&search_text=" + s_text;
                    $(location).attr('href', link);
                }
            }
        });

    var anchor = 0;
    var currentHeight;

    $("header").mouseover(function () {
        $("header").css("height", "150");
    }).mouseleave(function () {
        $("header").css("height", currentHeight);
    });

    $(window).scroll(function () {

        var scropo = $(this).scrollTop();// (scro)ll (po)sition

        var value = 60;

        if (scropo > anchor) {
            // down
            if (window.pageYOffset > value) {
                $("header").css("height", "50");
                currentHeight = 50;
            }
        } else {
            // up
            if (window.pageYOffset < value) {
                $("header").css("height", "150");
                currentHeight = 150;
            }
        }

        anchor = scropo;


    });

});
