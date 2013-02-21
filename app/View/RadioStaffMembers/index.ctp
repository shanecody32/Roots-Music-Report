<? if(!$staff['RadioStaffMember']['approved']){ ?>
	<h1>Welcome Back!</h1>
	<p>To start reporting to the Roots Music Report you must follow these aditional steps.</p>
	<ol>
		<? if(!$staff['RadioStaffMember']['applied']){ ?>
			<li><?=$this->Html->link('Apply to report for your Station or Show', array('controller' => 'RadioStations', 'action'=>'application'));?></li>
		<? } elseif(!$staff['RadioStaffMember']['verified']) { ?>
			<li>Your application has been submitted, and is awaiting verification.</li>
		<? } elseif(!$staff['RadioStaffMember']['approved']){ ?>
			<li>Your application has been verified, but a hold has been placed on your account. Below is a list of violations that prevent you from reporting at this time.
				<ul>
				<? foreach($staff['Violation'] as $violation): ?>
					<li><?=strtoupper($violation['type']);?>: <?=$violation['title'];?></li>
				<? endforeach; ?>
				</ul>
			</li>
		<? } ?>
		<li>While your waiting for approval you should fill out your Radio Staff Member Profile</li>
		<li></li>
	</ol>



<? } else { ?>

	<h1>Welcome Back <?=$staff['RadioStaffMember']['first_name']; ?></h1>
	<section id='account_notes'>
	<? if(!empty($staff['Violation'])): ?>
		<ul>
		<? foreach($staff['Violation'] as $violation): ?>
			<li><?=strtoupper($violation['type']);?>: <?=$violation['title'];?></li>
		<? endforeach; ?>
		</ul>
	<? endif; ?>
	</section>
	<article id='rmr_updates'>
		Display latest update info, account terms, iportant notes for djs (system wide)
	</article>
	<article id='hot_artist'>
		Shows Hot artists being reported on other current playlists (based on Genre)
	</article>
	<article>
		current playlist?
	</article>
	<article>
		news feed
	</article>
<? } ?>
	