<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- <html dir="rtl" lang="ar"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.css">
<style type="text/css">

	textarea {
		
		resize: none;
		overflow: hidden;
	}
	

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
			Hasil Ujian
			<small> </small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?=base_url('panel/admin');?>">Hasil Ujian</a></li>
			<li class="active">Hasil Ujian</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">		  				       
					<form class="form-horizontal" method="post" id="form_ujian">
						<div class="box-body">
							<table width="100%" class="table">								
								<tr> 
									<td>Kelas</td>
									<td><?=$master->level.' '.$master->ms_kelas ?>
									</td>
								</tr>
								<tr>
									<td>Jenis Ujian</td>
									<td>
										<?=$master->ms_jenis_ujian ?>
									</td>
								</tr>

								<tr>
									<td>Mata Kuliah</td>
									<td>
										<?=$master->subject_ar_name ?>
									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td>													
											<?php if($master->ms_jenis_kel=='L'): ?>
												Laki-laki
											<?php endif ?>
											<?php if($master->ms_jenis_kel=='P'): ?>
												Wanita								
											<?php endif ?>
										
									</td>
								</tr>	


								<tr>
									<td>Tanggal</td>
									<td>
										<?=$master->ms_startdate?>
									</td>
								</tr>
								<tr>
									<td>
										Waktu Pelaksanaan
									</td>
									<td>
										<?=$master->ms_starttime.' - '.$master->ms_endtime ?>
										
									</td>
							</tr>

							<tr>
								<td>Soal Pilihan ganda</td>
								<td><input class="form-control" type="number" name="" value="<?=$master->u_nilai_pilihan==''?0:$master->u_nilai_pilihan ?>"></td>
							</tr>	            		

							<tr>
								<td>Soal Benar Salah</td>
								<td><input class="form-control" type="number" name="" value="<?=$master->u_nilai_benarsalah==''?0:$master->u_nilai_benarsalah ?>"></td>
								
							</tr>	            		

							<tr>
								<td>Soal Esai</td>
								<td><input class="form-control" type="number" name="" value="<?=$master->u_nilai_esai==''?0:$master->u_nilai_esai ?>"></td>	
							</tr>	            		

							<tr>
								<th>Nilai Total</th>
								<th>
									<input class="form-control" type="number" name="" value="<?=$master->u_nilai_total==''?'':$master->u_nilai_esai ?>">
								</th>	
							</tr>	            		
						</table>
					</div>	            	
					<div class="box-footer">
						<div class="col-md-4 col-sm-offset-8">
							<button id = "enter" class="btn btn-primary  ds" type="submit" >Simpan</button>
							<button id = "enter" class="btn btn-primary  ds" type="button"  onclick="location.href = '<?php echo base_url('panel/bank_soal'); ?>'"; /> Kembali</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	<section class="content" id="detail" style="display: ">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">

						<div class="col-md-12">
							<span id="countdown" class="timer"></span>
							<div class="tab-content">

								<div class="alert alert-info" role="alert">Pilihan <div class="pull-right nilai_pilihan"></div></div>

								<table class="table" width="100%">
									<?php foreach ($pilihan as $key => $v): ?>
										<?php  
										$a=$v->sd_a;
										$b=$v->sd_b;
										$c=$v->sd_c;
										$d=$v->sd_d;
										$ja='';
										$jb='';
										$jc='';
										$jd='';

										$jja='';
										$jjb='';
										$jjc='';
										$jjd='';


										if(strtolower('A')==strtolower($v->ud_jawaban)){
											$ja='checked="checked"';
											
										}
										if(strtolower('B')==strtolower($v->ud_jawaban)){
											$jb='checked="checked"';
											
										}
										if(strtolower('C')==strtolower($v->ud_jawaban)){
											$jc='checked="checked"';
											
										}
										if(strtolower('D')==strtolower($v->ud_jawaban)){
											$jd='checked="checked"';
											
										}
										$benarorsalah='';
										if(strtolower($v->sd_kunci)==strtolower($v->ud_jawaban)){
											$benarorsalah='benar';
										}

										if($v->sd_kunci=='A'){
											$jja='style="color: green;font-weight: bold;"';
										}

										if($v->sd_kunci=='B'){
											$jjb='style="color: green;font-weight: bold;"';
										}

										if($v->sd_kunci=='C'){
											$jjc='style="color: green;font-weight: bold;"';
										}

										if($v->sd_kunci=='D'){
											$jjd='style="color: green;font-weight: bold;"';
										}


										; ?>
										<tr>
											<td style="width: 0.5em">
												<?=$key+1;?>
											</td>
											<td colspan="3">
												<?=$v->sd_soal;?>
												<input type="hidden"  value="<?=$v->sd_soal ?>">
											</td>
											<td width="10%">				
										<?php if ($benarorsalah=='benar'): ?>
												<i class="fa fa-check-square-o" style="font-size:24px;color:green"></i>
										<?php else: ?>
												<i class="fa fa-close" style="font-size:24px;color:red"></i>

										<?php endif ?>
											</td>
								</tr>

								<tr>
									<td></td>
									<td style="width: 0.5em">
										a.
									</td>
									<td style="width: 0.5em">
										<input  <?=$ja?>  type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$a[1]; ?>" class="ds">
									</td>
									<td colspan="1" <?=$jja?>><?=$a?></td>
								</tr>
								<tr> 
									<td></td>
									<td>b.</td>
									<td style="width: 0.5em">
										<input  <?=$jb?>  class="ds" type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$b[1]?>" ></td>
										<td colspan="1" <?=$jjb?> ><?=$b;?></td>
									</tr>
									<tr>
										<td></td>
										<td>c.</td>
										<td style="width: 0.5em">
											<input  <?=$jc?>  type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$c[1] ?>" class="ds" ></td>
										<td colspan="1" <?=$jjc?>><?=$c; ?></td>
									</tr>
									<tr> 
										<td></td><td>d.</td>
										<td style="width: 0.5em"><input  <?=$jd?>  type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$d[1] ?>" class="ds" ></td>
										<td colspan="1" <?=$jjd?>><?=$d; ?></td>
									</tr>
								<?php endforeach ?>
							</table>







							<div class="alert alert-info" role="alert">Benar / Salah<div class="pull-right nilai_bs"></div></div>
								<table class="table" width="100%">
									<?php foreach ($bs as $key => $v): ?>
										<?php  
										$a=$v->sd_a;
										$b=$v->sd_b;

										$ja='';
										$jb='';
										
										$jja='';
										$jjb='';
										
										if(strtolower('A')==strtolower($v->ud_jawaban)){
											$ja='checked="checked"';
										}
										if(strtolower('B')==strtolower($v->ud_jawaban)){
											$jb='checked="checked"';
										}
										$benarorsalah='';
										if(strtolower($v->sd_kunci)==strtolower($v->ud_jawaban)){
											$benarorsalah='benar';
										}

										if($v->sd_kunci=='A'){
											$jja='style="color: green;font-weight: bold;"';
										}

										if($v->sd_kunci=='B'){
											$jjb='style="color: green;font-weight: bold;"';
										}




										; ?>
										<tr>
											<td style="width: 0.5em">
												<?=$key+1;?>
											</td>
											<td colspan="3">
												<?=$v->sd_soal;?>
												<input type="hidden"  value="<?=$v->sd_soal ?>">
											</td>
											<td width="10%">				
										<?php if ($benarorsalah=='benar'): ?>
												<i class="fa fa-check-square-o" style="font-size:24px;color:green"></i>
										<?php else: ?>
												<i class="fa fa-close" style="font-size:24px;color:red"></i>

										<?php endif ?>
											</td>
								</tr>

								<tr>
									<td></td>
									<td style="width: 0.5em">
										a.
									</td>
									<td style="width: 0.5em">
										<input  <?=$ja?>  type="radio" name="jawaban-bs<?=$v->sd_detailid;?>" value="<?=$a[1]; ?>" class="ds">
									</td>
									<td colspan="1" <?=$jja?>><?=$a?></td>
								</tr>
								<tr> 
									<td></td>
									<td>b.</td>
									<td style="width: 0.5em">
										<input  <?=$jb?>  class="ds" type="radio" name="jawaban-bs<?=$v->sd_detailid;?>" value="<?=$b[1]?>" ></td>
										<td colspan="1" <?=$jjb?>><?=$b;?></td>
									</tr>
								<?php endforeach ?>
							</table>



									<div class="alert alert-info" role="alert">Esai</div>
									<!-- <div>Esai</div> -->
									<table class="table" width="100%">
										<?php foreach ($esai as $key => $v): ?>

											<tr>
												<td style="width: 0.5em">
													<input type="hidden" name="type_esai<?=$v->sd_detailid;?>" value="esai">
													<input type="hidden" name="ud_master_soal_es<?=$v->sd_detailid;?>" value="<?=$v->ud_master_soal; ?>">
													<input type="hidden" name="ud_detailid_es<?=$v->sd_detailid;?>" value="<?=$v->ud_detailid; ?>">

													<?=$v->sd_detailid;?>
												</td>
												<td colspan="3">
													<?=$v->sd_soal;?>
													<input type="hidden" name="soal_es<?=$v->sd_detailid;?>" value="<?=$v->sd_soal ?>">
												</td>
											</tr>
											<tr>
												<td colspan="2"><textarea class="form-control" onKeyUp='textCounter(this)' wrap='physical' rows='1' cols='60' class="ds"><?=$v->ud_jawaban;?></textarea></td>
											</tr>
											<tr>
												<td>
													Nilai
												</td>
												<td>
													<input type="" name="" class="form-control">
												</td>
											</tr>


										<?php endforeach ?>

									</table>













								</div>
							</div>
						</div>
					</div>
				</div>		        
			</form>
		</div>
	</section>

</div>
<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script><!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.js"></script>
<!-- CKEditor -->
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>


<script  type="text/javascript">

	function textCounter(f)
	{
		f.style.height = "1px";
		f.style.height = (25+f.scrollHeight)+"px";
	}

</script>
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

		$('form#form_ujian').on('submit', function(e) {
			e.preventDefault();	
					//data.push({master:$('#master').val()});	
					
					$.ajax({
						url : '<?php echo base_url("panel/ujian/save/".$id); ?>',
						type: "POST",
						data:new FormData(this),
						processData:false,
						contentType:false,
						cache:false,
						async:false,
						//dataType: 'json',
						success:function(data, textStatus, jqXHR){
							//$('.ds').attr('disabled',true)	
							if(!data.status){
								$.each(data.e, function(key, val){
									$('[name="'+key+'"] + .info').html(val);
									$('#'+key).html(val);

								});
							}else{	
								

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


