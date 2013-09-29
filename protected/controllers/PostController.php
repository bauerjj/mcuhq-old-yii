<?php

class PostController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'home', 'vote'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular article.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $post = $this->loadModel($id);
        $comment = $this->newComment($post);

        $post->saveCounters(array('views' => 1)); // Increment counters


        $this->render('home/single', array(
            'model' => $this->loadModel($id),
            'newComment' => $comment,
            'comments' => $this->loadModel($id)->comments,
        ));


//        $this->render('view', array(
//            'model' => $this->loadModel($id),
//        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Post;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Post'])) {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $inputTags = explode(',', $_POST['Tag']['tags']); // Get the POSTED tags
            $allTags = Tag::model()->getAllTags(); // Retrieve all of the existing tags
            $newTags = array();

//
//            // Delete the link table
//            $tagPostLink = TagPost::model()->deleteAll(array(
//                        'condition' => "postId = $id"
//                    ));
//
//            $model->tags = $inputTags;
//            $model->withRelated->save(true, array('tags'));
            // If updating an existing post with a NEW tag, increment the count
            foreach ($inputTags as $tag) {
                if (in_array($tag, $allTags)) { // if an existing tag
                    if (in_array($tag, $model->tags)) { // if existing tag for this certain post document
                        // Do nothing
                    } else {
                        // Updating an existing Post by adding a tag that has already been in the system
                        // Update the count
//                        $row = Tag::model()->find('name = "' . $tag . '"');
//                        $row->count += 1;
//                        $row->save();
                    }
                } else {
                    // A new tag
                    $newTag = new Tag;
                    $newTag->name = $tag;
                    $newTag->count = 1;
                    $newTags[] = $newTag;
                }
            }

            // Check for any deletions
            //@todo look into ON_DELETE cascade for the link table and NOT the individulal tags
            foreach ($model->tags as $modelTag) {
                if (!in_array($modelTag->name, $inputTags)) {
                    // Remove from the link table
                    $tagId = Tag::model()->find(array(
                        'select' => 'id',
                        'condition' => 'name="' . $tag . '"'
                    ));
                    $tagPostLink = TagPost::model()->deleteAll(array(
                        'condition' => "postId = '$id' AND tagId = '$modelTag->id'"
                    ));
                }
            }

            // If updating an existing post and DELETING an old tag, decrement the count and delete from link table
            //  print_r($model->tags); die;
            //  $model->tags = $newTags;
            //  print_r($newTags); die;
//        $tag1 = new Tag;
//        $tag1->name = "cpu";
//        $tag2 = new Tag;
//        $tag2->name = "core";
//        $post->tags = array($tag1, $tag2);
            // $post->withRelated->save(true, array('tags'));

            $model->tags = $newTags;
            $model->attributes = $_POST['Post'];
            if ($model->withRelated->save(true, array('tags')))
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionHome() {
        $critera = new CDbCriteria(array(
            'order' => 'updated DESC',
            'with' => 'tags'
        ));

        $dataProvider = new CActiveDataProvider('Post', array(
            'pagination' => array(
                'pageSize' => Yii::app()->params['postsPerPage'],
            ),
            'criteria' => $critera
        ));

        $this->render('home/index', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        // $post = Post::model()->findByPk(1);
//        // retrieve the post's author: a relational query will be performed here
//        $author = $post->user;
//        echo $author->username;
//                $post = new Post;
//
//                $post->title = "test title";
//                $post->content = "my content";
//                $tag1 = new Tag;
//                $tag1->name = "cpu";
//                $tag2 = new Tag;
//                $tag2->name = "core";
//                $post->tags=array($tag1,$tag2);
//                $post->withRelated->save(true,array('tags'));




        $dataProvider = new CActiveDataProvider('Post');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionVote() {
        // Only allow users to vote - Non-users will be redirected to a login page
        if(Yii::app()->user->isGuest){
           echo json_encode(array('error' => true, 'redirect' => CController::createUrl('site/login') ));
            return;
        }


        if (isset($_POST['crAction'])) {
            if ($_POST['crAction'] == 'voteCommentUp' || $_POST['crAction'] == 'voteCommentDown') {
                $commentId = $_POST['commentId'];
                $userId = Yii::app()->user->id;
                $action = $_POST['crAction'];

                if($action == 'voteCommentUp')
                    $voteUp = true;
                else
                    $voteUp = false;

              //  $comment = Comment::model()->findByPk($commentId)

              $success =   Comment::model()->addVote($commentId, $voteUp);
              if(!$success)
                  echo json_encode(array('error' => true));
              else
                  echo json_encode(array('error' => false));

            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Post('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($post) {

        $comment = new Comment;

        // AJAX validation?
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment); // Validate the form (Don't need to assign attributes)
            Yii::app()->end();
        }

        // Typical post validation
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($post->addComment($comment)) { // Add the comment into the database
                if (true) // Check if pending Comment::STATUS_PENDING
                    Yii::app()->user->setFlash('commentSubmitted', 'Thank you for your comment. Your comment will be posted once it is approved.');

                $this->refresh();
            }
        }

        return $comment;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        // $model = Post::model()->findByPk($id);
        //Custom
        if (Yii::app()->user->isGuest) // Only show published or archived posts
            $condition = 'statusId=' . Post::STATUS_PUBLISHED
                    . ' OR statusId=' . Post::STATUS_ARCHIVED;
        else
            $condition = '';
        $model = Post::model()->with(array(
                    'status' => array(
                        'select' => false,
                        'joinType' => 'INNER JOIN',
                    )
                ))->findByPk($id, $condition);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');


        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//    public function filters() {
//        return array(
//            array('ext.bootstrap.components.Bootstrap.filters.BootstrapFilter')
//        );
//    }
}
