/**
 * Created by PranayKarani on 13/06/2016.
 */
$(document).ready(function () {

    $(".shop_product_link").click(function () {
        var id = $(this).attr('id');
        openProductInfo(id);
    });

    $(".shop_list").click(function () {

        var id = $(this).attr('id');
        var category = $(".data").attr('id');

        var url = "shop.php?category=" + category + "&id=" + id;

        $(location).attr('href', url);

    });

});
