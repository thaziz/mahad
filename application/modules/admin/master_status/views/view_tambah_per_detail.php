<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php if($sd_type=='pilihan'): ?>
	<?php  
	$audio='';
	$gambar='';
	if($sd_audio!=''){
		$audio='<audio controls><source src="'.base_url().$sd_audio.'" type="audio/wav">'.
		'Your browser does not support the audio element.'.
		'</audio><br>';
	}


	if($sd_gambar!=''){
		$gambar='<img width="300px" height="300px" src="'.base_url().$sd_gambar.'">';
	}


	$html='';
	$a='';
	$b='';
	$c='';
	$d='';
	if($sd_kunci=='a'){
		$a='checked="checked"';
	}
	if($sd_kunci=='b'){
		$b='checked="checked"';
	}
	if($sd_kunci=='c'){
		$c='checked="checked"';
	}
	if($sd_kunci=='d'){
		$d='checked="checked"';
	}
	?>



	<tr  class="no_soal" id="detail-<?=$sd_detailid?>">			
		<td>		
			<table class="table" width="100%">	


				<?php if ($sd_header!=''): ?> 				
					<tr>
						<td colspan="5">
							<?=$sd_header ?> 					
						</td>				
					</tr>			
				<?php endif ?>



				<?php if ($sd_subheader!=''): ?> 				
					<tr>
						<td colspan="5">
							<?=$sd_subheader ?> 					
						</td>				
					</tr>			
				<?php endif ?>


				<?php if ($sd_cerita!=''): ?> 				
					<tr>
						<td colspan="5">
							<?=$sd_cerita ?> 					
						</td>				
					</tr>			
				<?php endif ?>
				<td></td>
				<td>
					<input type="hidden" name="sd_master_soal" value="<?=$sd_master_soal ?>">
					<input type="hidden" name="sd_master_soal" value="<?=$sd_detailid?>">
					<span class="no"></span>
				</td>
				<td colspan="3" style="width: 800px">
					<table>
						<tr>
							<td>
								<?=$gambar?>
							</td>
						</tr>
						<tr>
							<td>
								<?=$audio?>
							</td>
						</tr>
						<tr>
							<td>
								<?=$sd_soal?>
							</td>
						</tr>
					</table>


				</td>
				<td style="width: 13%">
					<button class="btn btn-xs btn-danger" onclick="hapus('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','pilihan')" >
						<i class="fa fa-minus"></i>
					</button>
					<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','pilihan')" >
						<i class="fa fa-pencil"></i>
					</button>
				</td>




				<tr>
					<td></td>
					<td style="width: 0.5em"></td>			
					<td style="width: 10px">
						a.
					</td>
					<td style="width: 10px">
						<input type="radio" name="jawaban<?=$sd_detailid?>" value="a" <?=$a ?> disabled>
					</td>
					<td colspan="1"><?=$sd_a ?></td>
					<td></td>
				</tr>
				<tr> 
					<td></td>
					<td style="width: 0.5em"></td>
					<td>b.</td>
					<td style="width: 0.5em">
						<input type="radio" name="jawaban<?=$sd_detailid?>" value="b" <?=$b ?> disabled>
					</td>
					<td colspan="1"><?=$sd_b ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td style="width: 0.5em"></td>
					<td>c.</td>
					<td style="width: 0.5em">
						<input type="radio" name="jawaban<?=$sd_detailid?>" value="c" <?=$c ?> disabled>
					</td>
					<td colspan="1"><?=$sd_c ?></td>
					<td></td>
				</tr>
				<tr> 
					<td></td>
					<td style="width: 0.5em"></td>
					<td>d.</td>
					<td style="width: 0.5em">
						<input type="radio" name="jawaban<?=$sd_detailid?>" value="d" <?=$d ?> disabled>
					</td>
					<td colspan="1"><?=$sd_d ?></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
	

	



<?php endif ?>







