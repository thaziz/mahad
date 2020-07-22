<?php

class Ujian_model extends CI_Model {

    private $pref = '';
    var $table = 'master_soal';
    var $column_order = array('subject_ar_name','ms_startdate','ms_kelas','n_nilai_total');
    var $column_search =array('subject_ar_name','ms_startdate','ms_kelas','n_nilai_total');
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

        $data=[
            'u_user' =>1,
            'u_soal' =>$id,
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
        $pilihan=$this->db->where('sd_master_soal',$id)->order_by('cast(sd_no as unsigned)','asc')->get()->result(); 
         
        $bs=[];
        $data=[];

        foreach ($pilihan as $key => $v) {
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
                        'ud_a'   =>$v->sd_a,                        
                        'ud_b'   =>$v->sd_b,                        
                        'ud_c'   =>$v->sd_c,                        
                        'ud_d'   =>$v->sd_d,                        
                    ];                    
                }
        }


        $this->db->insert_batch('ujian_detail_pilihan',$data);

        $this->db->select('*');
        $this->db->from('detail_soal_benarsalah');
        $benarsalah=$this->db->where('sd_master_soal',$id)->order_by('rand()')->get()->result();   
        $bs=[];
        $data=[];
//        $data1=[];

        foreach ($benarsalah as $key => $v) {
            $bs[]=$v->sd_a.'===A';
            $bs[]=$v->sd_b.'===B';
            shuffle($bs);
            if(count($bs)){
                   $data[]=[
                        'ud_ujian'=>$id_soal,
                        'ud_master_soal'=>$v->sd_master_soal,
                        'ud_detailid'   =>$v->sd_detailid,
                        'ud_no'   =>$v->sd_no,
                        'ud_a'   =>$bs[0],                        
                        'ud_b'   =>$bs[1],                        
                    ];                    
                }
        }


        $this->db->insert_batch('ujian_detail_benarsalah',$data);




    
        $this->db->select('*');
        $this->db->from('detail_soal_esai');
        $esai=$this->db->where('sd_master_soal',$id)->order_by('rand()')->get()->result();   

        $bs=[];
        $data=[];
        foreach ($esai as $key => $v) {           
                   $data[]=[
                        'ud_ujian'=>$id_soal,
                        'ud_master_soal'=>$v->sd_master_soal,
                        'ud_detailid'   =>$v->sd_detailid,
                    ];                    
                
        }

        
        $this->db->insert_batch('ujian_detail_esai',$data);


        
        
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
       
        $this->db->insert_batch('ujian_detail_pilihan',$_data);  
        $this->db->where('u_id', $id_ujian);
        $a=['u_nilai_pilihan'=>$n];
         $this->db->update('ujian',$a);      
    }
    if($type=='bn'){
        $this->db->insert_batch('ujian_detail_benarsalah',$_data);        
        $this->db->where('u_id', $id_ujian);
        $a=['u_nilai_benarsalah'=>$n];
        $this->db->update('ujian',$a);  
    }
    if($type=='esai'){
        $this->db->insert_batch('ujian_detail_esai',$_data);        
    }
}

}