<section class="violation">
<h1><?=$violation['Violation']['title']; ?> <span class="smaller"><?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $violation['Violation']['id'])); ?></span></h1>
<p class="smaller"><?=$violation['Violation']['group']; ?> - <?=$violation['Violation']['type']; ?></p>
<p><?=$violation['Violation']['description']; ?></p>
</section>
