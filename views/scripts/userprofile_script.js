/**
 * Created by PranayKarani on 31/07/2016.
 */
function updateUserDetails() {

    var sql = "SET ";

    $(".details").each(function() {

        var key = $(this).attr('id');
        var value = $(this).val();

        sql += " " + key + " = '" + value + "', ";

    });

    sql += " waste = '1'";

    postStatic("controllers", "UserController", "updateDetails", sql, null);

}