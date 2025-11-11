<?php 
include "../../../head.php";
?>

<script type="text/javascript">
var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
    };

$("#sort tbody").sortable({
    helper: fixHelperModified,
    stop: updateIndex
}).disableSelection();
</script>

<h1>Sorting A Table With jQuery UI</h1>
<a href='http://www.foliotek.com/devblog/make-table-rows-sortable-using-jquery-ui-sortable/'>Make table rows sortable with jQuery UI</a>

<table id="sort" class="grid" title="Kurt Vonnegut novels">
    <thead>
        <tr><th class="index">No.</th><th>Year</th><th>Title</th></tr>
    </thead>
    <tbody>
        <tr><td class="index">1</td><td>1969</td><td><input name="foo"></td></tr>
        <tr><td class="index">2</td><td>1952</td><td><input name="bar"></td></tr>
        <tr><td class="index">3</td><td>1963</td><td><input name="baz"></td></tr>
        <tr><td class="index">4</td><td>1973</td><td><input name="bat"></td></tr>
        <tr><td class="index">5</td><td>1965</td><td><input name="qux"></td></tr>
    </tbody>
</table>


