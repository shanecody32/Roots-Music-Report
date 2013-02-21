<?

//pr($this->Paginator->params);
if($this->Paginator->params['paging']['Band']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>

<?=$this->Form->create('Band', array('url' => array_merge(array('controller'=>'bands', 'action' => 'search'), $this->params['pass']))); ?>

<?=$this->Form->input('name', array('label'=>'','div'=>false, 'placeholder'=>'Band/Artist Name'));?>
<?// see rs band search for usage =$this->Form->input('type', array('label'=>'&nbsp;', 'type'=>'select', 'div'=>false, 'options'=>$options)); ?>

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
	<!--<div class="toggle">
		<a id="genre_toggle" href="#">Genres</a>
		<div id="genres">
			<?=$this->Form->input('genres', array('type'=>'select', 'multiple' => 'checkbox', 'options'=>$genres, 'label'=>'')); ?>
		</div>
	</div> -->
	<?=$this->Form->input('country', array('type'=>'select', 'div'=>'false', 'options'=>$countries,  'empty'=>'All Countries', 'escape'=>false)); ?>
	<?=$this->Form->input('state', array('type'=>'select', 'div'=>'false', 'options'=>$states,  'empty'=>'All States')); ?>
	<?=$this->Form->input('city', array('type'=>'select', 'div'=>'false', 'options'=>$cities,  'empty'=>'All Cities')); ?>
	
	<?=$this->Form->radio('status', array('all'=>'All','verified'=>'Only Verified', 'unverified'=>'Only Unverified',), array('div' => false, 'default'=>'all', 'legend' => false)); ?>
	<?=$this->Form->input('not_approved', array('type'=>'checkbox')); ?>
	<?=$this->Form->input('approved', array('type'=>'checkbox')); ?>
</div>
<?=$this->Form->end(); ?>

<div id="results">

	<? 	if(isset($this->Paginator->params['named']['search'])){ ?>
		<? 	if($this->Paginator->params['paging']['Band']['count'] == 0){ ?>
				<h3>No results found for '<?=$this->Paginator->params['named']['search'];?>' in Radio Staff Members.</h3><br />
		<? 	} else { ?>
				<h3>Results for '<?=$this->Paginator->params['named']['search'];?>' in Radio Staff Members.</h3><br />
		<?	}
		} ?>

	<? if(!$one_page) echo $this->Display->pages(false);?>
	<table>
	<?=$this->Html->tableHeaders(array($this->Paginator->sort('name', 'Name '), 'Actions'));?>
	<? $i = 0; foreach($bands as $band): ?>
	<?
		$class = array();
		$altrow = false;

		if($i % 2 == 0) {
			$altrow = true;
		}

		if(!$band['Band']['verified']){ //!$album['Album']['violations'] && 
			if(!$altrow){
				$class = array('class' => 'yellow');
			} else {
				$class = array('class' => 'altyellow');
			}
		}
		
		if($band['Band']['verified'] && !$band['Band']['approved']){
			if(!$altrow)
				$class = array('class' => 'red');
			else
				$class = array('class' => 'altred');
		}
		
		/*if($band['Band']['verified'] && $band['Band']['approved']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = array('class' => 'green');
			else
				$class = array('class' => 'altgreen');
		} */
		$i++;

		$actions = $this->Display->actions($band['Band']['id'], array('view', 'find_comparisons' => 'Verify', 'edit', 'delete'), true);
	?>
		<?=$this->Html->tableCells(array($band['Band']['name'], $actions), $class, $class); ?>
	<? endforeach; ?>
	</table>
	<? if(!$one_page) echo $this->Display->pages();?>
</div>