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
                echo CHtml::ajaxLink('<span>' . $comment->voteUpCount . '</span>' . CHtml::tag('i', array('class' => $class . ' icon-1x'), ''), Yii::app()->createUrl('post/vote'), array(
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
                echo CHtml::ajaxLink('<span>' . $comment->voteDownCount . '</span>' . CHtml::tag('i', array('class' => $class . ' icon-1x'), ''), Yii::app()->createUrl('post/vote'), array(
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
                echo CHtml::ajaxLink(CHtml::tag('i', array('class' => 'icon-flag-alt icon-1x'), '') . '<span></span>', Yii::app()->createUrl('post/vote'), array(
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
        echo CHtml::link("#{$comment->id}", $comment->getUrl(null), array(
            'class' => 'cid',
            'title' => 'Permalink to this comment',
        ));
        ?>

        <?php echo CHtml::Link($comment->user->username, array('/user/' . $comment->user->id . '/' . $comment->user->username), array('class' => 'author')); ?>
        <span class="date"> on <?php echo date('F j, Y, g:i a', strtotime($comment->created)); ?></span>

        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->content)); ?>
        </div>

    </div><!-- comment -->