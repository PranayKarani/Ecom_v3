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
            $("#search_suggestions").html(data).show();
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
            $("#search_suggestions").append(data).show();
            $(".search_category_link").click(function () {

                var name = $(this).attr("id");

                window.location.href = "category.php?category=" + name;

            });
        }
    );
}

function openProductInfo(id) {

    // TODO make it post instead of get
    window.location.href = "productInfo.php?id=" + id;

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


});
