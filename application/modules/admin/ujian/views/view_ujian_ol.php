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
					<form class="form-horizontal" method="post" id="form_ujian">
						<div class="box-body">
							
							<input type="hidden" name="id_ujian" id="id_ujian" value="<?=$id_ujian ?>">
							<input type="hidden" name="id_master" id="master" value="<?=$id ?>">
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
						</table>
					</div>	            	
					<!-- <div class="box-footer">
						<div class="col-md-4 col-sm-offset-8">
							<button id = "enter" class="btn btn-primary  ds" type="submit" >Simpan</button>
							<button id = "enter" class="btn btn-primary  ds" type="button"  onclick="location.href = '<?php echo base_url('panel/bank_soal'); ?>'"; /> Kembali</button>
						</div>
					</div> -->
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



								<input type="hidden" name="jenis1" value="<?=count($pilihan) ?>">
								<input type="hidden" name="jenis2" value="<?=count($bs) ?>">
								<input type="hidden" name="jenis3" value="<?=count($esai) ?>">
								<div class="content-holder" style="border-style: outset;">



									<?php 
									$idx=1;
									$nop=1;
									$akhir=0;
									?>

									<?php 
									if($idx==1){
										$yes='style="display: block;"';
									}else{
										$yes='';
									}
									?>

									<?php if(count($pilihan)): ?>
										<div <?=$yes ?> class="soal" id="soal-<?=$idx?>" data-id="<?=$idx ?>" >
											<h3 style="text-align: center;">Anda Masuk Soal Pilihan Ganda</h3>
										</div>

										<?php 
										$idx++;
										?>


										<?php foreach ($pilihan as $key => $v): ?>

											<?php 
											if($idx==1){
												$yes='style="display: block;"';
											}else{
												$yes='';
											}
											?>

									

											<div class="soal" <?=$yes ?> id="soal-<?=$idx?>" data-id="<?=$idx ?>" >

												<table class="table" width="100%">
													<?php

													$a=explode("===",$v->ud_a);
													$b=explode("===",$v->ud_b);
													$c=explode("===",$v->ud_c);
													$d=explode("===",$v->ud_d);
													$ja='';
													$jb='';
													$jc='';
													$jd='';
													if(strtolower($a[1])==strtolower($v->ud_jawaban)){
															$ja='checked="checked"';
														}
													if(strtolower($b[1])==strtolower($v->ud_jawaban)){
															$jb='checked="checked"';
														}
													if(strtolower($c[1])==strtolower($v->ud_jawaban)){
															$jc='checked="checked"';
														}
													if(strtolower($d[1])==strtolower($v->ud_jawaban)){
															$jd='checked="checked"';
														}
													

													; ?>
													<tr>
														<td style="width: 0.5em">
															<input type="hidden" name="type<?=$v->sd_detailid;?>" value="pilihan">
															<input type="hidden" name="ud_master_soal<?=$v->sd_detailid;?>" value="<?=$v->ud_master_soal; ?>">
															<input type="hidden" name="ud_detailid<?=$v->sd_detailid;?>" value="<?=$v->ud_detailid; ?>">

															<?=$nop;?>

														</td>
														<td colspan="3">
															<?=$v->sd_soal;?>
															<input type="hidden" name="soal<?=$v->sd_detailid;?>" value="<?=$v->sd_soal ?>">
														</td>
													</tr>

													<tr>
														<td></td>
														<td style="width: 0.5em">
															a.
														</td>
														<td style="width: 0.5em">
															<input <?=$ja?> type="radio" onchange="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$a[1];?>','<?=$idx?>')" name="jawaban<?=$v->sd_detailid;?>" value="<?=$a[1]; ?>" class="ds">
														</td>
														<td colspan="1"><?=$a[0]?></td>
													</tr>
													<tr> 
														<td></td>
														<td>b.</td>
														<td style="width: 0.5em">
															<input <?=$jb ?> class="ds" type="radio" name="jawaban<?=$v->sd_detailid?>" value="<?=$b[1]?>" onchange="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$b[1];?>','<?=$idx?>')" ></td>
														<td colspan="1"><?=$b[0];?></td>
													</tr>
													<tr>
														<td></td>
														<td>c.</td>
														<td style="width: 0.5em">
															<input <?=$jc ?> type="radio" name="jawaban<?=$v->sd_detailid?>" value="<?=$c[1] ?>" class="ds" onchange="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$c[1];?>','<?=$idx?>')" ></td>
														<td colspan="1"><?=$c[0] ?></td>
													</tr>
													<tr> 
														<td></td><td>d.</td>
														<td style="width: 0.5em">
															<input <?=$jd ?> type="radio" name="jawaban<?=$v->sd_detailid?>" value="<?=$d[1] ?>" class="ds" onchange="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$d[1];?>','<?=$idx ?>')"></td>
														<td colspan="1"><?=$d[0] ?></td>
													</tr>
												</table>
											</div>

											<?php if ($v->ud_akhir==1): ?>
												<?php $akhir=1; ?>
											<script type="text/javascript">

												$('.soal').css('display','none')
												//$('#soal-'+<?=$idx-1 ?>).attr("style", "display:none")
												$('#soal-'+<?=$idx ?>).attr("style", "display:block")
											</script>
											<?php endif ?>



											<?php
											$idx++;
											$nop++;
										endforeach ?>

									<?php endif?>

									<?php if(count($bs)>0): ?>

										<div class="soal" <?=$yes ?> id="soal-<?=$idx?>" data-id="<?=$idx ?>" >
											<h3 style="text-align: center;">Anda Masuk Soal Benar / Salah</h3>
										</div>
										<!-- pernyataan benarsalah -->
										<?php 
										$idx++;
										$nobs=1;
										foreach ($bs as $key => $v): ?>
											<?php 
											if($idx==1){
												$yes='style="display: block;"';
											}else{
												$yes='';
											}
											?>

											<div class="soal" <?=$yes ?> id="soal-<?=$idx?>" data-id="<?=$idx ?>" >
												<table class="table" width="100%">
													<?php  

													$a=explode("===",$v->ud_a);
													$b=explode("===",$v->ud_b);

													$ja='';
													$jb='';
													if(strtolower($a[1])==strtolower($v->ud_jawaban)){
															$ja='checked="checked"';
													}
													if(strtolower($b[1])==strtolower($v->ud_jawaban)){
															$jb='checked="checked"';
													}
												

													?>
													<tr>
														<td style="width: 0.5em">
															<input type="hidden" name="type_bs<?=$v->sd_detailid;?>" value="bn">
															<input type="hidden" name="ud_master_soal_bs<?=$v->sd_detailid;?>" value="<?=$v->ud_master_soal; ?>">
															<input type="hidden" name="ud_detailid_bs<?=$v->sd_detailid;?>" value="<?=$v->ud_detailid; ?>">

															<?=$nobs;?>

														</td>
														<td colspan="3">
															<?=$v->sd_soal;?>
															<input type="hidden" name="soal_bs<?=$v->sd_detailid;?>" value="<?=$v->sd_soal ?>">
														</td>
													</tr>
													<tr>
														<td></td>
														<td style="width: 0.5em">

														</td>
														<td style="width: 0.5em">
															<input <?=$ja?> onchange="setjawaban('bs','<?=$v->sd_detailid?>','<?=$a[1];?>','<?=$idx?>')" type="radio" name="jawaban_bs<?=$v->sd_detailid;?>" value="<?=$a[1]?>" class="ds"></td>
															<td colspan="1"><?=$a[0];?></td>
															<tr> 
																<td></td><td></td>
																<td style="width: 0.5em">
																	<input <?=$jb?> onchange="setjawaban('bs','<?=$v->sd_detailid?>','<?=$b[1];?>','<?=$idx?>')"  type="radio" name="jawaban_bs<?=$v->sd_detailid?>" value="<?=$b[1]?>" class="ds"></td>
																<td colspan="1"><?=$b[0];?></td>
															</tr></tr>


														</table>

													</div>	

													<?php if ($v->ud_akhir==1): ?>
														<?php $akhir=1; ?>
											<script type="text/javascript">

												$('.soal').css('display','none')
												//$('#soal-'+<?=$idx-1 ?>).attr("style", "display:none")
												$('#soal-'+<?=$idx ?>).attr("style", "display:block")
											</script>
											<?php endif ?>



											
													<?php
													$idx++;
													$nobs++;
												endforeach ?>


											<?php endif ?>



											<?php if(count($esai)): ?>
												<div class="soal" <?=$yes ?> id="soal-<?=$idx?>" data-id="<?=$idx ?>" >
													<h3 style="text-align: center;">Anda Masuk Soal Esai</h3>
												</div>


												<!-- pernyataan benarsalah -->
												<?php 
												$idx++;
												$nobs=1;
												foreach ($esai as $key => $v): ?>

													<?php 
													if($idx==1){
														$yes='style="display: block;"';
													}else{
														$yes='';
													}
													?>

													<div class="soal" <?=$yes ?> id="soal-<?=$idx?>" data-id="<?=$idx ?>" >
														<table class="table" width="100%">
															<tr>
																<td style="width: 0.5em">
																	<input type="hidden" name="type_bs<?=$v->sd_detailid;?>" value="bn">
																	<input type="hidden" name="ud_master_soal_esai<?=$v->sd_detailid;?>" value="<?=$v->ud_master_soal; ?>">
																	<input type="hidden" name="ud_detailid_esai<?=$v->sd_detailid;?>" value="<?=$v->ud_detailid; ?>">

																	<?=$nobs;?>

																</td>
																<td colspan="3">
																	<?=$v->sd_soal;?>
																	<input type="hidden" name="soal_esai<?=$v->sd_detailid;?>" value="<?=$v->sd_soal ?>">
																</td>
															</tr>
															<tr>
																<td colspan="2"><textarea class="form-control" onKeyUp='textCounter(this)' wrap='physical' rows='1' cols='60' class="ds" name="jawaban_esai<?=$v->sd_detailid;?>"><?=$v->ud_jawaban;?></textarea>

																<button class="btn btn-xs btn-primary" type="button" onclick="setjawaban('esai','<?=$v->sd_detailid?>','<?=$a[1];?>','<?=$idx?>')" >Simpan</button>
															</td>
															</tr>
															

														</table>

													</div>	


											<?php if ($v->ud_akhir==1): ?>
												<?php $akhir=1; ?>
											<script type="text/javascript">

												$('.soal').css('display','none')
												//$('#soal-'+<?=$idx-1 ?>).attr("style", "display:none")
												$('#soal-'+<?=$idx ?>).attr("style", "display:block")
											</script>
											<?php endif ?>




													<?php
													$idx++;
													$nobs++;
												endforeach ?>


											<?php endif ?>





											<table class="table" width="100px">
												<td>	
													<button type="button" class="back btn-sm btn btn-danger">Back</button>
												
													<button type="button" class="next btn-sm btn btn-danger">Next</button>
												</td>
											</table>

										
											<br>
											<br>
										</div>

										<div class="end" data-id="<?=$idx?>">
											<p>Congratulation! You are done!</p>
											<button type="button" class="btn btn-xs btn-success edit-previous">Edit</button>
											<button type="button" class="btn btn-xs btn-primary" onclick="selesai()">Selesai</button>
										</div>
										







										














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



	<script type="text/javascript">
		$(document).ready(function() {
              /** Membuat Waktu Mulai Hitung Mundur Dengan 
                * var detik = 0,
                * var menit = 1,
                * var jam = 1
                */
                $dat="<?=$master->sisa ?>";
                $a=$dat.split(":");

                if($a.length>0){
                	if($a.length==3){
                		var detik = $a[2];
                		var menit = $a[1];
                		var jam   = $a[0]
                	}
                	else if($a.length==2){
                		var detik = $a[1];
                		var menit = $a[0];
                		var jam   = 0
                	}
                	else if($a.length==1){
                		var detik = $a[0];
                		var menit = 0;
                		var jam   = 0
                	}
                }

             /**
               * Membuat function hitung() sebagai Penghitungan Waktu
               */
               function hitung() {
                /** setTimout(hitung, 1000) digunakan untuk 
                    * mengulang atau merefresh halaman selama 1000 (1 detik) 
                    */
                    setTimeout(hitung,1000);

                    /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
                    if(menit < 10 && jam == 0){
                    	var peringatan = 'style="color:red"';
                    };
                    if(menit <0 || jam < 0 || detik<0){
                    	var peringatan = 'style="color:red"';
                    	$('#countdown').html(
                    		'<h1 align="center"'+peringatan+'>Sisa waktu anda <br />0 jam : 0 menit : 0 detik</h1><hr>'
                    		);
                    	 location.reload()
                    }else{

                    	/** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
                    	$('#countdown').html(
                    		'<h1 align="center"'+peringatan+'>Sisa waktu anda <br />' + jam + ' jam : ' + menit + ' menit : ' + detik + ' detik</h1><hr>'
                    		);
                    }

                    /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
                    detik --;

                /** Jika var detik < 0
                    * var detik akan dikembalikan ke 59
                    * Menit akan Berkurang 1
                    */
                    if(detik < 0) {
                    	detik = 59;
                    	menit --;

                    /** Jika menit < 0
                        * Maka menit akan dikembali ke 59
                        * Jam akan Berkurang 1
                        */
                        if(menit < 0) {
                        	menit = 59;
                        	jam --;

                        /** Jika var jam < 0
                            * clearInterval() Memberhentikan Interval dan submit secara otomatis
                            */
                            if(jam < 0) {                                                                 
                            	clearInterval();  
                            } 
                        } 
                    } 
                }           
                /** Menjalankan Function Hitung Waktu Mundur */
                hitung();
            }); 
      // ]]>
  </script>




   <style type="text/css">
  	.soal {
  		display: none;
  	}
  	button {
  		margin-top: 30px;
  	}

  	.back {
  		display: none;
  	}
  	.next {
  		margin-left: 50px;
  	}
  	.end {
  		display: none;
  	}

  </style> 


  <script type="text/javascript">
  	$('body').on('click', '.next', function() { 
  		var id = $('.soal:visible').data('id');
  		var nextId = $('.soal:visible').data('id')+1;
  		$('[data-id="'+id+'"]').hide();
  		$('[data-id="'+nextId+'"]').show();

  		if($('.back:hidden').length == 1){
  			$('.back').show();
  		}
  		

  		if(nextId == "<?=$idx ?>"){
  			$('.content-holder').hide();
  			$('.end').show();
  		}
  	});

  	$('body').on('click', '.back', function() { 

  		var id = $('.soal:visible').data('id');
  		var prevId = $('.soal:visible').data('id')-1;
  		$('[data-id="'+id+'"]').hide();
  		$('[data-id="'+prevId+'"]').show();

  		if(prevId == 1){
  			$('.back').hide();
  		}    
  	});
  	$('body').on('click', '.edit-previous', function() { 
  		$('.end').hide();
  		$('.content-holder').show();
  		$('#soal-<?=$idx-1 ?>').show();

  	});
  </script> 
  <!-- jawab -->
  <script type="text/javascript">
  	function setjawaban(type,no,jawaban,$idx){  		
  		if(type=='pilihan'){
  		var ud_master_soal= $('input[name="ud_master_soal'+no+'"]').val();
  		var ud_detailid= $('input[name="ud_detailid'+no+'"]').val();
  		}
  		if(type=='bs'){
  		var ud_master_soal= $('input[name="ud_master_soal_bs'+no+'"]').val();
  		var ud_detailid= $('input[name="ud_detailid_bs'+no+'"]').val();
  		}
  		if(type=='esai'){
  		var ud_master_soal= $('input[name="ud_master_soal_esai'+no+'"]').val();
  		var ud_detailid= $('input[name="ud_detailid_esai'+no+'"]').val();
  		var jawaban= $('textarea[name="jawaban_esai'+no+'"]').val();
  		}
  		
  		var data={'ud_master_soal':ud_master_soal,
  		'ud_detailid':ud_detailid,
  		'ud_jawaban':jawaban,
  		'tipe':type,
  		'u_id':"<?=$id_ujian ?>",
  	}
  	$.ajax({
  		url : '<?php echo base_url("panel/ujian/save_per_soal/".$id); ?>',
  		type: "POST",
  		data:data,

						dataType: 'json',
						success:function(data, textStatus, jqXHR){
							
							if(data.status==true){
								var id = $idx
								var nextId = parseInt($idx)+1;
								$('[data-id="'+id+'"]').hide();
								$('[data-id="'+nextId+'"]').show();

								if($('.back:hidden').length == 1){
									$('.back').show();
								}

								if(nextId == "<?=$idx; ?>"){

									$('.content-holder').hide();
									$('.end').show();
								}
							}else if(data.status==false){	
								$().toastmessage('showToast', {
									text     : data.info,
									position : 'top-center',
									type     : 'error',
								});	

		if(type=='pilihan'){		
  		$("input[name='jawaban"+ud_detailid+"']").prop('checked', false);			
  		}
  		if(type=='bs'){
  		$("input[name='jawaban_bs"+ud_detailid+"']").prop('checked', false);	
  		}
  		if(data.info=="Waktu Sudah Habis"){
  			location.reload();
  		}
  		/*if(type=='esai'){
  		ud_detailid
  		$("#form_soal input[name='kunci'][value='"+data.pilihan.sd_kunci.toLowerCase()+"']").prop('checked', true);							
  		}*/
  		

							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');

		if(type=='pilihan'){		
  		$("input[name='jawaban"+ud_detailid+"']").prop('checked', false);			
  		}
  		if(type=='bs'){
  		$("input[name='jawaban_bs"+ud_detailid+"']").prop('checked', false);	
  		}
						}
					});


  }



  function selesai(){  		
  	$.ajax({
  		url : '<?php echo base_url("panel/ujian/selesai/".$id_ujian); ?>',
  		type: "POST",
  		//data:d,
		dataType: 'json',
						success:function(data, textStatus, jqXHR){
if(data==true){
	location.reload();
}

						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
						}
					});
  }
</script>


											<?php if ($akhir==1): ?>
												
											<script type="text/javascript">
												
												$('.back').show();
												
											</script>
											<?php endif ?>


<?php endif ?>