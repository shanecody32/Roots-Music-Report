<?php
# /app/views/elements/email/text/user_confirm.ctp
?>
Hey there <?=$user['UserDetail']['first_name'];?>, we will have you up and running in no time, but first we just need you to confirm your user account by clicking the link below:
 
<?=$activate_url;?>