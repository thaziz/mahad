<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Bank Soal
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"> Bank Soal</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">

            </h3>
            <div class="action pull-right">
              <?php if($rules['d']){?>
              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
              <?php }?>
              <?php if($rules['c']){?>
              <a href="<?=base_url('panel/bank_soal/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>
              <?php }?>
            </div>
          </div>
          <div class="box-body">
            <table id="table_soal" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20px"></th>                 
                  <th>Jenis Ujian</th>
                  <th>Mata Kuliah</th>
                  <th>Jenis Kelamin</th>
                  <th>Level</th>
                  <th>Kelas</th>
                  <th>Waktu Pelaksanaan</th>
                  <th>Waktu</th>
                  <th>Tanggal Dibuat</th>  
                  <th>Status</th>  
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
    if (confirm( "Apakah Kamu Ingin Menghapus Data bank_soal?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/bank_soal/delete_master"); ?>',
          type: "POST",
          data : {'d_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data==true){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/bank_soal');?>";
                  }
              });
            }else{
              $().toastmessage('showToast', {
                  text     : 'Data gagal',
                  position : 'top-center',
                  type     : 'error',
                  close    : function () {
                    //window.location = "<?=base_url('panel/bank_soal');?>";
                  }
                })
            }

          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    }
  }

  $(document).ready(function(){

    $('#table_soal').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/bank_soal'); ?>",
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
          return '<input type="checkbox" class="check-item" value="'+full[10]+'">';
        },
        "bSortable": false
      },
      { "sClass": "center", "aTargets": [ 1 ], "data":0 },
      { "sClass": "center", "aTargets": [ 2 ], "data":1 },

      { "sClass": "center", "aTargets": [ 3 ], "data":2 },
      { "sClass": "center", "aTargets": [ 4 ], "data":3 },

      { "sClass": "center", "aTargets": [ 5 ], "data":4 },
      { "sClass": "center", "aTargets": [ 6 ], "data":5 },
      { "sClass": "center", "aTargets": [ 7 ], "data":6 },
      { "sClass": "center", "aTargets": [ 8 ], "data":7},
      /*{ "sClass": "center", "aTargets": [ 9 ], "data":8},*/

      { "sClass": "center", "aTargets": [ 9 ], "data":8 ,
        "render" : function (data, type, full, meta){
         // alert(data)
          return '<input disabled="true" type="checkbox" '+(data=='1'?'checked':'')+' "/>'
        }
      },
      
      
      { "sClass": "center", "aTargets": [ 10 ],
        "mRender": function(data, type, full) {
          $edit=(full[9]>0?'disabled':'');
          console.log($edit);
            <?php if($rules['v']){ ?>
          return ''
              <?php } ?>
              <?php if($rules['e']){?>
              + ''+'<a '+$edit+' href=<?=base_url('panel/bank_soal/edit');?>/' + full[10]
              + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
              <?php }?>
              <?php if($rules['d']){?>
              + '</a>'+'<a '+$edit+'  href="javascript:;" onclick="remove(\'' + full[10] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
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
      if (confirm( 'Apakah Kamu Ingin Menghapus Data bank_soal??' )) {
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
          url : '<?php echo base_url("panel/bank_soal/delete_master"); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data==true){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/bank_soal');?>";
                  }
                });
              }else{
                  $().toastmessage('showToast', {
                  text     : 'Data gagal',
                  position : 'top-center',
                  type     : 'error',
                  close    : function () {
                    window.location = "<?=base_url('panel/bank_soal');?>";
                  }
                })
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
