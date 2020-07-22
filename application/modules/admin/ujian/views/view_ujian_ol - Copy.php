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
									<td>
										<div class=""> 
											<div class="col-md-2" style="padding: 0px 0px 0px 0px"> 
												<input type="text" class="form-control" name="level" value="<?=$master->level ?>">
											</div>
											<div class="col-md-2"> 
												<input type="text" class="form-control" name="level" value="<?=$master->ms_kelas ?>">
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Jenis Ujian</td>
									<td>
										<input type="text" class="form-control" name="jenis" value="<?=$master->ms_jenis_ujian ?>">

									</td>
								</tr>

								<tr>
									<td>Mata Kuliah</td>
									<td>
										<input type="text" class="form-control" name="level" value="<?=$master->subject_ar_name ?>">

									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td>
										<input type="hidden" name="jk" id="jk">
										<ul class="nav nav-pills">			
											<?php if($master->ms_jenis_kel=='L'): ?>
												<li class="active"><a data-toggle="tab" class="btn" onclick="jeniskelamin('L')"><i class="fa fa-male"></i></a></li>
											<?php endif ?>
											<?php if($master->ms_jenis_kel=='P'): ?>
												<li class="active"><a data-toggle="tab" class="btn" onclick="jeniskelamin('P')"><i class="fa fa-female"></i></a></li>											
											<?php endif ?>
										</ul>
									</td>
								</tr>	

								<tr>
									<td>Tanggal</td>
									<td>


										<div class="form-group">					            
											<div class="col-sm-12  col-xs-12">
												<div class="input-group">
													<input type="text" name="date_range" id="date_range" class="form-control">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
												<span class="info"></span>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										Waktu Pelaksanaan
									</td>
									<td>												<div class="form-group">
										<div class="col-sm-12  col-xs-12">
											<div class="row">
												<input class="form-control" type="" name="" value="<?=date('d-m-Y',strtotime($master->ms_startdate)).' '.$master->ms_starttime.' / '.date('d-m-Y',strtotime($master->ms_startdate)).' '.$master->ms_starttime ?>">
											</div>
											<span class="info"></span>
										</div>
									</div>

								</td>
							</tr>	            		
						</table>
					</div>	            	
					<div class="box-footer">
						<div class="col-md-2 col-sm-offset-10">
							<button id = "enter" class="btn btn-primary pull-right ds" type="submit" >Simpan</button>
							<a href="<?php echo base_url('panel/bank_soal'); ?>" class="btn btn-default">Kembali</a>
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

								<input type="hidde" name="jenis1" value="<?=count($pilihan) ?>">
								<input type="hidde" name="jenis2" value="<?=count($bs) ?>">
								<input type="hidde" name="jenis3" value="<?=count($esai) ?>">
								<table class="table" width="100%">
									<?php foreach ($pilihan as $key => $v): ?>
										<?php  
											$a=explode("===",$v->ud_a);
											$b=explode("===",$v->ud_b);
											$c=explode("===",$v->ud_c);
											$d=explode("===",$v->ud_d);
											
										; ?>
										<tr>
											<td style="width: 0.5em">
												<input type="hidden" name="type<?=$v->sd_no;?>" value="pilihan">
												<input type="hidden" name="ud_master_soal<?=$v->sd_no;?>" value="<?=$v->ud_master_soal; ?>">
												<input type="hidden" name="ud_detailid<?=$v->sd_no;?>" value="<?=$v->ud_detailid; ?>">
												
												<?=$v->sd_no;?>
												
											</td>
											<td colspan="3">
												<?=$v->sd_soal;?>
												<input type="hidden" name="soal<?=$v->sd_no;?>" value="<?=$v->sd_soal ?>">
											</td>
										</tr>
										
										<tr>
											<td></td>
											<td style="width: 0.5em">
												a.
											</td>
											<td style="width: 0.5em">
												<input type="radio" name="jawaban<?=$v->sd_no;?>" value="<?=$a[1]; ?>" class="ds">
											</td>
											<td colspan="1"><?=$a[0]?></td>
										</tr>
										<tr> 
											<td></td>
											<td>b.</td>
											<td style="width: 0.5em"><input class="ds" type="radio" name="jawaban<?=$v->sd_no?>" value="<?=$b[1]?>" ></td>
											<td colspan="1"><?=$b[0];?></td>
										</tr>
										<tr>
											<td></td>
											<td>c.</td>
											<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v->sd_no?>" value="<?=$c[1] ?>" class="ds" ></td>
											<td colspan="1"><?=$c[0] ?></td>
										</tr>
										<tr> 
											<td></td><td>d.</td>
											<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v->sd_no?>" value="<?=$d[1] ?>" class="ds" ></td>
											<td colspan="1"><?=$d[0] ?></td>
										</tr>
									<?php endforeach ?>
								</table>







								<div class="alert alert-info" role="alert">Benar / Salah<div class="pull-right nilai_bs"></div></div>
								<table class="table" width="100%">
									<?php foreach ($bs as $key => $v): ?>
										<?php  

											$a=explode("===",$v->ud_a);
											$b=explode("===",$v->ud_b);

										 ?>
										<tr>
											<td style="width: 0.5em">
												<input type="hidden" name="type_bs<?=$v->sd_no;?>" value="bn">
												<input type="hidden" name="ud_master_soal_bs<?=$v->sd_no;?>" value="<?=$v->ud_master_soal; ?>">
												<input type="hidden" name="ud_detailid_bs<?=$v->sd_no;?>" value="<?=$v->ud_detailid; ?>">

												<?=$v->sd_no;?>

											</td>
											<td colspan="3">
												<?=$v->sd_soal;?>
												<input type="hidden" name="soal_bs<?=$v->sd_no;?>" value="<?=$v->sd_soal ?>">
											</td>
										</tr>
										<tr>
											<td></td>
											<td style="width: 0.5em">

											</td>
											<td style="width: 0.5em">
												<input type="radio" name="jawaban_bs<?=$v->sd_no;?>" value="<?=$a[1]?>" class="ds"></td>
												<td colspan="1"><?=$a[0];?></td>
												<tr> 
													<td></td><td></td>
													<td style="width: 0.5em"><input type="radio" name="jawaban_bs<?=$v->sd_no?>" value="<?=$b[1]?>" class="ds"></td>
													<td colspan="1"><?=$b[0];?></td>
												</tr></tr>

											<?php endforeach ?>

										</table>





										<div class="alert alert-info" role="alert">Esai</div>
										<!-- <div>Esai</div> -->
										<table class="table" width="100%">
											<?php foreach ($esai as $key => $v): ?>

												<tr>
													<td style="width: 0.5em">
														<input type="hidden" name="type_esai<?=$v->sd_no;?>" value="esai">
														<input type="hidden" name="ud_master_soal_es<?=$v->sd_no;?>" value="<?=$v->ud_master_soal; ?>">
														<input type="hidden" name="ud_detailid_es<?=$v->sd_no;?>" value="<?=$v->ud_detailid; ?>">

														<?=$v->sd_no;?>
													</td>
													<td colspan="3">
														<?=$v->sd_soal;?>
														<input type="hidden" name="soal_es<?=$v->sd_no;?>" value="<?=$v->sd_soal ?>">
													</td>
												</tr>
												<tr>
													<td colspan="2"><textarea class="form-control" onKeyUp='textCounter(this)' wrap='physical' rows='1' cols='60' class="ds"></textarea></td>
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



	<script type="text/javascript">
		$(document).ready(function() {
              /** Membuat Waktu Mulai Hitung Mundur Dengan 
                * var detik = 0,
                * var menit = 1,
                * var jam = 1
                */
                $dat="<?=$master->ms_waktu ?>";
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