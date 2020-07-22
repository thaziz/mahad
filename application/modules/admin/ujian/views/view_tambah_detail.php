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
	<tr>
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
			<?=$v['xx']?>
		</td>
		<td colspan="3">
			<?=$v['sd_soal']?>
		</td>
		<td>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
				<i class="fa fa-minus"></i>
			</button>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
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
			<input type="radio" name="jawaban<?=$v['sd_no']?>" value="a" <?=$a ?> disabled></td>
		<td colspan="1"><?=$v['sd_a'] ?></td>
		<tr> 
			<td></td><td>b.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v['sd_no']?>" value="b" <?=$b ?> disabled></td>
			<td colspan="1"><?=$v['sd_b'] ?></td>
		</tr></tr>
		<tr>
			<td></td><td>c.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v['sd_no']?>" value="c" <?=$c ?> disabled></td>
			<td colspan="1"><?=$v['sd_c'] ?></td>
		</tr>
		<tr> 
			<td></td><td>d.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban<?=$v['sd_no']?>" value="d" <?=$d ?> disabled></td>
			<td colspan="1"><?=$v['sd_d'] ?></td>
		</tr>





	<?php endforeach ?>
<?php elseif($type=='bn'): ?>

<?php foreach ($result as $key => $v): ?>
	<?php  							
	$html='';
	$a='';
	$b='';
	$c='';
	$d='';
	if($v['sd_kunci']=='a'){
		$a='checked="checked"';
	}
	if($v['sd_kunci']=='b'){
		$b='checked="checked"';
	}
	if($v['sd_kunci']=='c'){
		$c='checked="checked"';
	}
	if($v['sd_kunci']=='d'){
		$d='checked="checked"';
	}
	?>
	<tr>
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
			<?=$v['xx']?>
		</td>
		<td colspan="3">
			<?=$v['sd_soal']?>
		</td>
		<td>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
				<i class="fa fa-minus"></i>
			</button>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
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
			<input type="radio" name="jawaban[]" value="a" <?=$a ?> disabled></td>
		<td colspan="1"><?=$v['sd_a'] ?></td>
		<tr> 
			<td></td><td>b.</td>
			<td style="width: 0.5em"><input type="radio" name="jawaban[]" value="b" <?=$b ?> disabled></td>
			<td colspan="1"><?=$v['sd_b'] ?></td>
		</tr></tr>




	<?php endforeach ?>

<?php elseif($type=='esai'): ?>
<?php foreach ($result as $key => $v): ?>
	
	<tr>
		<td style="width: 0.5em">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_master_soal'] ?>">
			<input type="hidden" name="sd_master_soal" value="<?=$v['sd_detailid']?>">
			<?=$v['xx']?>
		</td>
		<td colspan="3">
			<?=$v['sd_soal']?>
		</td>
		<td>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
				<i class="fa fa-minus"></i>
			</button>
			<button onclick="('<?=$v['sd_master_soal'] ?>','<?=$v['sd_detailid'] ?>')" >
				<i class="fa fa-pencil"></i>
			</button>
		</td>
	</tr>




	<?php endforeach ?>

 <?php endif ?>