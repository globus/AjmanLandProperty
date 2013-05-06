<?php
$this->breadcrumbs=array(
	'Document Types'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List DocumentTypes', 'url'=>array('index')),
	array('label'=>'Create DocumentTypes', 'url'=>array('create')),
	array('label'=>'Update DocumentTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DocumentTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentTypes', 'url'=>array('admin')),
);
?>

<h1>View DocumentTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'createdAt',
		'updatedAt',
	),
)); 
?>
<h2>Custom Variables</h2><?php
foreach($_model_document_type_metas as $one_meta):
  $this->widget('zii.widgets.CDetailView', array(
  'data'=>$one_meta,
  'attributes'=>array(
    'meta_option',
    'meta_type'
  ),
)); 
endforeach;
?>
