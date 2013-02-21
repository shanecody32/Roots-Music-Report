<? // pr(); ?>
<script>
$(document).ready(function(){
	$('#TagTags').tagit();
});
</script>
<?=$this->Form->create('Article', array('type' => 'file'));?>
<?=$this->Form->input('title', array('label' => "Article Title", 'maxlength'=>'76'));?>
<? //=$this->Form->file('ArticleImage.image'); ?>
<?=$this->Form->input('Article.sub_genre_id', array('label' => "Article Sub Genre", 'empty'=>'None'));?>
<?=$this->Form->input('article', array('label' => "Article", 'type'=>'textarea',  'class'=>'ckeditor'));?>
<?=$this->Form->input('Article.category_id', array('label' => "Category", 'empty'=>'Select One', 'options'=>$categories));?>
<?=$this->Form->input('Tag.tags', array('label'=>'Tags - surround tags in "" to allow a space.', 'value'=>$tags));?>
<?=$this->Form->input('edited_by', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));?>
<?=$this->Form->input('user_id', array('type'=>'hidden', 'value'=>$this->request->data['Article']['user_id']));?>
<?=$this->Form->input('id', array('type'=>'hidden', 'value'=>$this->request->data['Article']['id']));?>
<?=$this->Form->end(__('Submit Article'));?>