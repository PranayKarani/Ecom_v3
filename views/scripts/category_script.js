/**
 * Created by PranayKarani on 12/06/2016.
 */
$('document').ready(function() {


    loadInitProducts();

    $(".filter_checkbox").click(function() {

        var table = $(this).attr('data-table');
        var sql = "'1' IN ('1'";
        var prev_group = "";

        var noneChecked = true;

        $(".filter_checkbox").each(function() {
            var checked = $(this).is(':checked');

            if (checked) {
                noneChecked = false;

                var cur_group = $(this).attr('data-group');
                var data = $(this).val();
                var filter = $(this).attr('name');

                var OR_AND = " OR\n";

                if (cur_group != prev_group) {
                    OR_AND = " AND\n";
                    sql += ") " + OR_AND + " " + filter + " IN (";
                } else {
                    sql += ","
                }

                sql += "'" + data + "'";

                prev_group = cur_group;
            }
        });

        var min_price = $("#min_price").val();
        var max_price = $("#max_price").val();
        var default_min_price = $("#min_price").attr('data-price');
        var default_max_price = $("#max_price").attr('data-price');
        sql += ") AND price BETWEEN " + min_price + " AND " + max_price + " AND\n";

        if (min_price != default_min_price || max_price != default_max_price) {
            noneChecked = false;
        }

        console.info("SQL: " + sql);

        if (noneChecked) {
            var category = $(".nearBy").attr('id');
            // Top products
            postStatic("views", "ProductView", "showCategoryTopProducts", category, function(data) {

                $("#center_middle").html(data).show();
                $(".nearBy").css("width", "100%");
                $("#order_by").hide();

            });

            // New Products
            postStatic("views", "ProductView", "showCategoryNewProducts", category, function(data) {

                $("#center_bottom").html(data);

            });

        } else {

            var json = getJsonString(
                {table: table},
                {string: sql}
            );
            getFilteredProducts(json);
        }


    });

    $(".nearBy").click(function() {

        var name = $(this).attr('id');

        url = "nearBy.php?category=" + name;

        $(location).attr('href', url);


    });

    $("#order_by").change(function() {
        var order_by = $("#order_by").val();

        var noneChecked = true;

        $(".filter_checkbox").each(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                noneChecked = false;
            }
        });

        if (noneChecked) {
            var search = $("#search").val();
            var category = $("#cat").val();

            if (search != null) {
                var details = [];
                details.push({search: search});
                details.push({order: order_by});

                var json = JSON.stringify(details);

                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "views",
                        class: "ProductView",
                        method: "showOrderedSearchedProducts",
                        params: json
                    },
                    function(data) {
                        $("#center_bottom").html(data);
                    }
                );
            } else if (category != null) {

                loadFilteredProducts();

            }


        } else {
            loadProducts();
        }
    });

    removeFromCompare();

});


function getFilteredProducts(json) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ProductView",
            method: "showFilteredProducts",
            params: json
        },
        function(data) {
            $("#center_middle").hide();
            $(".nearBy").css("width", "75%");
            $("#order_by").show();
            $("#center_bottom").html(data);

        }
    );
}

function loadProducts() {
    var order_by = $("#order_by").val();
    var table = $(".filter_checkbox").attr('data-table');
    var sql = "'1' IN ('1'";
    var prev_group = "";

    var noneChecked = true;

    $(".filter_checkbox").each(function() {
        var checked = $(this).is(':checked');

        if (checked) {
            noneChecked = false;

            var cur_group = $(this).attr('data-group');
            var data = $(this).val();
            var filter = $(this).attr('name');

            var OR_AND = " OR\n";

            if (cur_group != prev_group) {
                OR_AND = " AND\n";
                sql += ") " + OR_AND + " " + filter + " IN (";
            } else {
                sql += ","
            }

            sql += "'" + data + "'";

            prev_group = cur_group;
        }
    });

    var min_price = $("#min_price").val();
    var max_price = $("#max_price").val();
    var default_min_price = $("#min_price").attr('data-price');
    var default_max_price = $("#max_price").attr('data-price');
    sql += ") AND price BETWEEN " + min_price + " AND " + max_price + " AND\n";

    if (min_price != default_min_price || max_price != default_max_price) {
        noneChecked = false;
    }

    console.info("SQL: " + sql);

    if (noneChecked) {
        var search = $("#search").val();
        var category = $("#cat").val();

        if (search != null) {
            postStatic("views", "ProductView", "showSearchedProducts", search, function(data) {
                    console.info(data);
                    $("#center_bottom").html(data);

                }
            );
        } else if (category != null) {

            loadFilteredProducts();

        }


    } else {

        var json = getJsonString(
            {table: table},
            {string: sql},
            {order: order_by}
        );

        getFilteredProducts(json);
    }


}

function loadFilteredProducts() {
    var table = $(".filter_checkbox").first().attr('data-table');

    var order_by = $("#order_by").val();

    var details = [];
    details.push({table: table});
    details.push({string: ''});
    details.push({order: order_by});

    var json = JSON.stringify(details);
    getFilteredProducts(json);
}

function loadInitProducts() {
    var table = $(".filter_checkbox").attr('data-table');
    var sql = "'1' IN ('1'";

    var noneChecked = true;

    $(".filter_checkbox").each(function() {
        var checked = $(this).is(':checked');

        if (checked) {
            noneChecked = false;
            var cur_group = $(this).attr('data-group');
            var data = $(this).val();
            var filter = $(this).attr('name');

            var OR_AND = " OR\n";

            if (cur_group != prev_group) {
                OR_AND = " AND\n";
                sql += ") " + OR_AND + " " + filter + " IN (";
            } else {
                sql += ","
            }

            sql += "'" + data + "'";

            prev_group = cur_group;

        }
    });

    var min_price = $("#min_price").val();
    var max_price = $("#max_price").val();
    var default_min_price = $("#min_price").attr('data-price');
    var default_max_price = $("#max_price").attr('data-price');
    sql += ") AND price BETWEEN " + min_price + " AND " + max_price + " AND\n";

    if (min_price != default_min_price || max_price != default_max_price) {
        noneChecked = false;
    }

    console.info("SQL: " + sql);

    if (noneChecked) {
        var category = $("#cat").val();
        // Top products
        postStatic("views", "ProductView", "showCategoryTopProducts", category, function(data) {

            $("#center_middle").html(data).show();
            $(".nearBy").css("width", "100%");
            $("#order_by").hide();

        });

        // New Products
        postStatic("views", "ProductView", "showCategoryNewProducts", category, function(data) {

            $("#center_bottom").html(data);

        });

    } else {

        var json = getJsonString(
            {table: table},
            {string: sql}
        );

        getFilteredProducts(json);
    }
}