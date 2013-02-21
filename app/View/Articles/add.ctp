<? // pr(); ?>
<script>
$(document).ready(function(){
	$('#TagTags').tagit();
});
</script>
<?=$this->Form->create('Article', array('type' => 'file'));?>
<?=$this->Form->input('title', array('label' => "Article Title", 'maxlength'=>'76'));?>
<? //=$this->Form->file('ArticleImage.image'); ?>
<?=$this->Form->input('sub_genre_id', array('label' => "Article Sub Genre", 'empty'=>'None'));?>
<?=$this->Form->input('article', array('label' => "Article", 'type'=>'textarea',  'class'=>'ckeditor'));?>
<?=$this->Form->input('category_id', array('label' => "Category", 'empty'=>'Select One', 'options'=>$categories));?>
<?=$this->Form->input('Tag.tags', array('label'=>'Tags - surround tags in "" to allow a space.'));?>
<?=$this->Form->input('user_id', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));?>
<?=$this->Form->end(__('Submit Article'));?>