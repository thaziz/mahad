<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php if ($status==false): ?>
<div class="content-wrapper">


	<section class="content-header">
		<h1>
			Bank Soal
			<small> Insert</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?=base_url('panel/admin');?>">Bank Soal</a></li>
			<li class="active">Ujian</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">		  				       					
						<div class="box-body">
							<div class="alert alert-danger" >
								<?=$info?>	
							</div>
						</div>
				</div>
			</div>
		</div>
	</section>
</div>
						
<?php else: ?>




<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.css">
<style type="text/css">
	.b.nav>li>a {
		padding-top: 5px;
		padding-bottom: 5px;
	}
	.borderless td, .borderless th {
		border: none;
	}

	.table thead tr th, .table tbody tr td {
		border: none;
	}
</style>
<div class="content-wrapper">


	<section class="content-header">
		<h1>
			Bank Soal
			<small> Insert</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?=base_url('panel/admin');?>">Bank Soal</a></li>
			<li class="active">Insert</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">		  				       
					<form class="form-horizontal" method="post" id="form_master">
						<div class="box-body">
							<input type="hidden" name="id_master" id="master">
							<table width="100%" class="table">
								<td>Nama Dosen</td>
								<td><input disabled="" class="form-control" type="" name="" value="<?=$this->session->userdata('name')?>" ></td>
								<tr> 
									<td>Kelas</td>
									<td>
										<div class=""> 
											<div class="col-md-2" style="padding: 0px 0px 0px 0px"> 
												<select class="form-control ds" name="level">
													<option>1</option>	
													<option>2</option>	
													<option>3</option>	
												</select>
												<span class="info"></span>
											</div>
											<div class="col-md-2"> 
												<select class="form-control ds" name="kelas">
													<option>A</option>	
													<option>B</option>	
													<option>C</option>	
												</select>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Jenis Ujian</td>
									<td>
										<select class="form-control ds" name="jenis">
											<option>UTS</option>	
											<option>UAS</option>	
										</select>

									</td>
								</tr>

								<tr>
									<td>Mata Kuliah</td>
									<td>

										<select class="form-control ds" name="matkul">
											<?php foreach ($matkul as $key => $v): ?>
												<option value="<?=$v->id?>"><?=$v->nama ?></option>	
											<?php endforeach ?>
										</select>

									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td>
										<ul class="nav nav-pills">			
											<li><a data-toggle="tab" class="btn ds" onclick="jeniskelamin('L')"><i class="fa fa-male"></i></a></li>
											<li><a data-toggle="tab" class="btn ds" onclick="jeniskelamin('P')"><i class="fa fa-female"></i></a></li>
										</ul>	

										<input type="hidden" name="jk" id="jk">
										
												<span class="info"></span>									
											


									</td>
								</tr>	

								<tr>
									<td>Tanggal Pelaksanaan <span style="color: red"> *</span> </td>
									<td>


				
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input autocomplete="off" onchange="refresh_kode()"  id="tgl" value="<?=date('d-m-Y') ?>" type="text" class="form-control reset date" name="tanggal"  autocomplete="off">

												<span class="info"></span>
				
            </div>
          </div>					</td>
								</tr>
								<tr>
									<td>
										Jam Pelaksanaan
									</td>
									<td>												<div class="form-group">

										<div class="col-sm-12  col-xs-12">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<div class="input-group">
														<input type="text" name="stime_perday" class="form-control timepicker ds" value="5:13 PM">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-6">
													<div class="input-group">
														<input type="text" name="etime_perday" class="form-control timepicker ds" value="5:13 PM">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>									
											<span class="info"></span>
								</td>
							</tr>	
							<!-- <tr>
								<td>Waktu (Menit)</td>
								<td><input type="number" name="waktu" class="form-control ds" value="90">
									<span class="info"></span>
								</td>
							</tr>    --> 
							<tr>
								<td>Status</td>
								<td>
									<div class="form-group">
										<div class = "col-sm-10">
											<label class="switch">
												<input type="checkbox" name="status" value="1" checked="">
												<div class="slider round"></div>
											</label>
										</div>
									</div>
								</td>
							</tr>    

						</table>
					</div>	            	
					<div class="box-footer">
						<div class="col-md-2 col-sm-offset-10">
							<button id = "enter" class="btn btn-primary pull-right" type="submit">Simpan</button>
							<a href="<?php echo base_url('panel/bank_soal'); ?>" class="btn btn-default">Kembali</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>




