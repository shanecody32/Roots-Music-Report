<?

//pr($this->Paginator->params);
if($this->Paginator->params['paging']['RadioStaffMember']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>

<?=$this->Form->create('RadioStaffMember', array('url' => array_merge(array('controller'=>'radio_staff_members', 'action' => 'search'), $this->params['pass']))); ?>

<?=$this->Form->input('first_name', array('label'=>'','div'=>false, 'placeholder'=>'First Name'));?>
<?=$this->Form->input('last_name', array('label'=>'','div'=>false, 'placeholder'=>'Last Name'));?>
<? // see rs band search for usage =$this->Form->input('type', array('label'=>'&nbsp;', 'type'=>'select', 'div'=>false, 'options'=>$options)); ?>

<?=$this->Form->submit(__('Search', true),array('div'=>false)); ?>
<?//=$this->Form->input('field', array('type'=>'hidden','value'=>'name'));?>
<a id="advanced" href="#">Advanced Options</a>
<div id="advanced_options">
	<?=$this->Form->input('starts_with', array('type'=>'checkbox', 'div'=>false)); ?>
	<?=$this->Form->input('exact', array('type'=>'checkbox', 'div'=>false)); ?>
	<div class="toggle">
		<a id="sub_genre_toggle" href="#">Sub Genres</a>
		<div id="sub_genres">
			<?=$this->Form->input('sub_genres', array('type'=>'select', 'multiple' => 'checkbox',  'options'=>$sub_genres, 'label'=>'')); //'empty'=>'All Sub Genres', ?>
		</div>
	</div>
	<div class="toggle">
		<a id="genre_toggle" href="#">Genres</a>
		<div id="genres">
			<?=$this->Form->input('genres', array('type'=>'select', 'multiple' => 'checkbox', 'options'=>$genres, 'label'=>'')); ?>
		</div>
	</div>
	<?=$this->Form->input('country', array('type'=>'select', 'div'=>'false', 'options'=>$countries,  'empty'=>'All Countries', 'escape'=>false)); ?>
	<?=$this->Form->input('state', array('type'=>'select', 'div'=>'false', 'options'=>$states,  'empty'=>'All States')); ?>
	<?=$this->Form->input('city', array('type'=>'select', 'div'=>'false', 'options'=>$cities,  'empty'=>'All Cities')); ?>
</div>
<?=$this->Form->end(); ?>

<div id="results">

	<? 	if(isset($this->Paginator->params['named']['search'])){ ?>
		<? 	if($this->Paginator->params['paging']['RadioStaffMember']['count'] == 0){ ?>
				<h3>No results found for '<?=$this->Paginator->params['named']['search'];?>' in Radio Staff Members.</h3><br />
		<? 	} else { ?>
				<h3>Results for '<?=$this->Paginator->params['named']['search'];?>' in Radio Staff Members.</h3><br />
		<?	}
		} ?>

	<? if(!$one_page) echo $this->Display->pages(false);?>
	<table>
	<?=$this->Html->tableHeaders(array($this->Paginator->sort('last_name', 'Name '),$this->Paginator->sort('RadioStation.name', 'Station'), ''));?>
	<? $i = 0; foreach($staff_members as $staff): ?>
	<?
		$actions = $this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlist_archives','action' => 'view', $staff['RadioStaffMember']['seo_name'])).' | ';
		$actions .= $this->Display->actions($staff['RadioStaffMember']['seo_name'], array('view' => 'View Profile'), false);
	?>
		<?=$this->Html->tableCells(array($this->Display->fullName($staff['RadioStaffMember'], true), $staff['RadioStation']['name'],$actions)); ?>
	<? endforeach; ?>
	</table>
	<? if(!$one_page) echo $this->Display->pages();?>
</div>