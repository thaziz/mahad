<?php

class Bank_soal_model extends CI_Model {

    private $pref = '';
    var $table = 'master_soal';
    var $column_order = array('t_id','a_name','a_code','t_nominal','t_year');
    var $column_search =array('t_id','a_name','a_code','t_nominal','t_year');
    var $order = array('a_id' => 'asc');

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
        $this->db->join('v_opening_account op','op.oa_id=b.t_a_code');
        $this->db->join('v_account a','a.a_id=op.oa_account_id');
        $this->db->from($this->table.' b');		
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
    $this->db->from($this->table);
    return $this->db->count_all_results();
}

public function find_by_id($id){
        /*$this->db->where('oa_id', $id);
        $this->db->select('*');
         $this->db->join('v_account a','a.a_id=b.oa_account_id');
        $query = $this->db->get($this->table. ' b', 1);
*/
        $this->db->select('*');
        $this->db->join('v_opening_account op','op.oa_id=b.t_a_code');
        $this->db->join('v_account a','a.a_id=op.oa_account_id');
        $this->db->where('t_id', $id);        
        $query=$this->db->get($this->table.' b');     
        //var_dump($query->row());exit();
        return $query->row();
    }

    public function insert(){

        $date_range = explode('-',$_POST['date_range']);
        $sdate = date('Y-m-d', strtotime(trim($date_range[0])));
        $edate = date('Y-m-d', strtotime(trim($date_range[1])));

        $data=[
            'ms_jenis_kel' =>$_POST['jk'],
            'ms_jenis_ujian'=>$_POST['jenis'],
            'ms_matkul' =>$_POST['matkul'],
            'ms_level' =>$_POST['level'],
            'ms_kelas' =>$_POST['kelas'],
            'ms_dosen' =>1,
            'ms_startdate' =>$sdate,
            'ms_enddate' =>$edate,
            'ms_starttime' => date('H:i:s', strtotime($_POST['stime_perday'])),
            'ms_endtime' => date('H:i:s', strtotime($_POST['etime_perday'])),
            'ms_created' =>date('Y-m-d H:i:s'),
            'ms_created_by' =>1,
        ];

        $this->db->insert('master_soal',$data);
        $id_soal = $this->db->insert_id();
        return array('status'=>true,'id'=>$id_soal);
        
       // return $this->db->insert('v_transaksi', $_POST);

    }



       public function insert_detail(){

       // $config['upload_path']          = './gambar/';
       // $config['allowed_types']        = 'gif|jpg|png|wav';
        $config['max_size']             = 1020040000;
       /* $config['max_width']            = 1024;
        $config['max_height']           = 768;*/
 
        $path = '/uploads/' . date('Y-m-d') . '/';
                        if (!is_dir($dir = 'assets' . $path)) {
                            mkdir($dir);
                        }
        $config['allowed_types'] = '*';
        $config['upload_path']   = $dir;
        $this->load->library('upload', $config);
        
        if(!empty($_FILES['berkas']['name'])) {
                $dname = explode(".", $_FILES['berkas']['name']);
                $ext = end($dname);

                $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);
                if ( ! $this->upload->do_upload('berkas')){
                    $error = array('error' => $this->upload->display_errors());
                }else{
                    $data = array('upload_data' => $this->upload->data());
                }
                $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);

        }
        


        if($_POST['jenis']=='pilihan'){

            $q=$this->db->select('sd_no,sd_detailid')->where('sd_master_soal',$_POST['master_id'])
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_pilihan')->row();

            if($q==NULL){
            $_POST['sd_detailid']=1;
            $_POST['no']=1;
            }else{
            $_POST['sd_detailid']=$q->sd_detailid+1;
            $_POST['no']=$q->sd_no+1;
            }

            if($_FILES['berkas']['name']!=''){
                $_FILES['berkas']['name']=$dir.$_FILES['berkas']['name'];
            }
            $data=[
                'sd_master_soal' =>$_POST['master_id'],
                'sd_detailid' =>$_POST['sd_detailid'],
                'sd_type' =>$_POST['jenis'],
                'sd_no' =>$_POST['no'],
                'sd_soal'=>$_POST['soal'],
                'sd_gambar' =>'',
                'sd_audio' =>$_FILES['berkas']['name'],
                'sd_a' =>$_POST['a'],
                'sd_b' =>$_POST['b'],
                'sd_c' =>$_POST['c'],
                'sd_d' =>$_POST['d'],
                'sd_e' =>'',
                'sd_kunci' =>$_POST['kunci'],
            ];

            $this->db->insert('detail_soal_pilihan',$data);
            $id_soal = $this->db->insert_id();
        }


        if($_POST['jenis']=='bn'){

            $q=$this->db->select('sd_no,sd_detailid')->where('sd_master_soal',$_POST['master_id'])
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_benarsalah')->row();

            if($q==NULL){
                    $_POST['sd_detailid']=1;
                    $_POST['no']=1;
            }else{
                $_POST['sd_detailid']=$q->sd_detailid+1;
                $_POST['no']=$q->sd_no+1;
            }


            $data=[
                'sd_master_soal' =>$_POST['master_id'],
                'sd_detailid' =>$_POST['sd_detailid'],
                'sd_type' =>$_POST['jenis'],
                'sd_no' =>$_POST['no'],
                'sd_soal'=>$_POST['soal'],
                'sd_gambar' =>'',
                'sd_audio' =>$_FILES['berkas']['name'],
                'sd_a' =>$_POST['a'],
                'sd_b' =>$_POST['b'],
                'sd_kunci' =>$_POST['kunci'],
            ];

            $this->db->insert('detail_soal_benarsalah',$data);
            $id_soal = $this->db->insert_id();
        }

        if($_POST['jenis']=='esai'){

            $q=$this->db->select('sd_no,sd_detailid')->where('sd_master_soal',$_POST['master_id'])
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_esai')->row();

            if($q==NULL){
                    $_POST['sd_detailid']=1;
                    $_POST['no']=1;
            }else{
                $_POST['sd_detailid']=$q->sd_detailid+1;
                $_POST['no']=$q->sd_no+1;
            }


            $data=[
                'sd_master_soal' =>$_POST['master_id'],
                'sd_detailid' =>$_POST['sd_detailid'],
                'sd_type' =>$_POST['jenis'],
                'sd_no' =>$_POST['no'],
                'sd_soal'=>$_POST['soal'],
                'sd_note'=>$_POST['note'],
                'sd_gambar' =>'',
                'sd_audio' =>$_FILES['berkas']['name'],
               
            ];

            $this->db->insert('detail_soal_esai',$data);
            $id_soal = $this->db->insert_id();
        }


        $data['jenis']=$_POST['jenis'];

        $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        $data['xx'] = str_replace($western_arabic, $eastern_arabic, $_POST['no']);

        return array('status'=>true,'soal'=>$data);
        
       // return $this->db->insert('v_transaksi', $_POST);

    }

       public function insert_batch($id, $_data){
       // var_dump($_data);exit();
        /*
            $data=[
                'sd_master_soal' =>$_POST['master_id'],
                'sd_detailid' =>$_POST['sd_detailid'],
                'sd_type' =>$_POST['jenis'],
                'sd_no' =>$_POST['no'],
                'sd_soal'=>$_POST['soal'],
                'sd_gambar' =>'',
                'sd_audio' =>$_FILES['berkas']['name'],
                'sd_a' =>$_POST['a'],
                'sd_b' =>$_POST['b'],
                'sd_c' =>$_POST['c'],
                'sd_d' =>$_POST['d'],
                'sd_e' =>'',
                'sd_kunci' =>$_POST['kunci'],
            ];

        */
    $data=array();
            


    $row=count($_data)/5;
    //var_dump($row);exit();
        

        $ad=array('sd_soal'=>'','sd_a'=>'','sd_b'=>'','sd_c'=>'','sd_d'=>'');

        $xx=array();
        $r=0;
        for ($i=0; $i <2 ; $i++) {             
            for ($a=0; $a<5 ; $a++) {           
                
                if($a==0){
                    $data['sd_soal']=$_data[$r];
                }
                if($a==1){
                    $data['sd_a']=$_data[$r];                    
                }
                if($a==2){
                    $data['sd_b']=$_data[$r];                    
                }
                if($a==3){
                    $data['sd_c']=$_data[$r];                    
                }
                if($a==4){
                    $data['sd_d']=$_data[$r];                    
                }
                $r++;               
            }

            $data['sd_master_soal']=$id;
            $data['sd_type']=$_POST['type'];
            if($_POST['type']=='pilihan'){
                    $q=$this->db->select('sd_no,sd_detailid')->where('sd_master_soal',$id)
                    ->order_by('sd_detailid', 'desc')
                    ->get('detail_soal_pilihan')->row();

            if($q==NULL){
                    $data['sd_detailid']=1;
                    $data['sd_no']=1;
            }else{
                    $data['sd_detailid']=$q->sd_detailid+1;
                    $data['sd_no']=$q->sd_no+1;
            }

            $this->db->insert('detail_soal_pilihan',$data);
           
        }

            
            
            
    }
    }

    public function delete(){
        foreach ($_POST['d_id'] as $key => $v) {
            $this->db->select('t_nominal,t_a_code,t_jurnal');
            $this->db->where('t_id', $v);
            $transaksi=$this->db->get('v_transaksi')->row();

            $this->db->select('oa_saldo');
            $this->db->where('oa_id',$transaksi->t_a_code);
            $oa_saldo=$this->db->get('v_opening_account_bck')->row()->oa_saldo;

            $t_nominal=$transaksi->t_nominal*-1;

            $saldo=((int)$oa_saldo+(int)$t_nominal);

            $data_account=[
                'oa_saldo'=>$saldo
            ];

            $this->db->where('oa_id',$transaksi->t_a_code);
            $this->db->update('v_opening_account_bck', $data_account);

            $this->db->where('j_id', $transaksi->t_jurnal);
            $this->db->delete('v_jurnal');


        }

        $this->db->where_in('t_id', $_POST['d_id']);
        return $this->db->delete($this->table);
    }

    public function get_name($id){
        $this->db->select('t_id as id, t_a_code as name', false);
        $this->db->where_in('t_id', $id);
        return $this->db->get($this->table)->result();
    }

    public function get_matkul(){
        $this->db->select('m_id as id, m_nama as nama', false);        
        return $this->db->get('matkul')->result();
    }

}