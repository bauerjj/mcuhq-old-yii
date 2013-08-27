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

// Use the bootstrap sources in the extensions folder
$assetsPath = Yii::getPathOfAlias('bootstrap.assets');
$assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, false);


$cs->registerScriptFile($baseUrl . '/js/Markdown.Converter.js');
$cs->registerScriptFile($baseUrl . '/js/Markdown.Sanitizer.js');
$cs->registerScriptFile($baseUrl . '/js/Markdown.Editor.js');
$cs->registerScriptFile($baseUrl . '/js/less-1.4.1.min.js');

// Use the LESS CSS extension when including .LESS files since it must be
// included using the special keyword: 'type = "stylesheet/less"'
$cs->registerLessFile($baseUrl . '/js/Markdown.Editor.less');
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
<?php echo CHtml::encode($model->getAttributeLabel('tags')); ?>

<ul id="myTags">
    <?php //Tags
    $allTags = Tag::model()->findAll(); // Get all of the tags
    foreach($allTags as $tag){
        $allTagss[$tag->id] = $tag->name;
    }
    foreach ($model->tags as $tag):
    ?>
    <li><?php echo $tag->name ?></li>

    <?php endforeach ?>
</ul>

<div class="wmd-panel">
    <div id="wmd-button-bar"></div>
<?php echo $form->textAreaRow($model, 'content', array('rows' => 6, 'cols' => 50, 'class' => 'span8', 'wmd-input', 'id' => 'wmd-input')); ?>
    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
</div>
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
        $('#myTags').tagit({
            availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
            // configure the name of the input field (will be submitted with form), default: item[tags]
            itemName: 'item',
            fieldName: 'tags'
        });
    });

    (function() {
        var converter1 = Markdown.getSanitizingConverter();
        var editor1 = new Markdown.Editor(converter1);
        editor1.run();

        var converter2 = new Markdown.Converter();

        converter2.hooks.chain("preConversion", function(text) {
            return text.replace(/\b(a\w*)/gi, "*$1*");
        });

        converter2.hooks.chain("plainLinkText", function(url) {
            return "This is a link to " + url.replace(/^https?:\/\//, "");
        });

        var help = function() {
            alert("Do you need help?");
        }

        var editor2 = new Markdown.Editor(converter2, "-second", {handler: help});

        editor2.run();
    })();
</script>