<div>
<table>
	<tr>
		<th>New Album Information</th>
		<th>Existing Album</th>
	</tr>
	<tr>
		<td>
			<div>
				<h3><?=$original['Album']['name'];?> by <?=$original['Band']['name'];?></h3>
				<?=$this->Link->google($original['Band']['name']." ".$original['Album']['name']);?><br />
				Created: <?=$this->Format->date($original['Album']['created']); ?>
			</div>
			<div>
				<h5>Songs:</h5>
				<? if(!empty($original['Song'])): ?>
					<ul>
						<? foreach($original['Song'] as $song): ?>
						<li style="list-style: none;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$this->Logic->unknown($song['SubGenre'],'name');?></li>
						<? endforeach; ?>					
					</ul>
				<? endif; ?>
			</div>
		</td>
		<td>
			<div>
				<h3><?=$compare['Album']['name'];?> by <?=$compare['Band']['name'];?></h3>
				<?=$this->Link->google($compare['Band']['name']." ".$compare['Album']['name']);?><br />
				Created: <?=$this->Format->date($compare['Album']['created']); ?>
			</div>
			<div>
				<h5>Songs:</h5>
					<? if(!empty($compare['Song'])): ?>
					<ul>
						<? foreach($compare['Song'] as $song): ?>
						<li style="list-style: none; margin: 0 0 0 10px;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$this->Logic->unknown($song['SubGenre'],'name');?></li>
						<? endforeach; ?>					
					</ul>
					<? endif; ?>
			</div>
		</td>
	</tr>
</table>
</div>
<?=$this->Html->link("Compare to Another", array('controller' => 'Albums', 'action' => 'admin_find_comparisons', $original['Album']['id']));?><br /><br />

<?=$this->Html->link("Merge Existing Into New", array('controller' => 'Albums', 'action' => 'admin_merge', $original['Album']['id'],$compare['Album']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link("Merge New Into Existing", array('controller' => 'Albums', 'action' => 'admin_merge', $compare['Album']['id'],$original['Album']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link('Skip this Step',array('controller' => 'Albums', 'action' => 'admin_verify', $original['Album']['id']));