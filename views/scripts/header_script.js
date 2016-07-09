var loggedIn = false;
var user_id = -1;
var wishlist_count = -1;
var header_height;

function searchProducts(search) {

    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ProductView",
            method: "showSearchDropdownProducts",
            params: search
        },
        function(data) {
            $("#search_suggestions").show();
            $("#search_product_suggestions").html(data);
            $(".search_product_link").click(function() {

                var id = $(this).attr("id");
                var category = $(this).find("input[name='product_category_name']").val();
                var s_text = $("#search_bar").val();

                //openProductInfo(id);
                var link = "search.php?category=" + category;
                console.info("-" + link);
                $(location).attr('href', link);

            });
        }
    );

}

function searchCategories(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "CategoryView",
            method: "showSearchedCategories",
            params: search
        },
        function(data) {
            $("#search_category_suggestions").html(data);
            $(".search_category_link").click(function() {

                var name = $(this).attr("id");

                window.location.href = "category.php?category=" + name;

            });
        }
    );
}

function searchShops(search) {
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "views",
            class: "ShopView",
            method: "showSearchedShops",
            params: search
        },
        function(data) {
            $("#search_shop_suggestions").html(data);
            $(".search_shop_link").click(function() {

                var id = $(this).attr("id");
                openShopPage(id, null);

            });
        }
    );
}

function onLoginSuccess(name, id) {
    $("#header_login_button").text(name);
    $("#login_modal").slideUp();
    loggedIn = true;
    user_id = id;

    // count cart
    countCart(id);

    // count wishlist
    countWishlist(id);
}

function countWishlist(id) {
    postStatic("controllers", "UserController", "countWishlist", id, function(data) {
        data = parseInt(data);
        if (data > 0) {
            $("#header_wishlist_button").text("Wishlist: " + data);
            wishlist_count = data;
        } else {
            $("#header_wishlist_button").text("Wishlist");
            wishlist_count = 0;
        }
    });
}

function countCart(id) {
    postStatic("controllers", "UserController", "countCart", id, function(data) {
        data = parseInt(data);
        if (data > 0) {
            $("#header_cart_button").text("Cart: " + data);
            wishlist_count = data;
        } else {
            $("#header_cart_button").text("Cart");
            wishlist_count = 0;
        }
    });
}

function gotoProfile() {
    // TODO go to profile
    alert("go to profile for ID: " + user_id);
}

