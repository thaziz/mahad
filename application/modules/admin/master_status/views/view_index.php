<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Master Status	
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"> Master Status	</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">

            </h3>


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


            <div class="action pull-right">
              <a href="#import" data-toggle="collapse" id = "enter" class="btn btn-warning btn-sm btn-circle" type="button"><i class="fa fa-upload"></i> Pilihan Ganda</a>
                            
              <?php if($rules['d']){?>
              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
              <?php }?>
              <?php if($rules['c']){?>
              <a href="<?=base_url('panel/master_status	/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>
              <?php }?>
            </div>
          </div>
          <div class="box-body">
            <table id="table_status" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20px"></th>                 
                  <th>Status Name</th>
                  <th>Enabled</th>
                 
                  <th>&nbsp;</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript">
  function remove(id){
    if (confirm( "Apakah Kamu Ingin Menghapus Data master_status	?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/master_status	/delete"); ?>',
          type: "POST",
          data : {'d_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/master_status	');?>";
                  }
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    }
  }

  $(document).ready(function(){

    $('#table_status').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/master_status	'); ?>",
              "type": "POST"
          },
      "aaSorting": [[ 1, "desc" ]],
      "searching": true,
      "paging": true,
      "bFilter": false,
      "bStateSave": true,
      "bServerSide": true,
      "sPaginationType": "full_numbers",
      "aoColumnDefs": [
      { "title":"<input type='checkbox' class='check-all'></input>","sClass": "center","aTargets":[0],
        "render": function(data, type, full){
          console.log(full);
          return '<input type="checkbox" class="check-item" value="'+full[7]+'">';
        },
        "bSortable": false
      },
      { "sClass": "center", "aTargets": [ 1 ], "data":0 },
      
      { "sClass": "center", "aTargets": [ 2 ], "data":1 ,
        "render" : function (data, type, full, meta){
         // alert(data)
          return '<input disabled="true" type="checkbox" '+(data=='1'?'checked':'')+' "/>'
        }
      },
      
      
      { "sClass": "center", "aTargets": [ 3 ],
        "mRender": function(data, type, full) {
          console.log(full)
            <?php if($rules['v']){ ?>
          return ''
              <?php } ?>
              <?php if($rules['e']){?>
              + ''+'<a href=<?=base_url('panel/master_status	/edit');?>/' + full[9]
              + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
              <?php }?>
              <?php if($rules['d']){?>
              + '</a>'+'<a href="javascript:;" onclick="remove(\'' + full[9] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
              <?php }?>
              + '</a>';
        },
        "bSortable": false
      },
      ]
    });

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Apakah Kamu Ingin Menghapus Data master_status	??' )) {
        var data = {};
        var d_id = [];
        if($('.check-item:checked').length<1){
          $().toastmessage('showToast', {
            text     : "Delete failed, you don't select any data.",
            sticky   : false,
            position : 'top-center',
            type     : 'error',
          });
          return false;
        }
        $('.check-item:checked').each(function(idx, el){
          
          d_id.push(parseInt($(el).val()));
        });
        data.d_id = d_id;
        $.ajax({
          url : '<?php echo base_url("panel/master_status	/delete"); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/master_status	');?>";
                  }
                });
              }else{
                console.log(data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
        });
      }
    });

  });

</script>
