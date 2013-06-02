<h1>Edit User</h1>
<p>Please enter the users information below.</p>

<?php echo form_open(current_url());?>
	 
	 <p>
	 	Username: <br />
	 	<?php echo form_input($username);?>
	 </p>
	 
	 <p>
	 	Email: <br />
	 	<?php echo form_input($email);?>
	 </p>
	 
	 <p>
		    Password: (if changing password)<br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: (if changing password)<br />
            <?php echo form_input($password_confirm);?>
      </p>


      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', 'Save User');?></p>

<?php echo form_close();?>