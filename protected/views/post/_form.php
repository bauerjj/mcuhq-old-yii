<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'post-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php
// Include files for the markdown editor and preview
/*
 * $baseUrl = Yii::app()->baseUrl;
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/yourscript.js');
  $cs->registerCssFile($baseUrl.'/css/yourcss.css');
 */

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
//
//// Use the bootstrap sources in the extensions folder
//$assetsPath = Yii::getPathOfAlias('bootstrap.assets');
//$assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, false);
//
//
//$cs->registerScriptFile($baseUrl . '/js/Markdown.Converter.js');
//$cs->registerScriptFile($baseUrl . '/js/Markdown.Sanitizer.js');
//$cs->registerScriptFile($baseUrl . '/js/Markdown.Editor.js');
//$cs->registerScriptFile($baseUrl . '/js/less-1.4.1.min.js');

// Use the LESS CSS extension when including .LESS files since it must be
// included using the special keyword: 'type = "stylesheet/less"'
//$cs->registerLessFile($baseUrl . '/js/Markdown.Editor.less');
//$cs->registerLessFile($assetsUrl.'/less/bootstrap.less');

$cs->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js');
$cs->registerScriptFile($baseUrl . '/js/tag-it.min.js');

$cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css');
$cs->registerCssFile($baseUrl . '/css/jquery.tagit.css');

/**
 * @note Had to modify the 'Markdown.Editor.less' file manually in order to
 *       override the icon behavior inside of 'bootstrap.css'. I simply
 *       added another specifying class
 */
?>


<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php
$statuses = Status::model()->findAll();
$statusStrings = array();
foreach ($statuses as $status)
    $statusStrings[$status->id] = $status->status
    ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('statusId')); ?>
<br/>
<?php echo $form->dropDownList($model, 'statusId', $statusStrings); ?>

<?php
$users = User::model()->findAll();
$usernames = array();
foreach ($users as $user)
    $usernames[$user->id] = $user->username
    ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('userId')); ?>
<br/>
<?php echo $form->dropDownList($model, 'userId', $usernames); ?>

<br/>
<?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>
<br/>
<?php
$categories = Category::model()->findAll();
$categoriesFull = array();
foreach ($categories as $cat)
    $categoriesFull[$cat->id] = $cat->name
    ?>
<?php echo $form->dropDownList($model, 'categoryId', $categoriesFull); ?>


<br/>
<?php
$allTags = Tag::model()->findAll(); // Get all of the tags
$allTagss = array();
    foreach($allTags as $tag){
        $allTagss[$tag->id] = $tag->name;
    }

    $currentTags = array();
    foreach($model->tags as $tag)
        $currentTags []= $tag->name;
     ?>


<?php echo $form->textFieldRow(Tag::model(), 'tags', array('id' => 'singleFieldTags2', 'value' => implode(',',$currentTags), 'class' => 'span5', 'maxlength' => 255)); ?>

<?php echo CHtml::link('Markdown Syntax Help', '#'); ?>
<?php echo $form->markdownEditorRow($model, 'content', array('height'=>'200px', 'rows' => 6, 'cols' => 50));?>

<div class="form-actions">
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Create' : 'Save',
));
?>
</div>


<?php $this->endWidget(); ?>



<script type="text/javascript">
    $(function() {

        var sampleTags = [<?php echo '"' . implode('","', $allTagss) . '"' ?>];

        //-------------------------------
        // Preloading data in markup
        //-------------------------------
        $('#singleFieldTags2').tagit({
            availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
            // configure the name of the input field (will be submitted with form), default: item[tags]
            itemName: 'item',
            fieldName: 'tags'
        });
    });

</script>