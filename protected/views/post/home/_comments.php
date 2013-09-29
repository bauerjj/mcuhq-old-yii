<?php
//$comments = array(  array('id'=>1, 'parent_id'=>NULL,   'text'=>'Parent'),
//                    array('id'=>2, 'parent_id'=>1,      'text'=>'a'),
//                    array('id'=>3, 'parent_id'=>2,      'text'=>'b'),
//                    array('id'=>11, 'parent_id'=>3,      'text'=>'c'),
//                    array('id'=>4, 'parent_id'=>NULL,   'text'=>'Second Parent'),
//                    array('id'=>5, 'parent_id'=>4,   'text'=>'d'),
//                    array('id'=>6, 'parent_id'=>2,   'text'=>'e'),
//                    array('id'=>7, 'parent_id'=>5,   'text'=>'f'),
//                    array('id'=>8, 'parent_id'=>7,   'text'=>'g'),
//                    array('id'=>9, 'parent_id'=>7,   'text'=>'h'),
//                    array('id'=>10, 'parent_id'=>9,   'text'=>'i'),
//                    array('id'=>12, 'parent_id'=>4,   'text'=>'j'),
//                );
//
//
//$tc = new ThreadedComments($comments);
//$tc->print_comments();
//$tc = new ThreadedComments();
//$tc->print_comments($comments['parents'], $comments['children']);
$parents = $comments['parents'];
$children = $comments['children'];

//echo '<div class="comment-list">';
//foreach ($parents as $c) {
//    // echo '< ul>';
//    print_parent($c);
//    echo '</ul><br/>';
//}
//echo '</div>';
//
//
//
//$depths = array();

function print_parent($comment, $depth = 0) {
    global $parents, $children, $depths;


    foreach ($comment as $key => $c) {
        if (isset($children[$c['id']])) {
            format_comment($c, $depth);
            echo '<ul class="children">';
        } else {
            format_comment($c, $depth);
        }
        if (isset($children[$c['id']])) {

            $depths[] = $depth + 1;
            print_parent($children[$c['id']], $depth + 1);
        }
        if (!empty($depths)) {
            foreach ($depths as $prevDepths) {
                if (($prevDepths == ($depth - 1))) {
                    if (!isset($comment[$key + 1])) {
                        echo '</ul>';
                        unset($depths[$prevDepths]);
                    } else if ($c['parentId'] != $comment[$key + 1]['parentId']) {
                        echo '</ul>';
                        unset($depths[$prevDepths]);
                    }
                }
            }
        }
    }
}

function format_comment($comment, $depth) {
    echo $comment['content'];
    echo $depth;
}
?>


<script>
    function activateThumbs(commentId, thumbs, data) {
        var data = $.parseJSON(data); // Parse the JSON from controller

        //icon-thumbs-xx == not voted
        //icon-thumbs-xx-alt == voted

        if (!data.error) {
            var voteUp = $("#c" + commentId + " li.vote-up i");
            var voteUpVal = $("#c" + commentId + " li.vote-up span");
            var voteDown = $("#c" + commentId + " li.vote-down i");
            var voteDownVal = $("#c" + commentId + " li.vote-down span");

            if (thumbs === 'up' && voteUp.hasClass('active')) {
                resetThumbsUp(voteUp, voteUpVal);
            }
            else if (thumbs === 'up' && !voteUp.hasClass('active')) {
                activateThumbsUp(voteUp, voteUpVal);
                if (voteDown.hasClass('icon-thumbs-down'))
                    resetThumbsDown(voteDown, voteDownVal);
            }

            if (thumbs === 'down' && voteDown.hasClass('active')) {
                resetThumbsDown(voteDown, voteDownVal);
            }
            else if (thumbs === 'down' && !voteDown.hasClass('active')) {
                activateThumbsDown(voteDown, voteDownVal);
                if (voteUp.hasClass('icon-thumbs-up'))
                    resetThumbsUp(voteUp, voteUpVal);
            }
        }
        else {
            window.location.href = data.redirect;
        }
    }

    function activateThumbsUp(voteUp, voteUpVal) {
        // Change to the "filled" thumbs
        voteUp.removeClass('icon-thumbs-up-alt').addClass('icon-thumbs-up');
        // and color it red for down thumbs and greenish for up thumb
        voteUp.addClass('active');
        // Increment the value
        voteUpVal.html(parseInt(voteUpVal.html()) + 1)
    }
    function resetThumbsUp(voteUp, voteUpVal) {
        voteUp.removeClass('icon-thumbs-up').addClass('icon-thumbs-up-alt');
        voteUp.removeClass('active');
        voteUpVal.html(parseInt(voteUpVal.html()) - 1)
    }


    function activateThumbsDown(voteDown, voteDownVal) {
        // Change to the "filled" thumbs
        voteDown.removeClass('icon-thumbs-down-alt').addClass('icon-thumbs-down');
        // and color it red for down thumbs and greenish for up thumb
        voteDown.addClass('active');
        // Increment the value
        voteDownVal.html(parseInt(voteDownVal.html()) + 1)
    }

    function resetThumbsDown(voteDown, voteDownVal) {
        voteDown.removeClass('icon-thumbs-down').addClass('icon-thumbs-down-alt');
        voteDown.removeClass('active');
        voteDownVal.html(parseInt(voteDownVal.html()) - 1)
    }





</script>