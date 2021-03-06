<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Administrator
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
	      <li class="active">Edit</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					<form class="form-horizontal" method="post" id="admin_form">
				        <div class="box-body">
					        <input type="hidden" name="adm_id"  value="<?=$data->adm_id?>">

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Nama *</label>
					            <div class="col-sm-4">
					              <input type="hidden" name = "adm_name_old" value="<?=$data->adm_name?>">
					              <input type="text" placeholder="Name" name = "adm_name" value="<?=$data->adm_name?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				       <div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIM *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="NIM" name = "adm_nim" id="adm_nim" class="form-control" value="<?=$data->adm_nim?>">
					              <span class="info"></span>
					              <input type="hidden"  name = "adm_nim_old" class="form-control" value="<?=$data->adm_nim?>">
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Jenis Kelamin *</span></label>
					            <div class="col-sm-5">					             
					              <select placeholder="Jenis Kelamin" name = "adm_jk" id="adm_jk" class="form-control">
					              	<?php 
					              	$selectl='';
					              	$selectp='';
					              	if($data->adm_jk=='L'){
					              		$selectl='selected=""';
					              						              	
					              	}else if($data->adm_jk=='P'){
					              		$selectp='selected=""';
					              	}


					              	 ?>
					              	<option value="L" <?=$selectl ?> >Laki-laki</option>
					              	<option value="P" <?=$selectp ?> >Perempuan</option>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Level *</span></label>
					            <div class="col-sm-5">					             
					              <input placeholder="Level" name = "adm_level" id="adm_level" class="form-control" value="<?=$data->adm_level?>" >
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Kelas *</span></label>
					            <div class="col-sm-5">					             
					             <input placeholder="Kelas" name = "adm_kelas" id="adm_kelas" class="form-control" value="<?=$data->adm_kelas?>">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	  <input type="hidden" placeholder="Login" name = "adm_login_old" id="adm_login" class="form-control" value="<?=$data->adm_login?>">
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_password">Login *</span></label>
					            <div class="col-sm-5">
					              <input type="text" placeholder="Login" name = "adm_login" id="adm_login" class="form-control" value="<?=$data->adm_login?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_password">Password</span></label>
					            <div class="col-sm-5">
					              <input type="password" placeholder="Password" name="adm_password" id="password" class="form-control">
					              <span class="info">Set empty if you don't want change</span>
					            </div>
				          	</div>

				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="adm_active">Enabled</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="adm_active" value="1" 
						            			<?=($data->adm_active==1?'checked':'')?>>
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="grp_id">Group *</span></label>
					            <div class="col-sm-4">
					              <select class="form-control" id="grp_id" name="grp_id" readonly>
					              	<option value="">-- Select Group --</option>
					              	<?php
					              		if($group){
						              		foreach ($group as $value) {
						              			echo '<option value="'.$value->grp_id.'" '
						              					.($value->grp_id==$data->grp_id?'selected':'').'>'
						              					.$value->grp_name.'</option>';
						              		}
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<!--div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ip">Ip Address</span></label>
					            <div class="col-sm-5">
					              <input type="text" name = "adm_ip" value="<?=$data->adm_ip?>" class="form-control" readonly>
					              <span class="info"></span>
					            </div>
				          	</div-->

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/admin'); ?>" class="btn btn-default">Back</a>
				        	</div>
				        </div>
				      </form>
	  			</div>
	  		</div>
	  	</div>
  </section>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/admin/edit").'/'.$data->adm_id; ?>',
          type: "POST",
          data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                	$('[name="'+key+'"] + .info').html(val);
                });
              }else{
                $().toastmessage('showToast', {
				    text     : 'Update data success',
				    position : 'top-center',
				    type     : 'success',
				    close    : function () {
				    	window.location = "<?=base_url('panel/admin');?>";
				    }
				});
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    });
  });
</script>
