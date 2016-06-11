function searchProducts(search){

    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ProductView",
            method: "showSearchProducts",
            params: search
        },
        function(data){
            $("#search_suggestions").html(data).show();
            $(".search_product_link").click(function(){

                var id = $(this).attr("id");

                openProductInfo(id);

            });
        }
    );

}

function searchCategories(search){
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "CategoryView",
            method: "showSearchedCategories",
            params: search
        },
        function(data){
            $("#search_suggestions").append(data).show();
            $(".search_category_link").click(function(){

                var name = $(this).attr("id");

                alert(name);

            });
        }
    );
}

function openProductInfo(id){

    // TODO make it post instead of get
    window.location.href = "productInfo.php?id=" + id;

}

$('document').ready(function() {

    $("#search_suggestions").mouseleave(function(){
        $("#search_suggestions").hide();
    }).hide();

    $("#search_bar").on("input",function(){
        var search = $(this).val();
        if(search == '') {
            $("#search_suggestions").hide();
        } else {
            searchProducts(search);
            searchCategories(search);
        }
    });

});
