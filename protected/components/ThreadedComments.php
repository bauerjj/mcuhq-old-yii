<?php

class ThreadedComments extends CWidget {

    public $comments = array();
    private $parents = array();
    private $children = array();
    private $depths = array();

    /**
     * @param array $comments
     */
    public function init() {
        // Add voting JS
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl . '/js/voting-custom.js');


        // sort comments
        foreach ($this->comments as $comment) {
            if ($comment['parentId'] === NULL) {
                $this->parents[$comment['id']][] = $comment;
            } else {
                $this->children[$comment['parentId']][] = $comment;
            }
        }
    }

    public function run() {
        // this method is called by CController::endWidget()
        $this->print_comments();
    }

    /**
     * @param array $comment
     * @param int $depth
     */
    private function format_comment($comment, $depth) {
        //  echo '<li class="depth-' . $depth . '">' . $comment['content'] . '</li>';
        $this->render('comment', array(
            'comment' => $comment
        ));
    }

    /**
     * @param array $comment
     * @param int $depth
     */
    private function print_parent($comment, $depth = 0) {
        foreach ($comment as $key => $c) {
            if (isset($this->children[$c['id']])) {
                $this->format_comment($c, $depth);
                echo '<ul class="children">';
            } else {
                $this->format_comment($c, $depth);
            }

            if (isset($this->children[$c['id']])) {

                $this->depths[] = $depth + 1;
                $this->print_parent($this->children[$c['id']], $depth + 1);
            }
            if (!empty($this->depths)) {
                foreach ($this->depths as $prevDepths) {
                    if (($prevDepths == ($depth - 1))) {
                        if (!isset($comment[$key + 1])) {
                            echo '</ul>';
                            unset($this->depths[$prevDepths]);
                        } else if ($c['parentId'] != $comment[$key + 1]['parentId']) {
                            echo '</ul>';
                            unset($this->depths[$prevDepths]);
                        }
                    }
                }
            }
        }
    }

    public function print_comments() {
        // print_r($this->parents);
        // print_r($this->children); die;
        echo '<div class="comment-list">';
        foreach ($this->parents as $c) {
            // echo '< ul>';
            $this->print_parent($c);
            echo '</ul>';
        }
        echo '</div>';
    }

}

