
<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">Tambah Pengguna</h3>
		<?php echo $message;?>
		<?php echo form_open('user/new_user','class="well form-inline"');?>
		<fieldset>
			<p class="f_legend">Login Information</p>
			<div class="formSep">
				<div class="row-fluid">
					<div class="span3">
						<label>Username <span class="f_req">*</span> </label><br />
						<?= form_input($username);?>
					</div>
					<div class="span5">
						<label>Email <span class="f_req">*</span> </label><br />
						<?= form_input($email);?>
					</div>
				</div>
			</div>
			<div class="formSep">
				<div class="row-fluid">
					<div class="span3">
						<label>Password <span class="f_req">*</span> </label> <br />
						<?= form_input($password);?>
					</div>
					<div class="span5">
						<label>Konfirmasi Password <span class="f_req">*</span> </label><br />
						<?= form_input($password_confirm);?>
					</div>
				</div>
			</div>
			<div class="formSep">
				<label>Level</label><br />
			<?php 
				$group_option = array();
				foreach ($groups as $group){
					$group_option[$group->id] = $group->name;
				}
				echo "<td>" . form_dropdown('group', $group_option, true) . "</td>"; 
				?>
			</div>
			<div class="formSep">
				<?php
				$tombol = array(
						'type' 	=> 'submit',
						'value'	=> 'Tambah Pengguna',
						'name'	=> 'submit',
						'id'	=> 'sticky_a',
						'class'	=> 'btn',
				);
				?>
				<?php echo form_submit($tombol);?>
				<?php echo "|";?>
				<?php echo anchor('user/index','Cancel')?>
			</div>
		</fieldset>
		<?php echo form_close();?>
	</div>
</div>

