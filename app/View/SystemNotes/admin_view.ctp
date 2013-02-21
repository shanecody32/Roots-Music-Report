<section class="system_note">
<h1><?=$system_note['SystemNote']['title']; ?> <span class="smaller"><?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $system_note['SystemNote']['id'])); ?></span></h1>
<p class="smaller"><?=$system_note['SystemNote']['group']; ?> - <?=$system_note['SystemNote']['type']; ?></p>
<p><?=$system_note['SystemNote']['description']; ?></p>
</section>