$('document').ready(function() {

    header_height = $("header").css("height");

    // auto login
    // check if signed in
    $.post(
        "include/ajaxStaticClass.php",
        {
            dir: "controllers",
            class: "UserController",
            method: "isLoggedIn",
            params: null
        },
        function(data) {
            console.info("is logged in: " + data);
            var u_data = JSON.parse(data);
            var id = parseInt(u_data.id);
            var name = u_data.name;

            if (id > 0) {
                onLoginSuccess(name, id);
            } else {
                window.setTimeout(function() {
                    $("#login_modal").slideDown();
                }, 2000);
            }
        }
    );

    $("#search_suggestions").mouseleave(function() {
        $("#search_suggestions").hide();
    }).hide();

    $("#search_bar")
        .on("input", function() {
            var search = $(this).val();
            if (search.trim().length == 0) {
                $("#search_suggestions").hide();
            } else {
                searchProducts(search);
                searchCategories(search);
                searchShops(search);
            }
        })
        // on enter press
        .keypress(function(ev) {
            if (ev.which === 13) {
                var s_text = $(this).val();
                if (s_text.length > 0) {
                    var category = $(".search_product_link:first").find("input[name='product_category_name']").val();
                    var link = "search.php?category=" + category + "&search_text=" + s_text;
                    $(location).attr('href', link);
                }
            }
        });

    /**
     * Sticky Header stuff
     */

    var anchor = 0;
    var currentHeight;

    //$("header").mouseover(function() {
    //    $("header").css("height", "150");
    //    $(".header_mini_hide").show();
    //    $(".header_mini_show").css("height", "50%");
    //}).mouseleave(function() {
    //    $("header").css("height", currentHeight);
    //    if (currentHeight < 150) {
    //        $(".header_mini_hide").hide();
    //        $(".header_mini_show").css("height", "100%");
    //    } else {
    //        $(".header_mini_hide").show();
    //        $(".header_mini_show").css("height", "50%");
    //    }
    //});

    $(window).scroll(function() {

        var scropo = $(this).scrollTop();// (scro)ll (po)sition

        var value = 60;

        if (scropo > anchor) {
            // down
            if (window.pageYOffset > value) {
                $("header").css("height", "50");
                $(".header_mini_hide").hide();
                $(".header_mini_show").css("height", "100%");
                currentHeight = 50;
            }
        } else {
            // up
            if (window.pageYOffset < value) {
                $("header").css("height", header_height);
                $(".header_mini_hide").show();
                $(".header_mini_show").css("height", "50%");
                currentHeight = header_height;
            }
        }

        anchor = scropo;


    });

    /**
     * Login and Sign Up stuff
     */

        // Sign Up
    $("#signup_button").click(function() {
        var fieldEmpty = false;

        var name = $("#signup_name").val();
        var email = $("#signup_email").val();
        var contact = $("#signup_contact").val();
        var password = $("#signup_password").val();

        if (name == "" || email == "" || contact == "" || password == "") {
            fieldEmpty = true;
        }

        if (fieldEmpty) {
            alert("incomplete information");
        } else {
            var details = [];
            details.push({customer_name: name});
            details.push({customer_password: password});
            details.push({customer_contact: contact});
            details.push({customer_email: email});
            var json = JSON.stringify(details);

            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "UserController",
                    method: "addNewUser",
                    params: json
                },
                function(data) {
                    console.info("on signup: " + data);
                    data = parseInt(data);
                    switch (data) {
                        case -1:
                            // signup fail OR query cannot be excuted correctly
                            break;
                        case -2: // user already exists
                            alert("user already registered with this email");
                            break;
                        default:
                            onLoginSuccess(name, data);
                            break;
                    }
                }
            );

        }

    });

    // Log in
    $("#login_button").click(function() {
        var fieldEmpty = false;

        var email = $("#login_email").val();
        var password = $("#login_password").val();

        if (email == "" || password == "") {
            fieldEmpty = true;
        }

        if (fieldEmpty) {
            alert("incomplete information");
        } else {
            var details = [];

            details.push({email: email});
            details.push({password: password});

            var json = JSON.stringify(details);

            $.post(
                "include/ajaxStaticClass.php",
                {
                    dir: "controllers",
                    class: "UserController",
                    method: "login",
                    params: json
                },
                function(data) {

                    if (data == -1) {
                        alert("incorrect email or password");
                    } else {
                        var u_data = JSON.parse(data);
                        var id = parseInt(u_data.id);
                        var name = u_data.name;
                        onLoginSuccess(name, id);
                        location.reload();
                    }
                }
            );

        }

    });

    $("#close_modal").click(function() {
        $("#login_modal").slideUp();
    });

    $("#header_login_button").click(function() {

        if (!loggedIn) {
            $("#login_modal").slideDown();
        }

    });

    $("#header_login").mouseover(function() {
        if (loggedIn) {
            $("#profile_modal").show();
        }
    }).mouseleave(function() {

        $("#profile_modal").hide();

    });

    $("#view_profile").click(function() {
        gotoProfile();
    });

    $("#logout").click(function() {
        postStatic("controllers", "UserController", "logOut", null, function(data) {
            console.info("flush cookies: " + data);
            if (data == "done") {
                $("#header_login_button").text("login");
                $("#profile_modal").hide();
                loggedIn = false;
                user_id = -1;
                $(location).attr("href", "index.php");
            }
        });
    });


    /* Wishlist */
    $("#header_wishlist_button").click(function() {
        if (loggedIn) {
            $(location).attr("href", "wishlist.php");
        } else {
            $('#login_modal').slideDown();
        }
    });

    /* Cart */
    $("#header_cart_button").click(function() {
        if (loggedIn) {
            $(location).attr("href", "cart.php");
        } else {
            $('#login_modal').slideDown();
        }
    });

});
