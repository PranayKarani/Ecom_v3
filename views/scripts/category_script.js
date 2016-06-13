/**
 * Created by PranayKarani on 12/06/2016.
 */
$('document').ready(function () {

    $(".filter_checkbox").click(function () {

        var table = $(this).attr('datatype');
        var sql = '';

        $(".filter_checkbox").each(function () {
            var checked = $(this).is(':checked');

            if (checked) {
                var data = $(this).val();
                var filter = $(this).attr('name');

                sql += filter + "='" + data + "' AND\n";
            }
        });

        var details = [];
        details.push({table: table});
        details.push({string: sql});

        var json = JSON.stringify(details);

        getFilteredProducts(json);


    });

    $(".category_product_link").click(function () {
        var id = $(this).attr('id');
        openProductInfo(id);
    });

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
        function (data) {

            console.info(data);
            $("#center_section").html(data);

            $(".filtered_product_link").click(function () {
                var id = $(this).attr("id");

                openProductInfo(id);
            });

        }
    );
}