<?php if($sd_type=='bs'): ?>

	<?php  
	$audio='';
	$gambar='';
	if($sd_audio!=''){
		$audio='<audio controls><source src="'.base_url().$sd_audio.'" type="audio/wav">'.
		'Your browser does not support the audio element.'.
		'</audio><br>';
	}


	if($sd_gambar!=''){
		$gambar='<img width="300px" height="300px" src="'.base_url().$sd_gambar.'">';
	}


	$html='';
	$a='';
	$b='';
	if($sd_kunci=='a'){
		$a='checked="checked"';
	}
	if($sd_kunci=='b'){
		$b='checked="checked"';
	}
	?>



	<tr  class="no_soal" id="detail2-<?=$sd_detailid?>">			
		<td>		
			<table class="table" width="100%">	

				<td></td>
				<td>
					<input type="hidden" name="sd_master_soal" value="<?=$sd_master_soal ?>">
					<input type="hidden" name="sd_master_soal" value="<?=$sd_detailid?>">
					<span class="no"></span>
				</td>
				<td colspan="3" style="width: 800px">
					<table>
						<tr>
							<td>
								<?=$gambar?>								
							</td>
						</tr>
						<tr>
							<td>
								<?=$audio?>
							</td>
						</tr>
						<tr>
							<td>
								<?=$sd_soal?>								
							</td>
						</tr>
					</table>

				</td>
				<td style="width: 13%">
					<button class="btn btn-xs btn-danger" onclick="hapus('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','bs')" >
						<i class="fa fa-minus"></i>
					</button>
					<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','bs')" >
						<i class="fa fa-pencil"></i>
					</button>
				</td>




				<tr>
					<td></td>
					<td style="width: 0.5em"></td>			
					<td style="width: 10px">
						a.
					</td>
					<td style="width: 10px">
						<input type="radio" name="jawaban-bs<?=$sd_detailid?>" value="a" <?=$a ?> disabled>
					</td>
					<td colspan="1"><?=$sd_a ?></td>
					<td></td>
				</tr>
				<tr> 
					<td></td>
					<td style="width: 0.5em"></td>
					<td>b.</td>
					<td style="width: 0.5em">
						<input type="radio" name="jawaban-bs<?=$sd_detailid?>" value="b" <?=$b ?> disabled>
					</td>
					<td colspan="1"><?=$sd_b ?></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
	

<?php endif ?>






<?php if($sd_type=='esai'): ?>
	<?php  
	$audio='';
	$gambar='';
	if($sd_audio!=''){
		$audio='<audio controls><source src="'.base_url().$sd_audio.'" type="audio/wav">'.
		'Your browser does not support the audio element.'.
		'</audio><br>';
	}


	if($sd_gambar!=''){
		$gambar='<img width="300px" height="300px" src="'.base_url().$sd_gambar.'">';
	}

	$html='';
	
	?>



	<tr  class="no_soal" id="detail3-<?=$sd_detailid?>">			
		<td>		
			<table class="table" width="100%">	
				<td></td>
				<td>
					<input type="hidden" name="sd_master_soal" value="<?=$sd_master_soal ?>">
					<input type="hidden" name="sd_master_soal" value="<?=$sd_detailid?>">
					<span class="no"></span>
				</td>
				<td colspan="3" style="width: 800px">
					<table>
						<tr>
							<td>
								<?=$gambar?>								
							</td>
						</tr>
						<tr>
							<td>
								<?=$audio?>
							</td>
						</tr>
						<tr>
							<td>
								<?=$sd_soal?>								
							</td>
						</tr>
					</table>


				</td>
				<td style="width: 13%">
					<button class="btn btn-xs btn-danger" onclick="hapus('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','esai')" >
						<i class="fa fa-minus"></i>
					</button>
					<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$sd_master_soal ?>','<?=$sd_detailid ?>','esai')" >
						<i class="fa fa-pencil"></i>
					</button>
				</td>




			</table>
		</td>
	</tr>
	
<?php endif ?>

