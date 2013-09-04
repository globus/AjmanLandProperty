<?php
/* @var $this HajzMasterController */
/* @var $model HajzMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hajz-master-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'LandID'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name'=>'LandIDs',
                    'model'=>$model,
                    'attribute'=>'LandID',
                    'source'=>$LandIDs, //came from the controller.. the array we constructed of all names, arabic and english
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                        'minLength'=>'1',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;'
                    ),
                ));
		?>
			
		<?php echo $form->error($model,'LandID'); ?>
	</div>

	<!--<div class="row">
		<?php echo $form->labelEx($model,'DeedID'); ?>
		<?php echo $form->textField($model,'DeedID',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'DeedID'); ?>
	</div>-->
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'SchemeID'); ?>
		<?php echo $form->textField($model,'SchemeID'); ?>
		<?php echo $form->error($model,'SchemeID'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'Type'); ?>
		<?php echo $form->dropDownList($model,'Type',array('h'=>'حجز','r'=>'رهن')); ?>
		<?php echo $form->error($model,'Type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TypeDetail'); ?>
		<?php echo $form->textField($model,'TypeDetail',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'TypeDetail'); ?>
	</div>
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'DocsCreated'); ?>
		<?php echo $form->textField($model,'DocsCreated'); ?>
		<?php echo $form->error($model,'DocsCreated'); ?>
	</div>-->
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'UserIDcreated'); ?>
		<?php echo $form->textField($model,'UserIDcreated',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'UserIDcreated'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'DateCreated'); ?>
		<?php echo $form->textField($model,'DateCreated'); ?>
		<?php echo $form->error($model,'DateCreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AmountMortgaged'); ?>
		<?php echo $form->textField($model,'AmountMortgaged'); ?>
		<?php echo $form->error($model,'AmountMortgaged'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PeriodofTime'); ?>
		<?php echo $form->textField($model,'PeriodofTime'); ?>
		<?php echo $form->error($model,'PeriodofTime'); ?>
	</div>
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'UserIDended'); ?>
		<?php echo $form->textField($model,'UserIDended',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'UserIDended'); ?>
	</div>-->
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'DateEnded'); ?>
		<?php echo $form->textField($model,'DateEnded'); ?>
		<?php echo $form->error($model,'DateEnded'); ?>
	</div>-->
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'DocsEnded'); ?>
		<?php echo $form->textField($model,'DocsEnded'); ?>
		<?php echo $form->error($model,'DocsEnded'); ?>
	</div>-->
	
	<div class="row">
		<?php echo $form->labelEx($model,'IsActive'); ?>
		<?php echo $form->textField($model,'IsActive'); ?>
		<?php echo $form->error($model,'IsActive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'اضافة' : 'حفظ'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
