<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      List Ujian
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"> List Ujian</li>
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
            <table id="table_ujian" class="table table-bordered table-striped">
              <thead>
                <tr>                
                  <th>Matkul</th>
                  <th>Waktu Ujian</th>
                  <th>Status</th>
                  <!-- <th>Nilai</th> -->
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
          url : '<?php echo base_url("panel/bank_soal/delete"); ?>',
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
                    window.location = "<?=base_url('panel/bank_soal');?>";
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

    $('#table_ujian').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/ujian'); ?>",
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
      
      { "sClass": "center", "aTargets": [ 0 ], "data":0 },
      { "sClass": "center", "aTargets": [ 1 ], "data":1 },
      { "sClass": "center", "aTargets": [ 2 ], "data":2 },
      /*{ "sClass": "center", "aTargets": [ 3 ], "data":3 },*/

      
      
      { "sClass": "center", "aTargets": [ 3 ],
        "mRender": function(data, type, full) {
          console.log(full[2])
            $edit=(full[2]=='Selesai'?'disabled':'');
            <?php if($rules['v']){ ?>
          return ''
              <?php } ?>
              <?php if($rules['e']){?>
              + ''+'<a '+$edit+' href=<?=base_url('panel/ujian/ujian_ol');?>/' + full[3]
              + ' class="btn btn-info btn-xs btn-col icon-green" '+full[4]+'><i class="fa fa-pencil"></i> Mulai Ujian'
              <?php }?>
              <?php if($rules['d']){?>
              + '</a>'+'<a  href="javascript:;" onclick="remove(\'' + full[3] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
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
          url : '<?php echo base_url("panel/bank_soal/delete"); ?>',
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
                    window.location = "<?=base_url('panel/bank_soal');?>";
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
