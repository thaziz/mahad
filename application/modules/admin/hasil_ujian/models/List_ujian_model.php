<?php

class List_ujian_model extends CI_Model {

    private $pref = '';
    var $table = 'master_soal';
    var $column_order = array('subject_ar_name','ms_startdate','ms_kelas');
    var $column_search =array('subject_ar_name','ms_startdate','ms_kelas');
    var $order = array('subject_ar_name' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('security');
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref.$this->table;
    }


    private function load_admin($id){

        $this->db->select('*');
       // $this->db->where('ms_startdate',date('Y-m-d'));
        $this->db->where('u_soal',$id);
        $this->db->join('db_subject','ms_matkul=id_subject');        
        $this->db->join('ujian','u_soal=ms_id','left');
        $this->db->join('v_admin','adm_id=u_user');
        $this->db->from('master_soal');
        

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

    public function get_load_result($id)
    {
        $this->load_admin($id);
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($id)
    {
        $this->load_admin($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id)
    {
     $this->load_admin($id);
     return $this->db->count_all_results();
 }






 
function detail_ujian($id_soal){

    $this->db->select('*,u_id,u_start,        
        TIMEDIFF(u_ms_endtime,time(now())) as sisa_waktu');
    $this->db->join('master_soal','ms_id=u_soal');
    $this->db->join('db_subject','ms_matkul=id_subject');    
    $this->db->from('ujian');
    $this->db->where('u_id',$id_soal);        
    $data['master']=$this->db->order_by('u_id','desc')->get()->row();
    




        $this->db->select('*');
        $this->db->join('detail_soal_pilihan','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_pilihan');
        $this->db->where('ud_ujian',$id_soal);
        $data['pilihan']=$this->db->order_by('sd_detailid')->get()->result();  



        $this->db->select('*');
        $this->db->join('detail_soal_benarsalah','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_benarsalah');
        $this->db->where('ud_ujian',$id_soal);
        $data['bs']=$this->db->order_by('sd_detailid')->get()->result();  

        $this->db->select('*');
        $this->db->join('detail_soal_esai','ud_master_soal=sd_master_soal and ud_detailid=sd_detailid');        
        $this->db->from('ujian_detail_esai');
        $this->db->where('ud_ujian',$id_soal);
        $data['esai']=$this->db->order_by('sd_detailid')->get()->result();  

        //$data['master']=$d;
        $data['status']=true;
        return $data;

    
    
}

}