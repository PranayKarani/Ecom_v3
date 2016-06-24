/**
 * Created by PranayKarani on 24/06/2016.
 */
function removeThis(id,ids,category){
    $(location).attr("href", "compare.php?ids=" + ids + "&category="+category);
}