<section class="content" id="detail" style="display:">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
		            <div class="box-body">

		            	<div class="col-md-12">


		            		<ul class="b nav nav-pills">
		            			<li class="active"><a data-toggle="tab" href="#menu1">Pilihan Ganda</a></li>
		            			<li><a data-toggle="tab" href="#menu2">Benar/Salah</a></li>
		            			<li><a data-toggle="tab" href="#menu3">Soal Esai</a></li>
		            		</ul>
		            		<div class="tab-content">
		            			<div id="menu1" class="tab-pane fade in active">

		            				<div class="row">
		            					<div class="col-md-12" style="text-align: center">
		            						<div id="import" class="collapse" style="margin:15px auto; width: 550px;">
		            							<form id="importform" method="post" enctype="multipart/form-data">
		            								<div class="form-group">
		            									<div class="input-group">
		            										<input type="hidden" name="type" value="pilihan">
		            										<input type="file" name="file" id="input-file" class="form-control upload_soal1">
		            										<span class="input-group-addon">
		            											<label style="position:relative;margin-bottom:0"><input type="checkbox" value="1" name="header"  style="position:relative;top:3px;"> Skip Header</label>
		            										</span>
		            										<span class="input-group-btn">
		            											<button class="btn btn-primary" id="btn-import" type="submit">Import</button>
		            										</span>
		            									</div>
		            								</div>
		            							</form>
		            							<div class="progress" style="display:none;">
		            								<div class="indeterminate"></div>
		            							</div>
		            						</div>
		            					</div>
		            				</div>



		            				<div class="row"> 

		            					<div class="col-md-12">
		            						<button href="#import" data-toggle="collapse" id = "enter" class="btn btn-warning pull-right" type="button"><i class="fa fa-upload"></i> Pilihan Ganda</button>
		            						<br> 
		            					</div>
		            				</div>	
		            				<div class="col-md-12"> 

		            					<table class="table borderless table_soal1" width="100%">
		            						<tbody id="body_soal"> 

		            							<?php foreach ($pilihan as $key => $v): ?>
	<?php  							
	$html='';
	$a='';
	$b='';
	$c='';
	$d='';
	//var_dump($v->sd_kunci);exit();
	if($v->sd_kunci=='a'||$v->sd_kunci=='A'){
		$a='checked="checked"';
	}
	if($v->sd_kunci=='b'||$v->sd_kunci=='B'){
		
		$b='checked="checked"';
	}
	if($v->sd_kunci=='c'||$v->sd_kunci=='C'){
		$c='checked="checked"';
	}
	if($v->sd_kunci=='d'||$v->sd_kunci=='D'){
		$d='checked="checked"';
	}
	?>
	
	<tr class="no_soal">
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_master_soal ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_detailid?>">
			<span class="no"></span>
		</td>
		<td colspan="3" width="85%">
			<?=$v->sd_soal?>
		</td>
		<td>
			<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','pilihan')" >
				<i class="fa fa-minus"></i>
			</button>
			<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','pilihan')" >
				<i class="fa fa-pencil"></i>
			</button>
		</td>
	</tr>
	<tr>
		<td></td>
		<td width="1%">
			a.
		</td>
		<td width="1%">
			<input type="radio" name="jawaban<?=$v->sd_detailid?>" value="a" <?=$a ?> disabled></td>
		<td colspan="1"><?=$v->sd_a ?></td>
		<tr> 
			<td></td><td>b.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v->sd_detailid?>" value="b" <?=$b ?> disabled></td>
			<td colspan="1"><?=$v->sd_b ?></td>
		</tr></tr>
		<tr>
			<td></td><td>c.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v->sd_detailid?>" value="c" <?=$c ?> disabled></td>
			<td colspan="1"><?=$v->sd_c ?></td>
		</tr>
		<tr> 
			<td></td><td>d.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v->sd_detailid?>" value="d" <?=$d ?> disabled></td>
			<td colspan="1"><?=$v->sd_d ?></td>
		</tr>





	<?php endforeach ?>


		            						</tbody>
		            					</table>
		            				</div>



		            				<div class="btn-group pull-right"> 	
		            					<button type="button" class="btn btn-default"  onclick="soal1()"><i class="fa fa-plus"></i> Tambah Soal</button>
		            					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		            						<span class="caret"></span>
		            						<span class="sr-only">Toggle Dropdown</span>
		            					</button>
		            					<ul class="dropdown-menu" role="menu">
		            						<li><a onclick="header1()">Tambah Header</a></li>
		            						<li><a onclick="header2()">Tambah Sub Header</a></li>
		            						<li><a onclick="header3()">Tambah Uraian</a></li>
		            					</ul>
		            				</div>


		            				<div class="row">
		            					<div class="col-md-12"> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            					</div>	
		            				</div>




		            			</div>
		            			<!-- menu2 -->





		            			<div id="menu2" class="tab-pane fade">

		            				<div class="row">
		            					<div class="col-md-12" style="text-align: center">
		            						<div id="import2" class="collapse" style="margin:15px auto; width: 550px;">
		            							<form id="importform2" method="post" enctype="multipart/form-data">
		            								<div class="form-group">
		            									<div class="input-group">
		            										<input type="hidden" name="type" value="bs">
		            										<input type="file" name="file" id="input-file2" class="form-control upload_soal2">
		            										<span class="input-group-addon">
		            											<label style="position:relative;margin-bottom:0"><input type="checkbox" value="1" name="header"  style="position:relative;top:3px;"> Skip Header</label>
		            										</span>
		            										<span class="input-group-btn">
		            											<button class="btn btn-primary" id="btn-import2" type="submit">Import</button>
		            										</span>
		            									</div>
		            								</div>
		            							</form>
		            							<div class="progress" style="display:none;">
		            								<div class="indeterminate"></div>
		            							</div>
		            						</div>
		            					</div>
		            				</div>



		            				<div class="row"> 
		            					<div class="col-md-12">
		            						<button href="#import2" data-toggle="collapse" id = "enter" class="btn btn-warning pull-right" type="button"><i class="fa fa-upload"></i> Pilihan Ganda</button>
		            						<br> 
		            					</div>
		            				</div>	
		            				<div class="col-md-12"> 

		            					<table class="table borderless" width="100%">
		            						<tbody id="body_soal_bs"> 


		            								<?php foreach ($bs as $key => $v): ?>
	<?php  							
	$html='';
	$a='';
	$b='';
	$c='';
	$d='';
	if($v->sd_kunci=='a'||$v->sd_kunci=='A'){
		$a='checked="checked"';
	}
	if($v->sd_kunci=='b'||$v->sd_kunci=='B'){
		
		$b='checked="checked"';
	}

	?>
	
	<tr class="no_soal">
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_master_soal ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_detailid?>">
			<span class="no"></span>
		</td>
		<td colspan="3">
			<?=$v->sd_soal?>
		</td>
		<td>
			<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','bs')" >
				<i class="fa fa-minus"></i>
			</button>
			<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','bs')" >
				<i class="fa fa-pencil"></i>
			</button>
		</td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 0.5em">
			a.
		</td>
		<td style="width: 0.5em">
			<input type="radio" name="jawaban-bs<?=$v->sd_detailid?>" value="a" <?=$a ?> disabled></td>
		<td colspan="1"><?=$v->sd_a ?></td>
		<tr> 
			<td></td><td>b.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban-bs<?=$v->sd_detailid?>" value="b" <?=$b ?> disabled></td>
			<td colspan="1"><?=$v->sd_b ?></td>
		</tr></tr>





	<?php endforeach ?>



		            						</tbody>
		            					</table>
		            				</div>



		            				<div class="btn-group pull-right"> 	
		            					<button type="button" class="btn btn-default"  onclick="soal2()"><i class="fa fa-plus"></i> Tambah Soal</button>
		            					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		            						<span class="caret"></span>
		            						<span class="sr-only">Toggle Dropdown</span>
		            					</button>
		            					<ul class="dropdown-menu" role="menu">
		            						<li><a onclick="header1()">Tambah Header</a></li>
		            						<li><a onclick="header2()">Tambah Sub Header</a></li>
		            						<li><a onclick="header3()">Tambah Uraian</a></li>
		            					</ul>
		            				</div>


		            				<div class="row">
		            					<div class="col-md-12"> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            					</div>	
		            				</div>




		            			</div>













		            			<!-- menu3 -->


		            			<div id="menu3" class="tab-pane fade">

		            				<div class="row">
		            					<div class="col-md-12" style="text-align: center">
		            						<div id="import3" class="collapse" style="margin:15px auto; width: 550px;">
		            							<form id="importform3" method="post" enctype="multipart/form-data">
		            								<div class="form-group">
		            									<div class="input-group">
		            										<input type="hidden" name="type" value="esai">
		            										<input type="file" name="file" id="input-file2" class="form-control upload_soal3">
		            										<span class="input-group-addon">
		            											<label style="position:relative;margin-bottom:0"><input type="checkbox" value="1" name="header"  style="position:relative;top:3px;"> Skip Header</label>
		            										</span>
		            										<span class="input-group-btn">
		            											<button class="btn btn-primary" id="btn-import3" type="submit">Import</button>
		            										</span>
		            									</div>
		            								</div>
		            							</form>
		            							<div class="progress" style="display:none;">
		            								<div class="indeterminate"></div>
		            							</div>
		            						</div>
		            					</div>
		            				</div>



		            				<div class="row"> 
		            					<div class="col-md-12">
		            						<button href="#import3" data-toggle="collapse" id = "enter" class="btn btn-warning pull-right" type="button"><i class="fa fa-upload"></i> Pilihan Esai</button>
		            						<br> 
		            					</div>
		            				</div>	
		            				<div class="col-md-12"> 

		            					<table class="table borderless" width="100%">
		            						<tbody id="body_soal_esai"> 

		            								<?php foreach ($esai as $key => $v): ?>
	
	
	<tr class="no_soal">
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_master_soal ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v->sd_detailid?>">
			<span class="no"></span>
		</td>
		<td colspan="3">
			<?=$v->sd_soal?>
		</td>
		<td>
			<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','esai')" >
				<i class="fa fa-minus"></i>
			</button>
			<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v->sd_master_soal ?>','<?=$v->sd_detailid ?>','esai')" >
				<i class="fa fa-pencil"></i>
			</button>
		</td>
	</tr>
	




	<?php endforeach ?>



		            						</tbody>
		            					</table>
		            				</div>



		            				<div class="btn-group pull-right"> 	
		            					<button type="button" class="btn btn-default"  onclick="soal3()"><i class="fa fa-plus"></i> Tambah Soal</button>
		            					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		            						<span class="caret"></span>
		            						<span class="sr-only">Toggle Dropdown</span>
		            					</button>
		            					<ul class="dropdown-menu" role="menu">
		            						<li><a onclick="header1()">Tambah Header</a></li>
		            						<li><a onclick="header2()">Tambah Sub Header</a></li>
		            						<li><a onclick="header3()">Tambah Uraian</a></li>
		            					</ul>
		            				</div>


		            				<div class="row">
		            					<div class="col-md-12"> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            						<br> 
		            					</div>	
		            				</div>




		            			</div>












		            		</div>
		            	</div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>


	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<form class="form-horizontal" enctype="multipart/form-data" method="post" id="form_soal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Soal Pilihan</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="master_id" class="master_soal">


								<div id="tdetail" class="collapse">

									<table class="table">
										<tr>
											<td>Header</td>
											<td colspan="2"><textarea class="form-control" name="lheader" id="lheader"></textarea></td>								
										</tr>
										<tr>
											<td>Sub Header</td>
											<td colspan="2"><textarea class="form-control" name="subheader" id="subheader"></textarea></td>								
										</tr>
										<tr>
											<td>Soal Cerita</td>
											<td colspan="2"><textarea class="form-control" name="cerita" id="cerita"></textarea></td>								
										</tr>
										
									</table>


									<div class="progress" style="display:none;">
										<div class="indeterminate"></div>
									</div>
								</div>
							



						<div class="row"> 
							<div class="col-md-12">
								<button href="#tdetail" data-toggle="collapse" id = "enter" class="btn btn-info btn-xs pull-right" type="button"><i class="fa fa-upload"></i> Tambah Detail</button>
								<br> 
							</div>
						</div>	


						<table class="table">
							<tr>
								<td>Soal</td>
								<td colspan="2"><textarea class="form-control" name="soal" id="soal"></textarea>
								<span class="info_soal_pilihan"></span>
									<input type="hidden" name="jenis" value="pilihan"></td>	
									<input type="" name="sd_master_soal" value=""></td>	
									<input type="" name="sd_detailid" value=""></td>	

							</tr>
							<tr>
								<td>Upload file</td>
								<td colspan="2"><input type="file" name="berkas"></td>								
							</tr>
						</table>
						<table class="table">
							<tr>
								<th>-</th>
								<th width="10%" class="info_kunci_pilihan">Kunci Jawaban
										
								</th>
								<th>Jawaban</th>
							</tr>

							<tr>
								<td>A.</td>       				
								<td><input type="radio" name="kunci" value="a"></td>
								<td><input type="text" name="a" class="form-control">
									<span class="info_pilihan"></span>
								</td>
							</tr>
							<tr>
								<td>B.</td>       				
								<td><input type="radio" name="kunci" value="b"></td>
								<td><input type="text" name="b" class="form-control">
									<span class="info_pilihan"></span>
								</td>
							</tr>
							<tr>
								<td>C.</td>       				
								<td><input type="radio" name="kunci" value="c"></td>
								<td><input type="text" name="c" class="form-control">
									<span class="info_pilihan"></span>
								</td>
							</tr>       			
							<tr>
								<td>D.</td>       				
								<td><input type="radio" name="kunci" value="d"></td>
								<td><input type="text" name="d" class="form-control">
									<span class="info_pilihan"></span>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" >Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>

		</div>
	</div>


	<!-- modal2 -->



	<!-- Modal -->
	<div id="myModal2" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<form class="form-horizontal" enctype="multipart/form-data" method="post" id="form_soal2">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Soal Benar/Salah</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="master_id" class="master_soal">
						<table class="table">
							<tr>
								<td>Soal</td>
								<td colspan="2">
									<textarea class="form-control" name="soal" id="soal2"></textarea>
									<span class="info_soal_bs"></span>
									<input type="hidden" name="jenis" value="bs"></td>	
									<input type="" name="sd_master_soal" value=""></td>	
									<input type="" name="sd_detailid" value=""></td>								
							</tr>
							<tr>
								<td>Upload file</td>
								<td colspan="2"><input type="file" name="berkas"></td>								
							</tr>
						</table>
						<table class="table">
							<tr>
								<th>-</th>
								<th width="10%" class="info_kunci_bs">Kunci Jawaban
								</th>
								<th>Jawaban</th>
							</tr>

							<tr>
								<td></td>       				
								<td><input type="radio" name="kunci" value="a"></td>
								<td><input type="text" name="a" class="form-control">
										<span class="info_bs"></span>
								</td>
							</tr>
							<tr>
								<td></td>       				
								<td><input type="radio" name="kunci" value="b"></td>
								<td><input type="text" name="b" class="form-control">
									<span class="info_bs"></span>
								</td>
							</tr>		    						
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" >Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>

		</div>
	</div>


	<!-- modal 3 -->

	<!-- Modal -->
	<div id="myModal3" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<form class="form-horizontal" enctype="multipart/form-data" method="post" id="form_soal3">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tambah Soal Esai</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="master_id" class="master_soal">
						<table class="table">
							<tr>
								<td>Soal</td>
								<td colspan="2"><textarea class="form-control" name="soal" id="soal3"></textarea>
									<span class="info_soal_esai"></span>
									<input type="hidden" name="jenis" value="esai"></td>	
									<input type="" name="sd_master_soal" value=""></td>	
									<input type="" name="sd_detailid" value=""></td>								
							</tr>
							<tr>
								<td>Upload file</td>
								<td colspan="2"><input type="file" name="berkas"></td>			
							</tr>
						</table>
						<table class="table">
							<tr>
								<th width="100%">Note</th>

							</tr>
							<tr>									      				
								<td><textarea class="form-control" name="note"> </textarea></td>
							</tr>		    						
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" >Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>

		</div>
	</div>




