<p>Thank you for signing up.</p>
<p>A verification email has been sent to <?=$user['UserDetail']['email'];?>.  Please check your inbox and follow the link to verify your email.  You will not be able to use any advanced features untill your email address has been verified.</p>
<p><?=$this->Html->link('Resend Verification Email', array('action'=>'verify_email', $user['User']['id'])); ?></p>