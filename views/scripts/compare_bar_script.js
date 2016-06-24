/**
 * Created by PranayKarani on 23/06/2016.
 */

var compare_products_array = [];
var compare_slot_counter = 0;

function addToCompare(id, category) {

    // no more that 4 allowed
    if (compare_products_array.length < 4) {

        var idPresent = false;
        for (var i = 0; i < compare_products_array.length; i++) {
            if (compare_products_array[i] == id) {
                idPresent = true;
                break;
            }
        }

        // no repeated products allowed
        if (!idPresent) {
            compare_products_array.push(id);
            do {

                if (compare_slot_counter < 4) {
                    compare_slot_counter++;
                } else {
                    compare_slot_counter = 1;
                }
                var compared_product = $(".compare_product_slot:nth-child(" + compare_slot_counter + ") .compared_product");
                var slot = $(".compare_product_slot:nth-child(" + compare_slot_counter + ")");

            } while (compared_product.text() != '');


            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "views",
                    class: "ProductView",
                    method: "showComparisonProduct",
                    params: id
                },
                function (data) {
                    compared_product.html(data);
                }
            );

            slot.attr("data-product-id", id);
            slot.attr("data-product-category", category);
            slot.attr("data-counter", compare_slot_counter);

            $("#compare_bar").slideDown();

            console.info(compare_products_array + " counter: " + compare_slot_counter);
        }

    }

}

function goCompare() {

    var IDs = '';
    var cat = '';
    $(".compare_product_slot").each(function () {

        var c = $(this).attr('data-product-category');
        if (cat == '' && c != '') {
            cat = c;
            console.info("cat selected: " + cat);
        }
    });

    var sameCategory = false;
    $(".compare_product_slot").each(function () {

        var id = $(this).attr('data-product-id');
        var category = $(this).attr('data-product-category');

        if (category != '') {
            if (cat != category) {
                sameCategory = true;
            }
        }

        if (id != null || id != '') {
            IDs += $(this).attr('data-product-id') + " ";
        }

    });

    if (sameCategory) {
        alert("cannot compare products from different category :(");
    } else {
        $(location).attr("href", "compare.php?ids=" + IDs);
    }

}

function clearAll() {
    $(".compared_product").html(null);
    compare_products_array.splice(0, 4);
    compare_slot_counter = 0;
    $("#compare_bar").slideUp();
}

function removeFromCompare() {
    $(".remove_from_compare").click(function () {

        var slot = $(this).parent();
        var id = slot.attr('data-product-id');
        slot.attr('data-product-id', "");
        slot.attr('data-product-category', "");
        id = parseInt(id);
        if (compare_slot_counter > slot.attr('data-counter') - 1) {
            compare_slot_counter = slot.attr('data-counter') - 1
        }
        compare_products_array.splice(compare_products_array.indexOf(id), 1);
        console.info(compare_products_array + " counter: " + compare_slot_counter);

        slot.find(".compared_product").html(null);


        if (compare_products_array.length == 0) {
            $("#compare_bar").slideUp();
        }
    });
}