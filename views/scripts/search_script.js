/**
 * Created by PranayKarani on 12/06/2016.
 */
$('document').ready(function() {

    $(".filter_checkbox").click(function() {
        loadProducts();
    });

    $(".nearBy").click(function() {

        var name = $(this).attr('id');

        url = "nearBy.php?category=" + name;

        $(location).attr('href', url);


    });

    $("#order_by").change(function() {
        var order_by = $("#order_by").val();

        var noneChecked = true;

        // checking if any filter is applied or not
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

                var json = getJsonString(
                    {search: search},
                    {order: order_by}
                );

                postStatic("views", "ProductView", "showOrderedSearchedProducts", json, function(data) {

                    $("#center_bottom").html(data);

                });

            } else if (category != null) {

                loadFilteredProducts();

            }


        } else {
            loadProducts();
        }
    });

    removeFromCompare();

});

function loadProducts() {
    var order_by = $("#order_by").val();
    var table = $(".filter_checkbox").first().attr('data-table');
    var sql = "'1' IN ('1'";

    var noneChecked = true;
    var prev_group = "";

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

                    $("#center_bottom").html(data);

                }
            );
        } else if (category != null) {

            loadFilteredProducts();

        }


    } else {
        var details = [];
        details.push({table: table});
        details.push({string: sql});
        details.push({order: order_by});

        var json = JSON.stringify(details);

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

            $("#center_bottom").html(data);


        }
    );
}