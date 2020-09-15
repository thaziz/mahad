<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
							<input type="" name="id_master" id="master" value="74">
							<table width="100%" class="table">
								<td>Nama Dosen</td>
								<td><input class="form-control" type="" name="" value="<?=$this->session->userdata('name')?>"></td>
								<tr> 
									<td>Kelas</td>
									<td>
										<div class=""> 
											<div class="col-md-2" style="padding: 0px 0px 0px 0px"> 
												<select class="form-control" name="level">
													<option>1</option>	
													<option>2</option>	
													<option>3</option>	
												</select>
											</div>
											<div class="col-md-2"> 
												<select class="form-control" name="kelas">
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
										<select class="form-control" name="jenis">
											<option>UTS</option>	
											<option>UAS</option>	
										</select>

									</td>
								</tr>

								<tr>
									<td>Mata Kuliah</td>
									<td>
										<select class="form-control" name="matkul">
											<?php foreach ($matkul as $key => $v): ?>
												<option value="<?=$v->id?>"><?=$v->nama ?></option>	
											<?php endforeach ?>
										</select>

									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td>
										<input type="hidden" name="jk" id="jk">
										<ul class="nav nav-pills">			
											<li><a data-toggle="tab" class="btn" onclick="jeniskelamin('L')"><i class="fa fa-male"></i></a></li>
											<li><a data-toggle="tab" class="btn" onclick="jeniskelamin('P')"><i class="fa fa-female"></i></a></li>
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
										Jam
									</td>
									<td>												<div class="form-group">

										<div class="col-sm-12  col-xs-12">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<div class="input-group">
														<input type="text" name="stime_perday" class="form-control timepicker">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-6">
													<div class="input-group">
														<input type="text" name="etime_perday" class="form-control timepicker">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>
												</div>
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
							<button id = "enter" class="btn btn-primary pull-right" type="submit">Simpan</button>
							<a href="<?php echo base_url('panel/bank_soal'); ?>" class="btn btn-default">Kembali</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>