</div>
<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script><!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.js"></script>
<!-- CKEditor -->
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	function jeniskelamin(jk){
		$('#jk').val(jk)
	}

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.timepicker').mdtimepicker();
		$('#date_range').daterangepicker({
			locale: {
				format: 'MMMM DD, YYYY'
			}
		});
		$('.date').datepicker({
			autoclose:true,
			format: 'dd-mm-yyyy',

		});
		$('form#form_soal').on('submit', function(e) {
			e.preventDefault();	

		var note = CKEDITOR.instances['soal'].getData();
		$('[name="soal"]').val(note);
		var lheader = CKEDITOR.instances['lheader'].getData();
		$('[name="lheader"]').val(lheader);
		var subheader = CKEDITOR.instances['subheader'].getData();
		$('[name="subheader"]').val(subheader);
		var cerita = CKEDITOR.instances['cerita'].getData();
		$('[name="cerita"]').val(cerita);
					//data.push({master:$('#master').val()});		
					$.ajax({
						url : '<?php echo base_url("panel/bank_soal/insert_detail"); ?>',
						type: "POST",
						data:new FormData(this),
						processData:false,
						contentType:false,
						cache:false,
						async:false,
						dataType: 'json',
						success:function(data, textStatus, jqXHR){
							if(!data.status){
								$.each(data.e, function(key, val){
									$('[name="'+key+'"] + .info_pilihan').html(val);
									
									$('.info_'+key+'_pilihan').html(val);

								});
							}else{	
									$('#body_soal').append(data.view)
									var n=1;
									$(".table_soal1 > tbody  > tr.no_soal").each(function(idx,tr) {
										 $(this).find("span").text(n)
										
										 n++;
								     });
/*
									$('table.table_soal1 > tbody  > tr').each(function(index, tr) { 
									  alert(index);
									});*/
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
						}
					});
				});
	});

	$(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
</script>


<!-- bs js -->


<script type="text/javascript">
	$(document).ready(function(){
		$('form#form_soal2').on('submit', function(e) {
			e.preventDefault();	
			var soal2 = CKEDITOR.instances['soal2'].getData();
			$('[name="soal2"]').val(soal2);
					//data.push({master:$('#master').val()});		
					$.ajax({
						url : '<?php echo base_url("panel/bank_soal/insert_detail"); ?>',
						type: "POST",
						data:new FormData(this),
						processData:false,
						contentType:false,
						cache:false,
						async:false,
						dataType: 'json',
						success:function(data, textStatus, jqXHR){
							if(!data.status){
								$.each(data.e, function(key, val){
									console.log(key)
									$('[name="'+key+'"] + .info_bs').html(val);
									$('.info_'+key+'_bs').html(val);

								});
							}else{	
								console.log(data.view)
									$('#body_soal_bs').append(data.view)

							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
						}
					});
				});
	});

	
</script>



<script type="text/javascript">
	$(document).ready(function(){
		$('form#form_soal3').on('submit', function(e) {
			e.preventDefault();	

			var soal3 = CKEDITOR.instances['soal3'].getData();
			$('[name="soal3"]').val(soal3);

			$.ajax({
				url : '<?php echo base_url("panel/bank_soal/insert_detail"); ?>',
				type: "POST",
				data:new FormData(this),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
				dataType: 'json',
				success:function(data, textStatus, jqXHR){
					if(!data.status){
						$.each(data.e, function(key, val){

							$('[name="'+key+'"] + .info_esai').html(val);
							$('.info_'+key+'_esai').html(val);

						});
					}else{	
							$('#body_soal_esai').append(data.view)
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert('Error,something goes wrong');
				}
			});
		});
	});

	
</script>

<script type="text/javascript">
	function soal1(){

		$('#myModal').modal('show');
	}
	function soal2(){
		$('#myModal2').modal('show');
	}
	function soal3(){
		$('#myModal3').modal('show');
	}

</script>

















<script type="text/javascript">
	$(document).ready(function(){
		$('form#form_master').on('submit', function(e) {
			e.preventDefault();				
			$.ajax({
				url : '<?php echo base_url("panel/bank_soal/insert"); ?>',
				type: "POST",
				data : $('#form_master').serialize(),
				dataType: 'json',
				success:function(data, textStatus, jqXHR){
					if(!data.status){
						$.each(data.e, function(key, val){
							console.log(key)
							$('[name="'+key+'"] + .info').html(val);
                	//if(key=='oa_account_id')
                	$('#'+key).html(val);
                	
                });
					}else{
						$('.ds').attr('disabled',true)
						$('#detail').css('display','')
						$('#master').val(data.id)	
						$('.master_soal').val(data.id)	



					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert('Error,something goes wrong');
				}
			});
		});
	});
</script>





<script type="text/javascript">
	$(document).ready(function(){
		$('form#importform').on('submit', function(e) {
			
			e.preventDefault();
			$('#importform').hide();
			$('.progress').show();
			var data = new FormData(this);
			$.ajax({
				url : '<?=base_url('panel/bank_soal/import_data/')?>'+$('#master').val(),
				type: "POST",
				data : data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success:function(data, textStatus, jqXHR){
					if(data.status=='ERROR'){
						$().toastmessage('showToast', {
							text     : 'Failed, '+data.errors,
							position : 'top-center',
							type     : 'error',
							close    : function () {
                  //window.location = "<?=current_url() ?>";
              }
          });
					}else if(data.status){
						$('.upload_soal1').val('');
						$('#body_soal').append(data.view)
					}else{
						$().toastmessage('showToast', {
							text     : data.msg,
							position : 'top-center',
							type     : 'error',
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					$.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
					alert('Something goes wrong, ask to your vendor app');
				},
				complete: function(){
					$('#importform').show();
					$('.progress').hide();
				}
			});
		});
	});
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$('form#importform2').on('submit', function(e) {
			
			e.preventDefault();
			$('#importform2').hide();
			$('.progress').show();
			var data = new FormData(this);
			$.ajax({
				url : '<?=base_url('panel/bank_soal/import_data/')?>'+$('#master').val(),
				type: "POST",
				data : data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success:function(data, textStatus, jqXHR){
					if(data.status=='ERROR'){
						$().toastmessage('showToast', {
							text     : 'Gagal, '+data.errors,
							position : 'top-center',
							type     : 'error',
							close    : function () {
                  //window.location = "<?=current_url() ?>";
              }
          });
					}else if(data.status){
						$('.upload_soal1').val('');
						$('#body_soal_bs').append(data.view)
					}else{
						$().toastmessage('showToast', {
							text     : data.msg,
							position : 'top-center',
							type     : 'error',
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					$.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
					alert('Something goes wrong, ask to your vendor app');
				},
				complete: function(){
					$('#importform2').show();
					$('.progress').hide();
				}
			});
		});
	});
</script>




<script type="text/javascript">
	$(document).ready(function(){
		$('form#importform3').on('submit', function(e) {
			
			e.preventDefault();
			$('#importform3').hide();
			$('.progress').show();
			var data = new FormData(this);
			$.ajax({
				url : '<?=base_url('panel/bank_soal/import_data/')?>'+$('#master').val(),
				type: "POST",
				data : data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success:function(data, textStatus, jqXHR){
					if(data.status=='ERROR'){
						$().toastmessage('showToast', {
							text     : 'Failed, '+data.errors,
							position : 'top-center',
							type     : 'error',
							close    : function () {
                  //window.location = "<?=current_url() ?>";
              }
          });
					}else if(data.status){
						$('.upload_soal3').val('');
						$('#body_soal_esai').append(data.view)
					}else{
						$().toastmessage('showToast', {
							text     : data.msg,
							position : 'top-center',
							type     : 'error',
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					$.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
					alert('Something goes wrong, ask to your vendor app');
				},
				complete: function(){
					$('#importform3').show();
					$('.progress').hide();
				}
			});
		});
	});
</script>


<script type="text/javascript">
	$(document).ready(function(){
  	 var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },{ name: 'links', items: [ 'Link', 'Unlink' ] },];
	CKEDITOR.replace('lheader', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
	CKEDITOR.replace('subheader', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
	CKEDITOR.replace('cerita', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
	CKEDITOR.replace('soal', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
	CKEDITOR.replace('soal2', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
	CKEDITOR.replace('soal3', {height:150,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
})
</script>


<script type="text/javascript">
	function edit_detail(master,detail,tipe){
		/*if(tipe=='pilihan'){
				$('#myModal').modal('show');
		}else if(tipe=='bs'){
				$('#myModal2').modal('show');
		}
		else if(tipe=='bs'){
				$('#myModal3').modal('show');
		}*/
			$.ajax({
						url : '<?php echo base_url("panel/bank_soal/edit_detail"); ?>',
						type: "POST",
						data:{'master':master,
							  'detail':detail,
							  'tipe':tipe
							 },
						
						dataType: 'json',
						success:function(data, textStatus, jqXHR){

		if(tipe=='pilihan'){			
			CKEDITOR.instances['soal'].setData(data.pilihan.sd_soal);
			 $("#form_soal input[name='kunci'][value='"+data.pilihan.sd_kunci.toLowerCase()+"']").prop('checked', true);		
			 $("#form_soal input[name='a']").val(data.pilihan.sd_a);
			 $("#form_soal input[name='b']").val(data.pilihan.sd_b);
			 $("#form_soal input[name='c']").val(data.pilihan.sd_c);
			 $("#form_soal input[name='d']").val(data.pilihan.sd_d);	
			 $("#form_soal input[name='sd_master_soal']").val(data.pilihan.sd_master_soal);
			 $("#form_soal input[name='sd_detailid']").val(data.pilihan.sd_detailid);		
			 $('#myModal').modal('show');		
		}else if(tipe=='bs'){
			CKEDITOR.instances['soal2'].setData(data.bs.sd_soal);
			 $("#form_soal2 input[name='kunci'][value='"+data.bs.sd_kunci.toLowerCase()+"']").prop('checked', true);
			 $("#form_soal2 input[name='a']").val(data.bs.sd_a);
			 $("#form_soal2 input[name='b']").val(data.bs.sd_b);
			 $("#form_soal2 input[name='sd_master_soal']").val(data.bs.sd_master_soal);
			 $("#form_soal2 input[name='sd_detailid']").val(data.bs.sd_detailid);	

				$('#myModal2').modal('show');
		}
		else if(tipe=='esai'){
			CKEDITOR.instances['soal3'].setData(data.esai.sd_soal);
			$("#form_soal3 input[name='sd_master_soal']").val(data.esai.sd_master_soal);
			$("#form_soal3 input[name='sd_detailid']").val(data.esai.sd_detailid);	
				$('#myModal3').modal('show');
		}


							
							if(!data.status){
								$.each(data.e, function(key, val){
									$('[name="'+key+'"] + .info_pilihan').html(val);
									
									$('.info_'+key+'_pilihan').html(val);

								});
							}else{	
									$('#body_soal').append(data.view)
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
						}
					});
				
	}
	function hapus(master,detail,tipe){
		
	}
</script>

<?php endif ?>