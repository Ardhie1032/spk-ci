<div class="heading clearfix">
	<h3 class="pull-left">Daftar Pelanggan</h3>
	<span class="pull-right label label-important">NOTIF PELANGGAN LAGI
		ONLINE</span>
</div>
<table class="table table-bordered table-striped mediaTable">
	<?php
	/*
	 * Untuk merubah warna sesuai user dalam sistem
	 * --------------------------------------------
	 * @admin 	: #000000
	 * @manajer	: #926737 
	 * 
	 */
	if($this->ion_auth->is_admin())
	{
		echo "<thead><tr style=\"background-color:#000000; color:#FFFFFF;\"><td colspan=\"8\" height=\"15\" style=\"text-align: center\">MASTER PELANGGAN</td></tr></thead>";
	}else{
		echo "<thead><tr style=\"background-color:#926737; color:#FFFFFF;\"><td colspan=\"8\" height=\"15\" style=\"text-align: center\">MASTER PELANGGAN</td></tr></thead>";
	}
	?>
	<thead>
		<tr style="color: #000;" align="center">
			<th style="text-align: center;">No</th>
			<th style="text-align: center;">Nama Perawat</th>
			<th style="text-align: center;">No. Telepon</th>
			<th style="text-align: center;">Tanggal Lahir</th>
			<th style="text-align: center;">Alamat</th>
			<th style="text-align: center;" colspan="3"><a
				href="<?php echo base_url(); ?>pelanggan/tambah"
				class="btn btn-success"><i class="splashy-document_letter_add"></i>
					Tambah Data</a></th>
		</tr>
	</thead>
	<tr>
		<?php $i=0;?>
		<?php foreach($hasil as $row):?>
	<tbody>
		<tr>
			<td style="width: 40px"><?php echo ++$i;?></td>
			<td><?php echo $row['dob']?></td>
			<td><?php echo $row['foto']?></td>
			<td><?php echo $row['jenkel']?></td>
			<td><?php echo $row['dob']?></td>
			<td width="80"><a
				href="<?php echo base_url(); ?>pelanggan/detail/<?php echo $row['id']; ?>"
				class="btn"><i class="icon-eye-open"></i> Detail</a></td>
			<td width="70"><a
				href="<?php echo base_url(); ?>pelanggan/edit/<?php echo $row['id']; ?>"
				class="btn"><i class="icon-pencil"></i> Edit</a></td>
			<td width="80"><a
				href="<?php echo base_url(); ?>pelanggan/hapus/<?php echo $row['id']; ?>"
				onclick="return confirm('Anda yakin?');" class="btn"><i
					class="icon-trash"></i> Hapus</a></td>
		</tr>
	</tbody>
	<?php endforeach;?>
</table>