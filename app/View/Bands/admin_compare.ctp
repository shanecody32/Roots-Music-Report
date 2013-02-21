<div>
<table>
	<tr>
		<th>New Band/Artist Information</th>
		<th>Existing Band/Artist</th>
	</tr>
	<tr>
		<td>
			<div>
				<h3><?=$original['Band']['name'];?></h3>
				<?=$this->Link->google($original['Band']['name']);?><br />
				Created: <?=$this->Format->date($original['Band']['created']); ?>
			</div>
			<? if(!empty($original['Album'])): ?>
			<div>
				<h5>Albums and Songs:</h5>
				<? foreach($original['Album'] as $album): ?>
				<div>
					<span><?=$album['name'];?> - <?=$album['Label']['name'];?></span>
					<? if(!empty($album['Song'])): ?>
					<ul>
						<? foreach($album['Song'] as $song): ?>
						<li style="list-style: none; margin: 0 0 0 10px;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$this->Logic->unknown($song['SubGenre'],'name');?></li>
						<? endforeach; ?>					
					</ul>
					<? endif; ?>
				</div>
				<? endforeach; ?>
			</div>
			<? endif; ?>
		</td>
		<td>
			<div>
				<h3><?=$compare['Band']['name'];?></h3>
				<?=$this->Link->google($compare['Band']['name']);?><br />
				Created: <?=$this->Format->date($compare['Band']['created']); ?>
			</div>
			<? if(!empty($compare['Album'])): ?>
			<div>
				<h5>Albums and Songs:</h5>
				<? foreach($compare['Album'] as $album): ?>
				<div>
					<span><?=$album['name'];?> - <?=$this->Logic->unknown($album['Label'],'name'); ?></span>
					<? if(!empty($album['Song'])): ?>
					<ul>
						 <? foreach($album['Song'] as $song): ?>
						 <li style="list-style: none; margin: 0 0 0 10px;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$this->Logic->unknown($song['SubGenre'],'name');?></li>
						 <? endforeach; ?>
					</ul>
					<? endif; ?>
				</div>
				<? endforeach; ?>
			</div>
			<? endif; ?>
		</td>
	 </tr>
</table>
</div>
<?=$this->Html->link("Compare to Another", array('controller' => 'Bands', 'action' => 'admin_find_comparisons', $original['Band']['id']));?><br /><br />

<?=$this->Html->link("Merge Existing Into New", array('controller' => 'Bands', 'action' => 'admin_merge', $original['Band']['id'],$compare['Band']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link("Merge New Into Existing", array('controller' => 'Bands', 'action' => 'admin_merge', $compare['Band']['id'],$original['Band']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link('Skip this Step',array('controller' => 'Bands', 'action' => 'admin_verify', $original['Band']['id']));