/**
 * Created by PranayKarani on 11/06/2016.
 */
var selectedShop = -1;
function search_products(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "SSearchView",
            method: "showProductsSearch",
            params: search
        }, function (data) {
            $("#search_results_box").html(data).show();
            $(".search_result_link").click(function () {
                var id = $(this).find("input[name='id']").val();

                var details = [];
                var object = {
                    product: id,
                    shop: selectedShop
                };
                details.push(object);

                var json = JSON.stringify(details);

                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "views",
                        class: "SProductView",
                        method: "showProductDetails",
                        params: json
                    },
                    function (data) {
                        $("#right_section").html(data);
                        productOperations(id);
                    }
                )

            });
        }
    )
}

$("document").ready(function () {
    search_products('');

    // on products search
    $(".search_bar").on("input", function () {
        var search = $(this).val();
        search_products(search);
    });

    $("#shop_select_button").click(function () {
        selectedShop = $("#shop_selector").val();
        refreshInventoryProducts();

    });

    $("#logout").click(function () {
        $.get("logout.php", function (data) {
            window.location.replace("../");
        })
    });

});

function productOperations(pID) {

    var qty = $("#qty").val();

    var add = false;// add = !update

    if (qty == 0) {
        add = true;
    }

    $("#update").click(function () {
        var qty = $("#qty").val();
        var price = $("#price").val();

        var details = [];
        details.push({shop: selectedShop});
        details.push({product: pID});
        details.push({qty: qty});
        details.push({price: price});
        details.push({shop_specific_info: '-'});

        var json = JSON.stringify(details);

        if (qty == 0) {
            // remove
            add = true;

            if(selectedShop == -1){
                alert("select a shop first")
            } else {

                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "controllers",
                        class: "SProductController",
                        method: "removeInventoryProduct",
                        params: json
                    },
                    function (data) {
                        console.info("SQL: " + data);
                        refreshInventoryProducts();
                    }
                )
            }
        } else {

            if (add) {
                add = false;
                // Add

                if (selectedShop == -1) {
                    alert("select shop first")
                } else if(price == 0){
                    alert("priced 0");
                } else {
                    $.post(
                        "include/ajaxStaticClass.php",
                        {
                            dir: "controllers",
                            class: "SProductController",
                            method: "addInventoryProduct",
                            params: json
                        },
                        function (data) {
                            console.info("SQL:" + data);
                            refreshInventoryProducts();
                        }
                    )
                }

            } else {
                // Update
                if (selectedShop == -1) {
                    alert("select shop first")
                } else if(price == 0){
                    alert("priced 0");
                } else {
                    $.post(
                        "include/ajaxStaticClass.php",
                        {
                            dir: "controllers",
                            class: "SProductController",
                            method: "updateInventoryProduct",
                            params: json
                        },
                        function (data) {
                            console.info("SQL: " + data);
                            refreshInventoryProducts();
                        }
                    )
                }

            }

        }

    });

}

function refreshInventoryProducts(){
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "SProductView",
            method: "showShopProducts",
            params: selectedShop
        }, function (data) {
            $("#center_section").html(data).show();
            $(".product_link").click(function () {
                var x = $(this);
                var id = x.attr("id");

                console.info(id);

                var details = [];
                var object = {
                    shop: selectedShop,
                    product: id
                };
                details.push(object);

                var json = JSON.stringify(details);

                $.post(
                    "include/ajaxStaticClass.php",
                    {
                        dir: "views",
                        class: "SProductView",
                        method: "showShopProductDetails",
                        params: json
                    },
                    function (data) {
                        $("#right_section").html(data);
                        productOperations(id);
                    }
                )

            });
        }
    )
}