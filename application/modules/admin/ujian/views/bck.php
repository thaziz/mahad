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
										<?=$master->ms_startdate.' - '.$master->ms_enddate?>
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



<?php

$audio='';
	$gambar='';
	if($v->sd_audio!=''){
		$audio='<audio controls><source src="'.base_url().$v->sd_audio.'" type="audio/wav">'.
		'Your browser does not support the audio element.'.
		'</audio><br>';
	}


	if($v->sd_gambar!=''){
		$gambar='<img width="300px" height="300px" src="'.base_url().$v->sd_gambar.'">';
	}


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





				<div class="modal-dialog  modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <table class="table" width="100%">
            <tr>
            	<td colspan="2">
            	<?=$v->sd_header;?>
            	</td>
            </tr>
            <tr>
            	<td colspan="2">
            	<?=$v->sd_subheader;?>
            	</td>
            </tr>
            <tr>
            	<td colspan="2">
            	<?=$v->sd_cerita;?>
            	</td>
            </tr>
             <tr>
            	<td colspan="2">
            	<?=$gambar;?>
            	</td>
            </tr>

             <tr>
            	<td colspan="2">
            	<?=$audio;?>
            	</td>
            </tr>
          	<tr>
														<td style="width: 0.5em">
														
<input type="hidden" name="type<?=$v->sd_detailid;?>" value="pilihan">
															<input type="hidden" name="ud_master_soal<?=$v->sd_detailid;?>" value="<?=$v->ud_master_soal; ?>">
															<input type="hidden" name="ud_detailid<?=$v->sd_detailid;?>" value="<?=$v->ud_detailid; ?>">

															<span class="label label-warning" id="qid"><?=$nop;?>

														</td>
														<td colspan="3">
															<?=$v->sd_soal;?>
															<input type="hidden" name="soal<?=$v->sd_detailid;?>" value="<?=$v->sd_soal ?>">
														</td>
													</tr>
									</table>
        </div>
        <div class="modal-body">
            <div class="col-xs-3 col-xs-offset-5">
               <div id="loadbar" style="display: none;">
                  <div class="blockG" id="rotateG_01"></div>
                  <div class="blockG" id="rotateG_02"></div>
                  <div class="blockG" id="rotateG_03"></div>
                  <div class="blockG" id="rotateG_04"></div>
                  <div class="blockG" id="rotateG_05"></div>
                  <div class="blockG" id="rotateG_06"></div>
                  <div class="blockG" id="rotateG_07"></div>
                  <div class="blockG" id="rotateG_08"></div>
              </div>
          </div>

          <div class="quiz" id="quiz" data-toggle="buttons">



           <label onclick="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$a[1];?>','<?=$idx?>')"  class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
           	<input <?=$ja?> type="radio"  name="jawaban<?=$v->sd_detailid;?>" value="<?=$a[1]; ?>" class="ds">
           	a. <?=$a[0]?>
          </label>
           
          <label onclick="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$b[1];?>','<?=$idx?>')" class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
           	<input <?=$jb?> type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$b[1]; ?>" class="ds">
           	b. <?=$b[0]?>
          </label>
 
          <label onclick="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$c[1];?>','<?=$idx?>')" class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
           	<input <?=$jc?> type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$c[1]; ?>" class="ds">
           	c. <?=$c[0]?>
          </label>

          <label onclick="setjawaban('pilihan','<?=$v->sd_detailid?>','<?=$d[1];?>','<?=$idx?>')" class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
           	<input <?=$jd?> type="radio" name="jawaban<?=$v->sd_detailid;?>" value="<?=$d[1]; ?>" class="ds">
           	d. <?=$d[0]?>
          </label>

          
       </div>



						

   </div>
   <div class="modal-footer text-muted">
    <span id="answer"></span>
</div>
</div>
</div>



											</div>

											<?php if ($v->ud_akhir==1): ?>
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







											<button type="button" class="back btn-xs btn btn-danger">Back</button>
											<button type="button" class="next btn-xs btn btn-danger">Next</button>
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

						//dataType: 'json',
						success:function(data, textStatus, jqXHR){


							var id = $idx
							var nextId = parseInt($idx)+1;
							alert(nextId);
							$('[data-id="'+id+'"]').hide();
							$('[data-id="'+nextId+'"]').show();

							if($('.back:hidden').length == 1){
								$('.back').show();
							}

							if(nextId == "<?=$idx; ?>"){

								$('.content-holder').hide();
								$('.end').show();
							}
							/*//$('.ds').attr('disabled',true)	
							if(!data.status){
								$.each(data.e, function(key, val){
									$('[name="'+key+'"] + .info').html(val);
									$('#'+key).html(val);

								});
							}else{	
								

							}*/
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
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


						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Error,something goes wrong');
						}
					});
  }