<section class="content" id="detail" style="display: ">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
		            <form class="form-horizontal" method="post" id="admin_form">
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
		            								<form id="importformxxxxxx" method="post" enctype="multipart/form-data">
		            									<div class="form-group">
		            										<div class="input-group">
		            											<input type="file" name="file" id="input-file" class="form-control">
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

		            						<table class="table borderless" width="100%">
		            							<tbody id="body_soal"> 
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

		            						<table class="table borderless" width="100%">
		            							<tbody id="body_soal_bn"> 
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
							<table class="table">
								<tr>
									<td>Soal</td>
									<td colspan="2"><textarea class="form-control" name="soal"></textarea><input type="hidden" name="jenis" value="pilihan"></td>								
								</tr>
								<tr>
									<td>Upload file</td>
									<td colspan="2"><input type="file" name="berkas"></td>								
								</tr>
							</table>
							<table class="table">
								<tr>
									<th>-</th>
									<th width="10%">Kunci Jawaban</th>
									<th>Jawaban</th>
								</tr>

								<tr>
									<td>A.</td>       				
									<td><input type="radio" name="kunci" value="a"></td>
									<td><input type="text" name="a" class="form-control"></td>
								</tr>
								<tr>
									<td>B.</td>       				
									<td><input type="radio" name="kunci" value="b"></td>
									<td><input type="text" name="b" class="form-control"></td>
								</tr>
								<tr>
									<td>C.</td>       				
									<td><input type="radio" name="kunci" value="c"></td>
									<td><input type="text" name="c" class="form-control"></td>
								</tr>       			
								<tr>
									<td>D.</td>       				
									<td><input type="radio" name="kunci" value="d"></td>
									<td><input type="text" name="d" class="form-control"></td>
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
									<td colspan="2"><textarea class="form-control" name="soal"></textarea><input type="hidden" name="jenis" value="bn"></td>								
								</tr>
								<tr>
									<td>Upload file</td>
									<td colspan="2"><input type="file" name="berkas"></td>								
								</tr>
							</table>
							<table class="table">
								<tr>
									<th>-</th>
									<th width="10%">Kunci Jawaban</th>
									<th>Jawaban</th>
								</tr>

								<tr>
									<td></td>       				
									<td><input type="radio" name="kunci" value="a"></td>
									<td><input type="text" name="a" class="form-control"></td>
								</tr>
								<tr>
									<td></td>       				
									<td><input type="radio" name="kunci" value="b"></td>
									<td><input type="text" name="b" class="form-control"></td>
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
									<td colspan="2"><textarea class="form-control" name="soal"></textarea><input type="hidden" name="jenis" value="esai"></td>								
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

			$('form#form_soal').on('submit', function(e) {
				e.preventDefault();	
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
									$('[name="'+key+'"] + .info').html(val);
									$('#'+key).html(val);

								});
							}else{	
								$audio='';
								if(data.soal.sd_audio!=''){
									$audio='<audio controls>'+
									'<source src="<?=base_url() ?>'+data.soal.sd_audio+'" type="audio/wav">'+
									'Your browser does not support the audio element.'+
									'</audio><br>';
								}

								html='';
								$a='';
								$b='';
								$c='';
								$d='';
								if(data.soal.sd_kunci=='a'){
									$a='checked="checked"';
								}
								if(data.soal.sd_kunci=='b'){
									$b='checked="checked"';
								}
								if(data.soal.sd_kunci=='c'){
									$c='checked="checked"';
								}
								if(data.soal.sd_kunci=='d'){
									$d='checked="checked"';
								}

								if(data.soal.jenis=='pilihan'){
								html='<tr>'+
								'<td style="width: 0.5em"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_master_soal+'"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_detailid+'">'+data.soal.xx+'.</td>'+
								'<td colspan="3">'+$audio+' '+data.soal.sd_soal+'</td>'+
								'<td><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')" ><i class="fa fa-minus"></i></button><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')"><i class="fa fa-pencil"></i></button></td>'+
								'</tr>'+
								'<tr>'+
								'<td></td><td style="width: 0.5em">a.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban[]" value="a" '+$a+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_a+'</td>'+
								'<tr>'+ 
								'<td></td><td>b.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban[]" value="b" '+$b+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_b+'</td>'+
								'</tr></tr>'+
								'<tr>'+
								'<td></td><td>c.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban[]" value="c" '+$c+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_c+'</td>'+
								'</tr>'+
								'<tr> '+
								'<td></td><td>d.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban[]" value="d" '+$d+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_d+'</td>'+
								'</tr>';
								$('#body_soal').append(html)
							}

							

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


	<!-- bn js -->


	<script type="text/javascript">
		$(document).ready(function(){
			$('form#form_soal2').on('submit', function(e) {
				e.preventDefault();	
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
									$('[name="'+key+'"] + .info').html(val);
									$('#'+key).html(val);

								});
							}else{	
								$audio='';
								if(data.soal.sd_audio!=''){
									$audio='<audio controls>'+
									'<source src="<?=base_url() ?>'+data.soal.sd_audio+'" type="audio/wav">'+
									'Your browser does not support the audio element.'+
									'</audio><br>';
								}

								html='';
								$a='';
								$b='';
								$c='';
								$d='';
								if(data.soal.sd_kunci=='a'){
									$a='checked="checked"';
								}
								if(data.soal.sd_kunci=='b'){
									$b='checked="checked"';
								}
								if(data.soal.sd_kunci=='c'){
									$c='checked="checked"';
								}
								if(data.soal.sd_kunci=='d'){
									$d='checked="checked"';
								}

								html='<tr>'+
								'<td style="width: 0.5em"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_master_soal+'"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_detailid+'">'+data.soal.sd_no+'.</td>'+
								'<td colspan="3">'+$audio+' '+data.soal.sd_soal+'</td>'+
								'<td><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')" ><i class="fa fa-minus"></i></button><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')"><i class="fa fa-pencil"></i></button></td>'+
								'</tr>'+
								'<tr>'+
								'<td></td><td style="width: 0.5em">a.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban'+data.soal.sd_no+'" value="a" '+$a+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_a+'</td>'+
								'<tr>'+ 
								'<td></td><td>b.</td>'+
								'<td style="width: 0.5em"><input type="radio" name="jawaban'+data.soal.sd_no+'" value="b" '+$b+' disabled></td>'+
								'<td colspan="1">'+data.soal.sd_b+'</td>'+
								'</tr></tr>';
								$('#body_soal_bn').append(html)
							
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
									$('[name="'+key+'"] + .info').html(val);
									$('#'+key).html(val);

								});
							}else{	
								$audio='';
								if(data.soal.sd_audio!=''){
									$audio='<audio controls>'+
									'<source src="<?=base_url() ?>'+data.soal.sd_audio+'" type="audio/wav">'+
									'Your browser does not support the audio element.'+
									'</audio><br>';
								}

								html='';
								$a='';
								$b='';
								$c='';
								$d='';
								if(data.soal.sd_kunci=='a'){
									$a='checked="checked"';
								}
								if(data.soal.sd_kunci=='b'){
									$b='checked="checked"';
								}
								if(data.soal.sd_kunci=='c'){
									$c='checked="checked"';
								}
								if(data.soal.sd_kunci=='d'){
									$d='checked="checked"';
								}

								html='<tr>'+
								'<td style="width: 0.5em"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_master_soal+'"><input type="hidden" name="sd_master_soal" value="'+data.soal.sd_detailid+'">'+data.soal.sd_no+'.</td>'+
								'<td colspan="3">'+$audio+' '+data.soal.sd_soal+'</td>'+
								'<td><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')" ><i class="fa fa-minus"></i></button><button onclick="('+data.soal.sd_master_soal+','+data.soal.sd_detailid+')"><i class="fa fa-pencil"></i></button></td>'+
								'</tr>';
								$('#body_soal_esai').append(html)
							
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
								$('[name="'+key+'"] + .info').html(val);
                	//if(key=='oa_account_id')
                	$('#'+key).html(val);
                	
                });
						}else{
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

			//$('#importform').submit(function(e){
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
			      $().toastmessage('showToast', {
			          text     : 'Import data Success',
			          position : 'top-center',
			          type     : 'success',
			          close    : function () {
			            location.reload();
			          }
			      });
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