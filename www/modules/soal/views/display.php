<div class="heading clearfix">
	<h3 class="pull-left">Daftar Pertanyaan</h3>
	<span class="pull-right label label-important">NOTIF PELANGGAN LAGI
		ONLINE</span>
</div>
<div>
<?php if ($results == FALSE) { ?>
	<div>
		<p>Soal belum dimasukkan</p>
	</div>
<?php } else { ?>
<?php foreach ($results as $row) { ?>
	<h3><?php echo anchor("soal/view/{$row['id']}", $row['pertanyaan']);?></h3>
	
	<div class="poll">
				<h3><?php echo anchor("poll/view/{$row['poll_id']}", $row['title']); ?></h3>
				<dl class="options">
					<?php foreach ($row['options'] as $option) { ?>
						<dt><?php echo $option['title']; ?>  <span class="vote_count">(<?php echo $option['votes']; ?>)</span></dt>
						<dd><span class="poll_bg"><span class="poll_bar" style="width: <?php echo $option['percentage']; ?>%"></span></span></dd>
						<dd><?php echo anchor("poll/vote/{$row['poll_id']}/{$option['option_id']}", 'Vote', array('class' => 'btn_add')); ?></dd>
					<?php } ?>
				</dl>
				<p><?php echo anchor("poll/delete/{$row['poll_id']}", 'Delete this poll', array('class' => 'btn_delete')); ?>
				<?php if ($row['closed']) { ?>
				<?php echo anchor("poll/open/{$row['poll_id']}", 'Open poll', array('class' => 'btn_normal')); ?>
				<?php } else { ?>
				<?php echo anchor("poll/close/{$row['poll_id']}", 'Close poll', array('class' => 'btn_normal')); ?>
				<?php } ?>
				</p>
			</div>
			
		<?php } ?>
	<?php } ?>
</div>
<?php echo $paging; ?>
	