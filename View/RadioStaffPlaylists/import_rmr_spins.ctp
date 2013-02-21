File format:<br />
0 = orig_username<br />
1 = spins<br />
2 = artist<br />
3 = song<br />
4 = album<br />
5 = label<br />
6 = genre<br />


<?=$this->Form->create('RadioStaffPlaylist', array('enctype' => 'multipart/form-data','admin'=>'1')); ?>
<?=$this->Form->input('submittedfile',array('label'=>'File To Convert','type' => 'file')); ?>

<?=$this->Form->end(__('Upload File'));?>