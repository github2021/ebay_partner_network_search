<?php require('include.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>

<body>
    <table>
        <tr>
            <td>
                <form method="get">
                    <select name="cat" class="form-control">
                        <?php echo options($categories,$cat); ?>
                    </select>
            </td>
            <td>
                <div class="input-group">
                    <input name="search" class="form-control" placeholder="Search for..." <?php if(!empty($search)){ echo ' value="'.$search. '" '; }?>> <span class="input-group-btn"> 
<button class="btn btn-default" type="submit">Go!</button> </span> </div>
                <input type="hidden" name="page" value="1">
            </td>
            <td>
                <?php if (!empty($simplexml->paginationOutput->pageNumber)) { 
                echo'<span class="well well-sm">Page ' . $simplexml->paginationOutput->pageNumber. ' \ '. $simplexml->paginationOutput->totalPages . '</span>'; }?>
            </td>
        </tr>
    </table>
    </form>
    <?php if (!empty($search)) {
                        echo results($search, $simplexml);
                        echo nav($search, $page, $cat, $simplexml);
                    } ?>
</body>

</html>
