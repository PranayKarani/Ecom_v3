$(document).ready(function() {

    // Hide category container on mouse leave
    $("#dept-category").mouseleave(function() {
        $("#category-products").slideUp();
    });

    // fetch and show category of the selected department
    $(".dept_link").click(function() {
        var dpt_name = $(this).text();

        postStatic("views", "CategoryView", "show", dpt_name, function(data) {
            $("#category_container").html(data);
            $("#category_products_container").html(null);
            $("#category-products").slideDown();
            $(".category_link_name").click(function() {

                var cat_name = $(this).attr('data-name');
                postStatic("views", "ProductView", "showCategoryTopProducts", cat_name, function(data) {
                    $("#category_products_container").html(data);
                });
            });

        });
    });

    postStatic("views", "ProductView", "showTopProducts", 5, function(data) {
        $("#top-products").html(data);

    });

    postStatic("views", "ProductView", "showNewProducts", 5, function(data) {
        $("#new-products").html(data);

    });

});
