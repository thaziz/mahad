<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($type=='pilihan'): ?>
	<?php foreach ($result as $key => $v): ?>

		<?php  							
		$html='';
		$a='';
		$b='';
		$c='';
		$d='';
		if($v['sd_kunci']=='a'||$v['sd_kunci']=='A'){
			$a='checked="checked"';
		}
		if($v['sd_kunci']=='b'||$v['sd_kunci']=='B'){
			
			$b='checked="checked"';
		}
		if($v['sd_kunci']=='c'||$v['sd_kunci']=='C'){
			$c='checked="checked"';
		}
		if($v['sd_kunci']=='d'||$v['sd_kunci']=='D'){
			$d='checked="checked"';
		}
		?>
		


		<tr  class="no_soal" id="detail-<?=$v['sd_detailid']?>">			
			<td>		
				<table class="table" width="100%">	

					<td></td>
					<td>
						<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
						<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
						<span class="no"></span>
					</td>
					<td colspan="3" width="800px">
						
						<?=$v['sd_soal']?>
					</td>
					<td style="width: 13%">
						<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','pilihan')" >
							<i class="fa fa-minus"></i>
						</button>
						<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','pilihan')" >
							<i class="fa fa-pencil"></i>
						</button>
					</td>
					



					<tr>
						<td></td>
						<td style="width: 0.5em"></td>			
						<td width="1%">
							a.
						</td>
						<td width="1%">
							<input type="radio" name="jawaban<?=$v['sd_detailid']?>" value="a" <?=$a ?> disabled>
						</td>
						<td colspan="1"><?=$v['sd_a'] ?></td>
					</tr>
					<tr> 
						<td></td>
						<td style="width: 0.5em"></td>
						<td>b.</td>
						<td style="width: 0.5em">
							<input type="radio" name="jawaban<?=$v['sd_detailid']?>" value="b" <?=$b ?> disabled>
						</td>
						<td colspan="1"><?=$v['sd_b']	 ?></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 0.5em"></td>
						<td>c.</td>
						<td style="width: 0.5em">
							<input type="radio" name="jawaban<?=$v['sd_detailid']?>" value="c" <?=$c ?> disabled>
						</td>
						<td colspan="1"><?=$v['sd_c']	 ?></td>
					</tr>
					<tr> 
						<td></td>
						<td style="width: 0.5em"></td>
						<td>d.</td>
						<td style="width: 0.5em">
							<input type="radio" name="jawaban<?=$v['sd_detailid']?>" value="d" <?=$d ?> disabled>
						</td>
						<td colspan="1"><?=$v['sd_d']	 ?></td>
					</tr>
				</table>
			</td>
		</tr>

	<?php endforeach ?>

	<?php elseif($type=='bs'): ?>

		<?php foreach ($result as $key => $v): ?>
			<?php  							
			$html='';
			$a='';
			$b='';
			$c='';
			$d='';
			if(strtolower($v['sd_kunci'])=='a'){
				$a='checked="checked"';
			}
			if(strtolower($v['sd_kunci'])=='b'){
				$b='checked="checked"';
			}
			
			?>
			
			<tr  class="no_soal" id="detail2-<?=$v['sd_detailid']?>">			
				<td>		
					<table class="table" width="100%">	

						<td></td>
						<td>
							<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
							<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
							<span class="no"></span>
						</td>
						<td colspan="3" width="800px">
							
							<?=$v['sd_soal']?>
						</td>
						<td style="width: 13%">
							<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','bs')" >
								<i class="fa fa-minus"></i>
							</button>
							<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','bs')" >
								<i class="fa fa-pencil"></i>
							</button>
						</td>
						



						<tr>
							<td></td>
							<td style="width: 0.5em"></td>			
							<td width="1%">
								a.
							</td>
							<td width="1%">
								<input type="radio" name="jawaban-bs<?=$v['sd_detailid']?>" value="a" <?=$a ?> disabled>
							</td>
							<td colspan="1"><?=$v['sd_a'] ?></td>
						</tr>
						<tr> 
							<td></td>
							<td style="width: 0.5em"></td>
							<td>b.</td>
							<td style="width: 0.5em">
								<input type="radio" name="jawaban-bs<?=$v['sd_detailid']?>" value="b" <?=$b ?> disabled>
							</td>
							<td colspan="1"><?=$v['sd_b']	 ?></td>
						</tr>
					</table>
				</td>
			</tr>




		<?php endforeach ?>

		<?php elseif($type=='esai'): ?>
			<?php foreach ($result as $key => $v): ?>
				

				<tr  class="no_soal" id="detail3-<?=$v['sd_detailid']?>">			
					<td>		
						<table class="table" width="100%">	
							<td></td>
							<td>
								<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
								<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
								<span class="no"></span>
							</td>
							<td colspan="3" width="800px">
								
								<?=$v['sd_soal']?>
							</td>
							<td style="width: 13%">
								<button class="btn btn-xs btn-danger" onclick="hapus('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','esai')" >
									<i class="fa fa-minus"></i>
								</button>
								<button class="btn btn-xs btn-warning" onclick="edit_detail('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>','esai')" >
									<i class="fa fa-pencil"></i>
								</button>
							</td>
							



						</table>
					</td>
				</tr>



			<?php endforeach ?>

			<?php endif ?>