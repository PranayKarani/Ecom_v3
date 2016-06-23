/**
 * Created by PranayKarani on 12/06/2016.
 */
$('document').ready(function () {

    $(".filter_checkbox").click(function () {
        loadProducts();
    });

    $(".product_link").click(function () {

        var id = $(this).attr('id');

        openProductInfo(id);

    });

    $(".nearBy").click(function () {

        var name = $(this).attr('id');

        url = "nearBy.php?category=" + name;

        $(location).attr('href', url);


    });

    $("#order_by").change(function () {
        var order_by = $("#order_by").val();

        var noneChecked = true;

        $(".filter_checkbox").each(function () {
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
                    function (data) {

                        $("#center_bottom").html(data);

                        $(".product_link").click(function () {
                            var id = $(this).attr("id");

                            openProductInfo(id);
                        });

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

function loadProducts() {
    var order_by = $("#order_by").val();
    var table = $(".filter_checkbox").attr('datatype');
    var sql = '';

    var noneChecked = true;

    $(".filter_checkbox").each(function () {
        var checked = $(this).is(':checked');

        if (checked) {
            noneChecked = false;
            var data = $(this).val();
            var filter = $(this).attr('name');

            sql += filter + "='" + data + "' AND\n";
        }
    });

    if (noneChecked) {
        var search = $("#search").val();
        var category = $("#cat").val();

        if (search != null) {
            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "views",
                    class: "ProductView",
                    method: "showSearchedProducts",
                    params: search
                },
                function (data) {

                    $("#center_bottom").html(data);

                    $(".product_link").click(function () {
                        var id = $(this).attr("id");

                        openProductInfo(id);
                    });

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
        console.info(sql);

        var json = JSON.stringify(details);

        getFilteredProducts(json);
    }


}

function loadFilteredProducts() {
    var table = $(".filter_checkbox:first").attr('datatype');

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
        function (data) {

            $("#center_bottom").html(data);

            $(".product_link").click(function () {
                var id = $(this).attr("id");

                openProductInfo(id);
            });

        }
    );
}