</script>


<?php endif ?>




<style type="text/css">
	#qid {
  padding: 10px 15px;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 20px;
}
label.btn {
    padding: 18px 60px;
    white-space: normal;
    -webkit-transform: scale(1.0);
    -moz-transform: scale(1.0);
    -o-transform: scale(1.0);
    -webkit-transition-duration: .3s;
    -moz-transition-duration: .3s;
    -o-transition-duration: .3s
}

label.btn:hover {
    text-shadow: 0 3px 2px rgba(0,0,0,0.4);
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -o-transform: scale(1.1)
}
label.btn-block {
    text-align: left;
    position: relative
}

label .btn-label {
    position: absolute;
    left: 0;
    top: 0;
    display: inline-block;
    padding: 0 10px;
    background: rgba(0,0,0,.15);
    height: 100%
}

label .glyphicon {
    top: 34%
}
.element-animation1 {
    animation: animationFrames ease .8s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease .8s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease .8s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation2 {
    animation: animationFrames ease 1s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation3 {
    animation: animationFrames ease 1.2s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1.2s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1.2s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation4 {
    animation: animationFrames ease 1.4s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1.4s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1.4s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
@keyframes animationFrames {
    0% {
        opacity: 0;
        transform: translate(-1500px,0px)
    }

    60% {
        opacity: 1;
        transform: translate(30px,0px)
    }

    80% {
        transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        transform: translate(0px,0px)
    }
}

@-webkit-keyframes animationFrames {
    0% {
        opacity: 0;
        -webkit-transform: translate(-1500px,0px)
    }
    60% {
        opacity: 1;
        -webkit-transform: translate(30px,0px)
    }

    80% {
        -webkit-transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        -webkit-transform: translate(0px,0px)
    }
}

@-ms-keyframes animationFrames {
    0% {
        opacity: 0;
        -ms-transform: translate(-1500px,0px)
    }

    60% {
        opacity: 1;
        -ms-transform: translate(30px,0px)
    }
    80% {
        -ms-transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        -ms-transform: translate(0px,0px)
    }
}

.modal-header {
    background-color: transparent;
    color: inherit
}

.modal-body {
    min-height: 205px
}
#loadbar {
    position: absolute;
    width: 62px;
    height: 77px;
    top: 2em
}
.blockG {
    position: absolute;
    background-color: #FFF;
    width: 10px;
    height: 24px;
    -moz-border-radius: 8px 8px 0 0;
    -moz-transform: scale(0.4);
    -moz-animation-name: fadeG;
    -moz-animation-duration: .8800000000000001s;
    -moz-animation-iteration-count: infinite;
    -moz-animation-direction: linear;
    -webkit-border-radius: 8px 8px 0 0;
    -webkit-transform: scale(0.4);
    -webkit-animation-name: fadeG;
    -webkit-animation-duration: .8800000000000001s;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-direction: linear;
    -ms-border-radius: 8px 8px 0 0;
    -ms-transform: scale(0.4);
    -ms-animation-name: fadeG;
    -ms-animation-duration: .8800000000000001s;
    -ms-animation-iteration-count: infinite;
    -ms-animation-direction: linear;
    -o-border-radius: 8px 8px 0 0;
    -o-transform: scale(0.4);
    -o-animation-name: fadeG;
    -o-animation-duration: .8800000000000001s;
    -o-animation-iteration-count: infinite;
    -o-animation-direction: linear;
    border-radius: 8px 8px 0 0;
    transform: scale(0.4);
    animation-name: fadeG;
    animation-duration: .8800000000000001s;
    animation-iteration-count: infinite;
    animation-direction: linear
}
#rotateG_01 {
    left: 0;
    top: 28px;
    -moz-animation-delay: .33s;
    -moz-transform: rotate(-90deg);
    -webkit-animation-delay: .33s;
    -webkit-transform: rotate(-90deg);
    -ms-animation-delay: .33s;
    -ms-transform: rotate(-90deg);
    -o-animation-delay: .33s;
    -o-transform: rotate(-90deg);
    animation-delay: .33s;
    transform: rotate(-90deg)
}
#rotateG_02 {
    left: 8px;
    top: 10px;
    -moz-animation-delay: .44000000000000006s;
    -moz-transform: rotate(-45deg);
    -webkit-animation-delay: .44000000000000006s;
    -webkit-transform: rotate(-45deg);
    -ms-animation-delay: .44000000000000006s;
    -ms-transform: rotate(-45deg);
    -o-animation-delay: .44000000000000006s;
    -o-transform: rotate(-45deg);
    animation-delay: .44000000000000006s;
    transform: rotate(-45deg)
}
#rotateG_03 {
    left: 26px;
    top: 3px;
    -moz-animation-delay: .55s;
    -moz-transform: rotate(0deg);
    -webkit-animation-delay: .55s;
    -webkit-transform: rotate(0deg);
    -ms-animation-delay: .55s;
    -ms-transform: rotate(0deg);
    -o-animation-delay: .55s;
    -o-transform: rotate(0deg);
    animation-delay: .55s;
    transform: rotate(0deg)
}
#rotateG_04 {
    right: 8px;
    top: 10px;
    -moz-animation-delay: .66s;
    -moz-transform: rotate(45deg);
    -webkit-animation-delay: .66s;
    -webkit-transform: rotate(45deg);
    -ms-animation-delay: .66s;
    -ms-transform: rotate(45deg);
    -o-animation-delay: .66s;
    -o-transform: rotate(45deg);
    animation-delay: .66s;
    transform: rotate(45deg)
}
#rotateG_05 {
    right: 0;
    top: 28px;
    -moz-animation-delay: .7700000000000001s;
    -moz-transform: rotate(90deg);
    -webkit-animation-delay: .7700000000000001s;
    -webkit-transform: rotate(90deg);
    -ms-animation-delay: .7700000000000001s;
    -ms-transform: rotate(90deg);
    -o-animation-delay: .7700000000000001s;
    -o-transform: rotate(90deg);
    animation-delay: .7700000000000001s;
    transform: rotate(90deg)
}
#rotateG_06 {
    right: 8px;
    bottom: 7px;
    -moz-animation-delay: .8800000000000001s;
    -moz-transform: rotate(135deg);
    -webkit-animation-delay: .8800000000000001s;
    -webkit-transform: rotate(135deg);
    -ms-animation-delay: .8800000000000001s;
    -ms-transform: rotate(135deg);
    -o-animation-delay: .8800000000000001s;
    -o-transform: rotate(135deg);
    animation-delay: .8800000000000001s;
    transform: rotate(135deg)
}
#rotateG_07 {
    bottom: 0;
    left: 26px;
    -moz-animation-delay: .99s;
    -moz-transform: rotate(180deg);
    -webkit-animation-delay: .99s;
    -webkit-transform: rotate(180deg);
    -ms-animation-delay: .99s;
    -ms-transform: rotate(180deg);
    -o-animation-delay: .99s;
    -o-transform: rotate(180deg);
    animation-delay: .99s;
    transform: rotate(180deg)
}
#rotateG_08 {
    left: 8px;
    bottom: 7px;
    -moz-animation-delay: 1.1s;
    -moz-transform: rotate(-135deg);
    -webkit-animation-delay: 1.1s;
    -webkit-transform: rotate(-135deg);
    -ms-animation-delay: 1.1s;
    -ms-transform: rotate(-135deg);
    -o-animation-delay: 1.1s;
    -o-transform: rotate(-135deg);
    animation-delay: 1.1s;
    transform: rotate(-135deg)
}
@-moz-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-webkit-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-ms-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-o-keyframes fadeG {
    0% {
        background-color: #000
    }
    100% {
        background-color: #FFF
    }
}

@keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

</style>


<script type="text/javascript">
	

	$(function(){
    var loading = $('#loadbar').hide();
    $(document)
    .ajaxStart(function () {
        loading.show();
    }).ajaxStop(function () {
    	loading.hide();
    });
    
    $("label.btn").on('click',function () {
    	var choice = $(this).find('input:radio').val();
    	
    	$('#loadbar').show();
    	$('#quiz').fadeOut();
    	setTimeout(function(){
           $( "#answer" ).html(  $(this).checking(choice) );      
            $('#quiz').show();
            $('#loadbar').fadeOut();
    	}, 1500);
    });

    $ans = 3;

    $.fn.checking = function(ck) {
        if (ck != $ans)
            return 'INCORRECT';
        else 
            return 'CORRECT';
    }; 
});	

</script>

