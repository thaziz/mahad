<?php

class Ujian_model extends CI_Model {

    private $pref = '';
    var $table = 'master_soal';
    var $column_order = array('subject_ar_name','ms_startdate','ms_kelas','u_nilai_total');
    var $column_search =array('subject_ar_name','ms_startdate','ms_kelas','u_nilai_total');
    var $order = array('subject_ar_name' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('security');
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref.$this->table;
    }


    private function load_admin(){

        $this->db->select('*');
        $this->db->where('ms_startdate',date('Y-m-d'));
        //$this->db->where('ms_enddate>=',date('Y-m-d'));
        //$this->db->where('u_user',$this->session->userdata('id'));  
        //$this->db->where('u_status',$this->session->userdata('id'));  
        $this->db->join('db_subject','ms_matkul=id_subject');
        $this->db->join('ujian','u_soal=ms_id','left');
        $this->db->from('master_soal');
        //var_dump($this->db->get_compiled_select());exit();

        $i = 0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value'])
            {

                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_load_result()
    {
        $this->load_admin();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_admin();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
     $this->load_admin();
     return $this->db->count_all_results();
 }






 public function ujian_ol($id){

    $akhir='';
    /*SELECT DATE_ADD("2017-06-15 09:34:21", INTERVAL 60 MINUTE);*/
    /*ketika waktu lama ujian masih tapi waktu ujian habis maka tidak bisa */
    $this->db->select('*,u_id,u_start,        
        TIMEDIFF(u_ms_endtime,time(now())) as sisa_waktu');
    $this->db->join('master_soal','ms_id=u_soal');
    $this->db->join('db_subject','ms_matkul=id_subject');    
    $this->db->from('ujian');
    $this->db->where('u_user',$this->session->userdata('id'));    
    $this->db->where('ms_startdate',date('Y-m-d'));
    //$this->db->where('ms_enddate>=',date('Y-m-d'));
    $dx=$this->db->where('u_soal',$id)->order_by('u_id','desc')->get();

    if($dx->num_rows()>0){
        if($dx->row()->u_status==1){
            return array('status' =>false ,'info'=>'Selamat anda telah selesai mengerjakan soal');
        }

        /*expired time*/
        if(strtotime(date('H:i:s')) >=strtotime($dx->row()->u_ms_starttime) &&
           strtotime(date('H:i:s'))<=strtotime($dx->row()->u_ms_endtime)){

        }else{
            return array('status' =>false ,'info'=>"Ma'af, Jadwal Ujian Telah Berakhir");
        }

        /*lama pengerjaan*/
        if($dx->row()->sisa_waktu<'0'){
            return array('status' =>false ,'info'=>'Waktu Berakhir');
        }

        
        $id_soal=$dx->row()->u_id;
        $this->db->select('*,SEC_TO_TIME(ms_waktu*60) ms_waktu');
        $this->db->join('db_subject','ms_matkul=id_subject');
        $this->db->from('master_soal');
        $d=$this->db->where('ms_id',$id)->get()->row(); 
        $d->sisa=$dx->row()->sisa_waktu;


        $this->db->select('*');
        $this->db->join('detail_soal_pilihan','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_pilihan');
        $this->db->where('ud_ujian',$id_soal);
        $data['pilihan']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  


        $this->db->select('*');
        $this->db->join('detail_soal_benarsalah','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_benarsalah');
        $this->db->where('ud_ujian',$id_soal);
        $data['bs']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  

        $this->db->select('*');
        $this->db->join('detail_soal_esai','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_esai');
        $this->db->where('ud_ujian',$id_soal);
        $data['esai']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  

        $data['id_ujian']=$id_soal;
        $data['master']=$d;
        $data['status']=true;
        return $data;


    }
    else{
        $this->db->select('*, TIMEDIFF(ms_endtime,ms_starttime) sisa_waktu');
        $this->db->join('db_subject','ms_matkul=id_subject');
        $this->db->where('ms_startdate',date('Y-m-d'));
        //$this->db->where('ms_enddate>=',date('Y-m-d'));
        $this->db->from('master_soal');
        $d=$this->db->where('ms_id',$id)->get();
        


        if($d->num_rows()>0){

          if(strtotime(date('H:i:s')) >=strtotime($d->row()->ms_starttime) &&
           strtotime(date('H:i:s'))<=strtotime($d->row()->ms_endtime)){


        $used=($d->row()->ms_used==NULL?0:$d->row()->ms_used)+1;
    //var_dump($used);exit();
        $this->db->where('ms_id',$id);
        $this->db->update('master_soal',['ms_used'=>$used]);


            $data=[
                'u_user' =>$this->session->userdata('id'),
                'u_soal' =>$id,
                'u_ms_starttime'=>$d->row()->ms_starttime,
                'u_ms_endtime'=>$d->row()->ms_endtime,
                'u_start' =>date('Y-m-d H:i:s'),            
                'u_date' =>date('Y-m-d H:i:s'),
            ];
            $this->db->insert('ujian',$data);
            $id_soal = $this->db->insert_id();


            $this->db->select('*,SEC_TO_TIME(ms_waktu*60) ms_waktu');
            $this->db->join('db_subject','ms_matkul=id_subject');
            $this->db->from('master_soal');
            $data['master']=$this->db->where('ms_id',$id)->get()->row();    

            $this->db->select('*');
            $this->db->from('detail_soal_pilihan');
            $pilihan=$this->db->where('sd_master_soal',$id)->order_by('sd_detailid','asc')->get()->result();


            $data=[];

            foreach ($pilihan as $key => $v) {
                $bs=[];
                $bs[]=$v->sd_a.'===A';
                $bs[]=$v->sd_b.'===B';
                $bs[]=$v->sd_c.'===C';
                $bs[]=$v->sd_d.'===D';
                shuffle($bs);
                if(count($bs)){
                   $data[]=[
                    'ud_ujian'=>$id_soal,
                    'ud_master_soal'=>$v->sd_master_soal,
                    'ud_detailid'   =>$v->sd_detailid,
                    'ud_a'   =>$bs[0],                        
                    'ud_b'   =>$bs[1],                        
                    'ud_c'   =>$bs[2],                        
                    'ud_d'   =>$bs[3],                        
                ];                    
            }
        }
//exit();
if(count($pilihan)>0)
        $this->db->insert_batch('ujian_detail_pilihan',$data);
 


        $this->db->select('*');
        $this->db->from('detail_soal_benarsalah');
        $benarsalah=$this->db->where('sd_master_soal',$id)->order_by('rand()')->get()->result();   

        $data=[];
//        $data1=[];

        foreach ($benarsalah as $key => $v) {
            $bs=[];
            $bs[]=$v->sd_a.'===A';
            $bs[]=$v->sd_b.'===B';
            //shuffle($bs);
            if(count($bs)){
               $data[]=[
                'ud_ujian'=>$id_soal,
                'ud_master_soal'=>$v->sd_master_soal,
                'ud_detailid'   =>$v->sd_detailid,
               // 'ud_no'   =>$v->sd_no,
                'ud_a'   =>$bs[0],                        
                'ud_b'   =>$bs[1],                        
            ];                    
        }
    }

if(count($benarsalah)>0)
    $this->db->insert_batch('ujian_detail_benarsalah',$data);




    
    $this->db->select('*');
    $this->db->from('detail_soal_esai');
    $esai=$this->db->where('sd_master_soal',$id)->order_by('rand()')->get()->result();   

    $data=[];
    foreach ($esai as $key => $v) {           
       $data[]=[
        'ud_ujian'=>$id_soal,
        'ud_master_soal'=>$v->sd_master_soal,
        'ud_detailid'   =>$v->sd_detailid,
    ];                    



}
if(count($esai)>0)
$this->db->insert_batch('ujian_detail_esai',$data);


//get_soal setelah save



$this->db->select('*,TIMEDIFF(ms_endtime,ms_starttime) as sisa_waktu');
$this->db->join('db_subject','ms_matkul=id_subject');
$this->db->from('master_soal');
$d=$this->db->where('ms_id',$id)->get()->row(); 

$d->sisa=$d->sisa_waktu;



$this->db->select('*');
$this->db->join('detail_soal_pilihan','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
$this->db->from('ujian_detail_pilihan');
$this->db->where('ud_ujian',$id_soal);
$data['pilihan']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  


$this->db->select('*');
$this->db->join('detail_soal_benarsalah','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
$this->db->from('ujian_detail_benarsalah');
$this->db->where('ud_ujian',$id_soal);
$data['bs']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  

$this->db->select('*');
$this->db->join('detail_soal_esai','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
$this->db->from('ujian_detail_esai');
$this->db->where('ud_ujian',$id_soal);
$data['esai']=$this->db->where('sd_master_soal',$id)->order_by('ud_id')->get()->result();  

$data['id_ujian']=$id_soal;
$data['master']=$d;
$data['status']=true;
return $data;




}else{

    return array('status' =>false ,'info'=>"Ma'af, Jadwal Ujian Telah Berakhir");
}

}else{
   return array('status' =>false ,'info'=>"Ma'af, Jadwal Ujian Telah Berakhir");
} 


}

}

public function chek_jawaban($type)
{       
    //$type='pilihan';
    if($type=='pilihan'){
        $this->db->select('*');
        return $this->db->from('detail_soal_pilihan')->get()->result();          
    }
    else if($type=='bn'){
        $this->db->select('*');
        return $this->db->from('detail_soal_benarsalah')->get()->result();          
    }
}

/*
public function save_ujian($id){
    

    
}*/

public function save_jawaban($type,$id_ujian,$_data,$n,$jml_soal)
{       
    if($type=='pilihan'){
       foreach ($_data as $key => $v) {
        $this->db->where('ud_ujian', $v['ud_ujian']);
        $this->db->where('ud_master_soal', $v['ud_master_soal']);
        $this->db->where('ud_detailid', $v['ud_detailid']);    

        $data=[
            'ud_jawaban'=>$v["ud_jawaban"],
            'ud_status'=>$v["ud_status"],  
        ];
        $this->db->update('ujian_detail_pilihan',$data);  

    }
    $this->db->where('u_id', $id_ujian);
    $a=['u_nilai_pilihan'=>$n];
    $this->db->update('ujian',$a);      

}
if($type=='bn'){

    foreach ($_data as $key => $v) {

        $this->db->where('ud_ujian', $v['ud_ujian']);
        $this->db->where('ud_master_soal', $v['ud_master_soal']);
        $this->db->where('ud_detailid', $v['ud_detailid']);    
        $data=[
            'ud_jawaban'=>$v["ud_jawaban"],
            'ud_status'=>$v["ud_status"],  
        ];

        $this->db->update('ujian_detail_pilihan',$data);  

    }

    $this->db->where('u_id', $id_ujian);
    $a=['u_nilai_pilihan'=>$n];
    $this->db->update('ujian',$a);       
}
    /*if($type=='esai'){
        $this->db->insert_batch('ujian_detail_esai',$_data);        
    }*/
}

function save_per_soal(){
 

    $tipe=$_POST['tipe'];
    $u_id=$_POST['u_id'];
    unset($_POST['tipe']);
    unset($_POST['u_id']);

    $_akhir['ud_akhir']=0;
    
    $this->db->where('u_id',$u_id);
    $chek_open=$this->db->get('ujian');
    

     if(strtotime(date('H:i:s')) >=strtotime($chek_open->row()->u_ms_starttime) &&
           strtotime(date('H:i:s'))<=strtotime($chek_open->row()->u_ms_endtime)){


    }else{
        return array('status' =>false,'info'=>'Waktu Sudah Habis' );
        exit();
    }
    

    $this->db->where('ud_ujian',$u_id);
    $ax=$this->db->update('ujian_detail_pilihan',$_akhir);



    
    $this->db->where('ud_ujian',$u_id);
    $this->db->update('ujian_detail_benarsalah',$_akhir);


    $this->db->where('ud_ujian',$u_id);
    $this->db->update('ujian_detail_esai',$_akhir);
    

    if($tipe=='pilihan'){
        unset($_POST['tipe']);
        $this->db->select('*');
        $this->db->where('sd_master_soal',$_POST['ud_master_soal']);
        $this->db->where('sd_detailid',$_POST['ud_detailid']);
        $this->db->where('sd_kunci',$_POST['ud_jawaban']);
        $cek=$this->db->from('detail_soal_pilihan')->get();       
        if($cek->num_rows()>0){
            $_POST['ud_status']=1;
            $_POST['ud_akhir']=1;
            $this->db->where('ud_ujian',$u_id);
            $this->db->where('ud_master_soal',$_POST['ud_master_soal']);
            $this->db->where('ud_detailid',$_POST['ud_detailid']);
            $this->db->update('ujian_detail_pilihan',$_POST);
        }else{
            $_POST['ud_status']=0;
            $_POST['ud_akhir']=1;
            $this->db->where('ud_ujian',$u_id);
            $this->db->where('ud_master_soal',$_POST['ud_master_soal']);
            $this->db->where('ud_detailid',$_POST['ud_detailid']);
            $this->db->update('ujian_detail_pilihan',$_POST);
        }


        $this->db->where('ud_ujian',$u_id);
        $this->db->where('ud_status',1);
        $jumlah=$this->db->from('ujian_detail_pilihan')->count_all_results();

        $this->db->where('u_id',$u_id);
        $q=$this->db->update('ujian',array('u_nilai_pilihan' => $jumlah, ));
        if($q){
            return array('status' =>true,'info'=>'info Sudah Habis' );
            exit();
        }else{
            return array('status' =>false,'info'=>"Ma'af, Jawaban Gagal Di simpan" );
        }



    }
    if($tipe=='bs'){
        unset($_POST['tipe']);
        $this->db->select('*');
        $this->db->where('sd_master_soal',$_POST['ud_master_soal']);
        $this->db->where('sd_detailid',$_POST['ud_detailid']);
        $this->db->where('sd_kunci',$_POST['ud_jawaban']);
        $cek=$this->db->from('detail_soal_benarsalah')->get(); 


        if($cek->num_rows()>0){
            $_POST['ud_status']=1;
            $_POST['ud_akhir']=1;
            $this->db->where('ud_ujian',$u_id);
            $this->db->where('ud_master_soal',$_POST['ud_master_soal']);
            $this->db->where('ud_detailid',$_POST['ud_detailid']);
            //$this->db->get('ujian_detail_benarsalah')->result();
            $this->db->update('ujian_detail_benarsalah',$_POST);
            
        }else{
            $_POST['ud_status']=0;
            $_POST['ud_akhir']=1;
            $this->db->where('ud_ujian',$u_id);
            $this->db->where('ud_master_soal',$_POST['ud_master_soal']);
            $this->db->where('ud_detailid',$_POST['ud_detailid']);
            $this->db->update('ujian_detail_benarsalah',$_POST);
           // var_dump($_POST['ud_detailid']);
        }


        $this->db->where('ud_ujian',$u_id);
        $this->db->where('ud_status',1);
        $jumlah=$this->db->from('ujian_detail_benarsalah')->count_all_results();

        $this->db->where('u_id',$u_id);
        $q=$this->db->update('ujian',array('u_nilai_benarsalah' => $jumlah, ));
        if($q){
            return array('status' =>true,'info'=>'Waktu Sudah Habis' );
            exit();
        }else{
            return array('status' =>false,'info'=>"Ma'af, Jawaban Gagal Di simpan" );
        }

    }




    if($tipe=='esai'){
          $_POST['ud_akhir']=1;
 //       var_dump($_POST);exit();
        unset($_POST['tipe']);       
            $this->db->where('ud_master_soal',$_POST['ud_master_soal']);
            $this->db->where('ud_detailid',$_POST['ud_detailid']);
           $q=$this->db->update('ujian_detail_esai',$_POST);
        if($q){
            return array('status' =>true,'info'=>'Waktu Sudah Habis' );
            exit();
        }else{
            return array('status' =>false,'info'=>"Ma'af, Jawaban Gagal Di simpan" );
        }
       
    }

}


function selesai($id){    
    $this->db->where('u_id',$id);
    return $this->db->update('ujian',array('u_status' =>'1','u_end'=>date('Y-m-d H:i:s') ));
}
}