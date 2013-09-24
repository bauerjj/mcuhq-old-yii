<?php foreach ($comments as $comment): ?>
    <div class="comment" id="c<?php echo $comment->id; ?>">

        <ul class="inline pull-right comment-vote">
            <li class="vote-up">
                <?php
                if ($comment->hasVotedUp())
                    $class = 'icon-thumbs-up active';
                else
                    $class = 'icon-thumbs-up-alt';
                ?>
                <?php
                echo CHtml::ajaxLink('<span>' . $comment->voteUpCount . '</span>' . CHtml::tag('i', array('class' => $class . ' icon-1x'), ''), CController::createUrl('post/vote'), array(
                    'type' => 'POST',
                    'data' => array(
                        'crAction' => 'voteCommentUp',
                        'commentId' => $comment->id,
                    ),
                    'success' => "function(data){ activateThumbs($comment->id, 'up', data)}",
                        ), array('title' => 'Vote Up', 'style' => 'text-decoration: none')
                );
                ?>
            </li>
            <li class="vote-down">
                <?php
                if ($comment->hasVotedDown())
                    $class = 'icon-thumbs-down active';
                else
                    $class = 'icon-thumbs-down-alt';
                ?>
                <?php
                echo CHtml::ajaxLink('<span>' . $comment->voteDownCount . '</span>' . CHtml::tag('i', array('class' => $class . ' icon-1x'), ''), CController::createUrl('post/vote'), array(
                    'type' => 'POST',
                    'data' => array(
                        'crAction' => 'voteCommentDown',
                        'commentId' => $comment->id,
                    ),
                    'success' => "function(data){ activateThumbs($comment->id, 'down', data)}",
                        ), array('title' => 'Vote Down', 'style' => 'text-decoration: none')
                );
                ?>
            </li>
            <li class="flag">
                <?php
                echo CHtml::ajaxLink(CHtml::tag('i', array('class' => 'icon-flag-alt icon-1x'), '') . 'Report', CController::createUrl('post/vote'), array(
                    'type' => 'POST',
                    'data' => array(
                        'crAction' => 'voteComment',
                        'commentId' => $comment->id,
                    ),
                    'update' => '#test'
                        ), array('title' => 'Report This', 'style' => 'text-decoration: none')
                );
                ?>
            </li>
        </ul>

        <?php
        echo CHtml::link("#{$comment->id}", $comment->getUrl($post), array(
            'class' => 'cid',
            'title' => 'Permalink to this comment',
        ));
        ?>

        <?php echo CHtml::Link($comment->user->username, array('/user/' . $comment->user->id . '/' . $comment->user->username), array('class' => 'author')); ?>
        <span class="date"><?php echo date('F j, Y, g:i a', strtotime($comment->created)); ?></span>

        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->content)); ?>
        </div>

    </div><!-- comment -->
<?php endforeach; ?>

<script>
    function activateThumbs(commentId, thumbs, data) {
        var data = $.parseJSON(data); // Parse the JSON from controller

        if (!data.error) {
            var voteUp = $("#c" + commentId + " li.vote-up i");
            var voteUpVal = $("#c" + commentId + " li.vote-up span");
            var voteDown = $("#c" + commentId + " li.vote-down i");
            var voteDownVal = $("#c" + commentId + " li.vote-down span");

            if (thumbs === 'up') {
                var voteUp = $("#c" + commentId + " li.vote-up i");
                var voteUpVal = $("#c" + commentId + " li.vote-up span");

                // Change to the "filled" thumbs
                voteUp.removeClass('icon-thumbs-up-alt').addClass('icon-thumbs-up');
                // and color it red for down thumbs and greenish for up thumb
                voteUp.css('color', '#22CC22');
                // Increment the value
                voteUpVal.html(parseInt(voteUpVal.html()) + 1)

                // Check to see if need to restore the thumbs down
                if(voteDown.hasClass('icon-thumbs-down')){
                    voteDown.removeClass('icon-thumbs-down').addClass('icon-thumbs-down-alt');
                    voteDown.css('color', '#0088CC');
                    voteDownVal.html(parseInt(voteDownVal.html()) - 1)
                }
            }
            else {
                var voteDown = $("#c" + commentId + " li.vote-down i");
                var voteDownVal = $("#c" + commentId + " li.vote-down span");

                // Change to the "filled" thumbs
                voteDown.removeClass('icon-thumbs-down-alt').addClass('icon-thumbs-down');
                // and color it red for down thumbs and greenish for up thumb
                voteDown.css('color', '#DD1111');
                // Increment the value
                voteDownVal.html(parseInt(voteDownVal.html()) + 1)

                // Check to see if need to restore the thumbs up
                if(voteUp.hasClass('icon-thumbs-up')){
                    voteUp.removeClass('icon-thumbs-up').addClass('icon-thumbs-up-alt');
                    voteUp.css('color', '#0088CC');
                    voteUpVal.html(parseInt(voteUpVal.html()) - 1)
                }
            }
        }
    }



</script>