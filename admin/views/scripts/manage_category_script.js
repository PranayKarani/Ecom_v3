function search_categories(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ASearchView",
            method: "showCategorySearch",
            params: search
        },
        function (data) {
            $("#search_results_box").html(data).show();
            $(".search_result_link").click(function () {
                var x = $(this);
                var name = x.text();
                window.location.replace("manageCategory.php?name=" + name);
            });

            $(".input").on("input", function () {
                $("#submit_update").attr('disabled', false);
            });

        }
    )
}


$(document).ready(function () {

    // init
    search_categories('');

    // on category search
    $(".search_bar").on("input", function () {
        var search = $(this).val();
        search_categories(search);
    });

    $("#input_new").change(function () {
        $("#submit_new").attr('disabled', false);
    });


    // on submitting a new category
    $("#submit_new").click(function () {

        var formComplete = true;
        var details = [];

        $('.input_new').each(function (i) {
            var name = $(this).attr("id");
            var value = $(this).val();
            if (value == null || value == '') {
                formComplete = false;
            }
            var obj = {};
            obj[name] = value;
            details.push(obj);
        });
        var json = JSON.stringify(details);

        if (formComplete) {
            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "ACategoryController",
                    method: "addNewCategory",
                    params: json
                }, function (data) {
                    console.info(data);
                    search_categories('');
                }
            )
        } else {
            alert("form incomplete");
        }

    });

    $("#delete_category_button").click(function () {

        $name = $("#name").val();

        if($name == null || $name == ''){
            alert("no category selected");
        } else {
            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "ACategoryController",
                    method: "deleteCategory",
                    params: $name
                }, function (data) {
                    console.info(data);
                    search_categories('');
                }
            )
        }

    });

});