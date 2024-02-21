<?php
$this->load->view('backoff/layout/_999/head');
$this->load->view('backoff/layout/_999/qmenu');
?>


  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
							<h1><?php echo lang('index_heading');?></h1>
							<p><?php echo lang('index_subheading');?></p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
							<div class="container cropper">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
								</div>
								<div class="col-md-9 col-sm-12 col-xs-12">
									<div id="infoMessage"><?php echo $message;?></div>

									<table id="tbuser" class="display table-bordered table-striped table-hover dt-responsive table-full-width nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php echo lang('index_fname_th');?></th>
												<th><?php echo lang('index_lname_th');?></th>
												<th><?php echo lang('index_email_th');?></th>
												<th><?php echo lang('index_groups_th');?></th>
												<th><?php echo lang('index_status_th');?></th>
												<th><?php echo lang('index_action_th');?></th>
												<th>EP-Key</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($users as $user):?>
											<tr>
												<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
												<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
												<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
												<td>
													<?php foreach ($user->groups as $group):?>
													<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'),array('class'=>htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')!='admin'?'btn btn-default':'btn btn-warning')) ;?>
													<?php endforeach?>
												</td>
												<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'),array('class'=>'btn btn-primary')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'),array('class'=>'btn btn-primary'));?></td>
												<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit',array('class'=>'btn btn-primary')) ;?></td>
												<td> <button type="button" name="button" onclick="getkey('<?php echo $user->username;?>')" class="btn btn-danger btn-round"><i class="fa fa-key white"></i></button> </td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
									<hr/>
									<p class="pull-right"><?php echo anchor('auth/create_user', lang('index_create_user_link'),array('class'=>'btn btn-success'))?><?php echo anchor('auth/create_group', lang('index_create_group_link'),array('class'=>'btn btn-info'))?></p>

								</div>
							</div>
      </div>

	      	</div>
	    </div>
	</div>
	<?php
	$this->load->view('backoff/layout/_999/'.$mod.'foot');
	?>

<script>
$(document).ready(function() {
$('#tbuser').DataTable();
});

function getkey(iduser){
	var ambilkey = '';
	Swal.fire({
		title: "Unduh Berkas By-Pass?",
		icon: "info",
		text: "Berkas/File harus dijaga kerahasiaannya!",
		showCancelButton: true,
		confirmButtonText: "Ya",
		cancelButtonText: "Tidak",
		showLoaderOnConfirm: true,
		preConfirm: async (login) => {
			try {
				const githubUrl = '<?php echo base_url(); ?>markas/proeksternal/expkey/'+iduser;
				const response = await fetch(githubUrl);
				if (!response.ok) {
					return Swal.showValidationMessage(`
						${JSON.stringify(await response.json())}
						`);
				}
				ambilkey = JSON.stringify(await response.json());
				return ambilkey;
			} catch (error) {
				Swal.showValidationMessage(`
					Request failed: ${error}
					`);
			}
		},
		allowOutsideClick: () => !Swal.isLoading()
	}).then((result) => {
		if (result.isConfirmed) {
			var isikey = JSON.parse(ambilkey);
			location.assign('<?php echo base_url(); ?>markas/proeksternal/download_plus_headers/'+isikey.alamat);
			swal.fire({
				title: "Berkas ByPass",
				icon: "info",
				html: "Anda punya waktu <b></b> detik untuk mengunduh berkas.",
				timer: 10000,
				allowOutsideClick:false,
				timerProgressBar: true,
				showConfirmButton: false,
				didOpen: () => {
    Swal.showLoading();
    const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      timer.textContent = `${Swal.getTimerLeft()/1000}`;
    }, 100);
  },
  willClose: () => {
    clearInterval(timerInterval);
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
		swal.fire({
			title: "Berkas ByPass",
			icon: "success",
			html: "Demi keamanan, berikan/kirimkan berkas ini <strong class=\"red\">HANYA</strong> pada pengguna yang bersangkutan!",
			showConfirmButton: true
		});
  }
			});

/*
			$.ajax({
					url: '<?php echo base_url(); ?>markas/proeksternal/download_plus_headers/',
					type: 'POST',
					data: jQuery.param({
						katcari: 'thn',
						valcari:''
					}),
					success: function(itahun) {
						if(itahun != ''){
							var isidata = JSON.parse(itahun);
							var icel = '';
							for (var i = 0; i <= isidata.length-1; i++) {
								icel += '<div><button class="btn btn-app red pull-right" onclick="cekdetreport(\''+isidata[i].waktu+'\')">'+isidata[i].waktu+'</btn></div>';
								icel += '<div id="list'+isidata[i].waktu+'"  class="tagsinput" style="width:100%;"></div>';
								icel += '<hr/>';
							}
							$('#buttable').append(icel);
						}

					},
					error: function (jqXHR, textStatus, errorThrown)
					{
							new PNotify({
									title: 'Kesalahan Sistim',
									type: 'danger',
									text: 'Gagal menyusun data #ft_nmr2_1',
									styling: 'bootstrap3'
							});
					catat("Gagal menyusun data #ft_nmr2_1");
					}
			});
*/
		}
	});

}
</script>

</body>
</html>
