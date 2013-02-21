<? // DW ?>

<p>Thank you for applying to become a radio airplay reporter for Roots Music Report.</p>
<p>We will review your application and once we have verified the information you provided we will send you an email notifing you of our desicion.</p>
<p>A verification email has been sent to <?=$user['UserDetail']['email'];?>.  Please check your inbox and follow the link to verify your email.  You will not be able to report your playlist or login until your email address has been verified.</p>
<p><?=$this->Html->link('Resend Verification Email', array('controller' => 'users', 'action'=>'verify_email', $user['User']['id'])); ?></p>