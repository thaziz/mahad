<?php

class Bank_soal_model extends CI_Model {

    



    private $pref = '';
    var $table = 'master_soal';
    var $column_order = array( 
                        'ms_id',
                        'ms_jenis_kel',
                        'ms_jenis_ujian',
                        'ms_matkul',
                        'ms_level',
                        'ms_kelas',
                        'ms_dosen',
                        'ms_startdate',
                        'ms_enddate',
                        'ms_starttime' ,
                        'ms_endtime' ,
                        'ms_created',
                        'ms_created_by',
                        'ms_waktu',
                        );
    var $column_search =array( 
                        'ms_id',
                        'ms_jenis_kel',
                        'ms_jenis_ujian',
                        'ms_matkul',
                        'ms_level',
                        'ms_kelas',
                        'ms_dosen',
                        'ms_startdate',
                        'ms_enddate',
                        'ms_starttime' ,
                        'ms_endtime' ,
                        'ms_created',
                        'ms_created_by',
                        'ms_waktu',
                        );
    var $order = array('ms_id' => 'asc');

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




    public function insert(){

        $sdate = date('Y-m-d', strtotime($_POST['tanggal']));

        $status = (isset($_POST['status']) ? 1 : 0);
        $data=[
            'ms_jenis_kel' =>$_POST['jk'],
            'ms_jenis_ujian'=>$_POST['jenis'],
            'ms_matkul' =>$_POST['matkul'],
            'ms_level' =>$_POST['level'],
            'ms_kelas' =>$_POST['kelas'],
            'ms_dosen' =>$this->session->userdata('id'),
            'ms_startdate' =>$sdate,            
            'ms_starttime' => date('H:i:s', strtotime($_POST['stime_perday'])),
            'ms_endtime' => date('H:i:s', strtotime($_POST['etime_perday'])),
            'ms_created' =>date('Y-m-d H:i:s'),
            'ms_created_by' =>$this->session->userdata('id'),
           // 'ms_waktu' =>$_POST['waktu'],
            'ms_status' =>$status,
        ];

        $this->db->insert('master_soal',$data);
        $id_soal = $this->db->insert_id();
        return array('status'=>true,'id'=>$id_soal);
        
       // return $this->db->insert('v_transaksi', $_POST);

    }



     public function update(){

        $sdate = date('Y-m-d', strtotime($_POST['tanggal']));

        $status = (isset($_POST['status']) ? 1 : 0);
        $data=[
            'ms_jenis_kel' =>$_POST['jk'],
            'ms_jenis_ujian'=>$_POST['jenis'],
            'ms_matkul' =>$_POST['matkul'],
            'ms_level' =>$_POST['level'],
            'ms_kelas' =>$_POST['kelas'],
            'ms_dosen' =>$this->session->userdata('id'),
            'ms_startdate' =>$sdate,            
            'ms_starttime' => date('H:i:s', strtotime($_POST['stime_perday'])),
            'ms_endtime' => date('H:i:s', strtotime($_POST['etime_perday'])),
            'ms_created' =>date('Y-m-d H:i:s'),
            'ms_created_by' =>$this->session->userdata('id'),
           // 'ms_waktu' =>$_POST['waktu'],
            'ms_status' =>$status,
        ];
        $this->db->where('ms_id',$_POST['id_master']);
        $this->db->update('master_soal',$data);
        //$id_soal = $this->db->insert_id();
        return array('status'=>true);
        
       // return $this->db->insert('v_transaksi', $_POST);

    }



    public function insert_detail(){

    //image
      // $config['upload_path']          = './gambar/';
       $config['allowed_types']        = 'gif|jpg|png';
       $config['max_size']             = 1020040000;
       /* $config['max_width']            = 1024;
       $config['max_height']           = 768;*/

       $path = '/images/' . date('Y-m-d') . '/';
       if (!is_dir($dirg = 'assets' . $path)) {
        mkdir($dirg);
    }
    //$config['allowed_types'] = '*';
    $config['upload_path']   = $dirg;
    $this->load->library('upload', $config);
    if(!empty($_FILES['gambar']['name'])) {
        $dname = explode(".", $_FILES['gambar']['name']);
        $ext = end($dname);

        $_FILES['gambar']['name'] =strtolower('gambar'.date('YmdHis').'.'.$ext);
        if ( ! $this->upload->do_upload('gambar')){
             $error = array('status'=>false,'error' => $this->upload->display_errors());
            return $error;
        }else{
            $data = array('upload_data' => $this->upload->data());
        }
        $_FILES['gambar']['name'] =strtolower('gambar'.date('YmdHis').'.'.$ext);

    }


    //audio
    unset($config);

       // $config['upload_path']          = './gambar/';
       // $config['allowed_types']        = 'gif|jpg|png|wav';
       $config['max_size']             = 1020040;
       $config['overwrite']=false;
       /* $config['max_width']            = 1024;
       $config['max_height']           = 768;*/

       $path = '/uploads/' . date('Y-m-d') . '/';
       if (!is_dir($dir = 'assets' . $path)) {
        mkdir($dir);
    }
    $config['allowed_types'] = 'wav';
    $config['upload_path']   = $dir;

    

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    //var_dump($_FILES['berkas']['name']);exit();
    if(!empty($_FILES['berkas']['name'])) {
        $dname = explode(".", $_FILES['berkas']['name']);
        $ext = end($dname);

        $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);

        if ( ! $this->upload->do_upload('berkas')){
              $error = array('status'=>false,'error' => $this->upload->display_errors());
            return $error;
        }else{
            $data = array('upload_data' => $this->upload->data());
        }
        $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);

    }



        if($_FILES['gambar']['name']!=''){
            $_FILES['gambar']['name']=$dirg.$_FILES['gambar']['name'];
        }else if($_FILES['gambar']['name']==''){
            $_FILES['gambar']['name']=$_POST['sd_gambar'];
        }

        if($_FILES['berkas']['name']!=''){
            $_FILES['berkas']['name']=$dir.$_FILES['berkas']['name'];
        }else if($_FILES['gambar']['name']==''){
            $_FILES['berkas']['name']=$_POST['sd_audio'];

        }


    if($_POST['jenis']=='pilihan'){

        $q=$this->db->select('sd_detailid')->where('sd_master_soal',$_POST['master_id'])
        ->order_by('sd_detailid', 'desc')
        ->get('detail_soal_pilihan')->row();


        if($q==NULL){
            $_POST['sd_detailid']=1;
            $_POST['no']=1;
        }else{
            $_POST['sd_detailid']=$q->sd_detailid+1;
            
        }


        $data=[
            'sd_master_soal' =>$_POST['master_id'],
            'sd_detailid' =>$_POST['sd_detailid'],
            'sd_type' =>$_POST['jenis'],            
            'sd_soal'=>$_POST['soal'],
            'sd_header'=>$_POST['lheader'],
            'sd_subheader'=>$_POST['subheader'],
            'sd_cerita'=>$_POST['cerita'],

            'sd_gambar' =>$_FILES['gambar']['name'],
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


       // var_dump($_POST);exit();
    if($_POST['jenis']=='bs'){

        $q=$this->db->select('sd_detailid')->where('sd_master_soal',$_POST['master_id'])
        ->order_by('sd_detailid', 'desc')
        ->get('detail_soal_benarsalah')->row();

        if($q==NULL){
            $_POST['sd_detailid']=1;
            $_POST['no']=1;
        }else{
            $_POST['sd_detailid']=$q->sd_detailid+1;         
        }


        $data=[
            'sd_master_soal' =>$_POST['master_id'],
            'sd_detailid' =>$_POST['sd_detailid'],
            'sd_type' =>$_POST['jenis'],
            'sd_soal'=>$_POST['soal'],
            'sd_gambar' =>$_FILES['gambar']['name'],
            'sd_audio' =>$_FILES['berkas']['name'],
            'sd_a' =>$_POST['a'],
            'sd_b' =>$_POST['b'],
            'sd_kunci' =>$_POST['kunci'],
        ];

        $this->db->insert('detail_soal_benarsalah',$data);
        $id_soal = $this->db->insert_id();
    }

    if($_POST['jenis']=='esai'){

        $q=$this->db->select('sd_detailid')->where('sd_master_soal',$_POST['master_id'])
        ->order_by('sd_detailid', 'desc')
        ->get('detail_soal_esai')->row();

        if($q==NULL){
            $_POST['sd_detailid']=1;
            $_POST['no']=1;
        }else{
            $_POST['sd_detailid']=$q->sd_detailid+1;
        }


        $data=[
            'sd_master_soal' =>$_POST['master_id'],
            'sd_detailid' =>$_POST['sd_detailid'],
            'sd_type' =>$_POST['jenis'],
            'sd_soal'=>$_POST['soal'],
            'sd_gambar' =>$_FILES['gambar']['name'],
            'sd_audio' =>$_FILES['berkas']['name'],

        ];

        $this->db->insert('detail_soal_esai',$data);
        $id_soal = $this->db->insert_id();
    }


    $data['jenis']=$_POST['jenis'];
    $data['id_soal']=$id_soal;

    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
    $data['xx'] = str_replace($western_arabic, $eastern_arabic, $_POST['no']);
    $data['status']=true;

    return $data;

       // return $this->db->insert('v_transaksi', $_POST);

}

public function insert_batch($id, $_data){
    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
//var_dump($_POST);exit();
    $data=array();
    $data2=array();

    if($_POST['type']=='pilihan'){
    foreach ($_data as $k => $v) {
        $data['sd_soal']=$v[0];
        $data['sd_kunci']=$v[1];
        $data['sd_a']=$v[2];  
        $data['sd_b']=$v[3];  
        $data['sd_c']=$v[4];  
        $data['sd_d']=$v[5];    


        $data['sd_master_soal']=$id;
        $data['sd_type']=$_POST['type'];

            $q=$this->db->select('sd_detailid')->where('sd_master_soal',$id)
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_pilihan')->row();

            if($q==NULL){
                $data['sd_detailid']=1;
            }else{
                $data['sd_detailid']=$q->sd_detailid+1;
            }

            $this->db->insert('detail_soal_pilihan',$data);
            $data2[]=$data;
        }

       /* foreach ($data2 as $k => $v) {
            $data2[$k]['xx'] = str_replace($western_arabic, $eastern_arabic, $v['sd_no']);
        }*/


        return $data2;
    }    

    //upload bn


    if($_POST['type']=='bs'){
        
    foreach ($_data as $k => $v) {
        $data['sd_soal']=$v[0];
        $data['sd_kunci']=$v[1];
        $data['sd_a']=$v[2];  
        $data['sd_b']=$v[3];    


        $data['sd_master_soal']=$id;
        $data['sd_type']=$_POST['type'];

            $q=$this->db->select('sd_detailid')->where('sd_master_soal',$id)
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_benarsalah')->row();

            if($q==NULL){
                $data['sd_detailid']=1;
            }else{
                $data['sd_detailid']=$q->sd_detailid+1;
            }

            $this->db->insert('detail_soal_benarsalah',$data);
            $data2[]=$data;
        }

        /*foreach ($data2 as $k => $v) {
            $data2[$k]['xx'] = str_replace($western_arabic, $eastern_arabic, $v['sd_no']);
        }*/


        return $data2;
    }       


    /*upload esai*/   
    
    if($_POST['type']=='esai'){
    foreach ($_data as $k => $v) {
        $data['sd_soal']=$v[0];  


        $data['sd_master_soal']=$id;
        $data['sd_type']=$_POST['type'];

            $q=$this->db->select('sd_detailid')->where('sd_master_soal',$id)
            ->order_by('sd_detailid', 'desc')
            ->get('detail_soal_esai')->row();

            if($q==NULL){
                $data['sd_detailid']=1;                
            }else{
                $data['sd_detailid']=$q->sd_detailid+1;                
            }

            $this->db->insert('detail_soal_esai',$data);
            $data2[]=$data;
        }

        /*foreach ($data2 as $k => $v) {
            $data2[$k]['xx'] = str_replace($western_arabic, $eastern_arabic, $v['sd_no']);
        }*/


        return $data2;
    }       
}




public function update_detail(){
    //image
      // $config['upload_path']          = './gambar/';
       $config['allowed_types']        = 'gif|jpg|png';
       $config['max_size']             = 1020040000;
       /* $config['max_width']            = 1024;
       $config['max_height']           = 768;*/

       $path = '/images/' . date('Y-m-d') . '/';
       if (!is_dir($dirg = 'assets' . $path)) {
        mkdir($dirg);
    }
    //$config['allowed_types'] = '*';
    $config['upload_path']   = $dirg;
    $this->load->library('upload', $config);
    if(!empty($_FILES['gambar']['name'])) {
        $dname = explode(".", $_FILES['gambar']['name']);
        $ext = end($dname);

        $_FILES['gambar']['name'] =strtolower('gambar'.date('YmdHis').'.'.$ext);
        if ( ! $this->upload->do_upload('gambar')){
            $error = array('status'=>false,'error' => $this->upload->display_errors());
            return $error;
        }else{
            $data = array('upload_data' => $this->upload->data());
        }
        $_FILES['gambar']['name'] =strtolower('gambar'.date('YmdHis').'.'.$ext);

    }


    //audio
    unset($config);

       // $config['upload_path']          = './gambar/';
       // $config['allowed_types']        = 'gif|jpg|png|wav';
       $config['max_size']             = 1020040;
       $config['overwrite']=false;
       /* $config['max_width']            = 1024;
       $config['max_height']           = 768;*/

       $path = '/uploads/' . date('Y-m-d') . '/';
       if (!is_dir($dir = 'assets' . $path)) {
        mkdir($dir);
    }
    $config['allowed_types'] = 'wav';
    $config['upload_path']   = $dir;

    

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    //var_dump($_FILES['berkas']['name']);exit();
    if(!empty($_FILES['berkas']['name'])) {
        $dname = explode(".", $_FILES['berkas']['name']);
        $ext = end($dname);

        $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);

        if ( ! $this->upload->do_upload('berkas')){
            $error = array('status'=>false,'error' => $this->upload->display_errors());
            return $error;
        }else{
            $data = array('upload_data' => $this->upload->data());
        }
        $_FILES['berkas']['name'] =strtolower('audio'.date('YmdHis').'.'.$ext);

    }


        if($_FILES['gambar']['name']!=''){
            $_FILES['gambar']['name']=$dirg.$_FILES['gambar']['name'];
        }else if($_FILES['gambar']['name']==''){
            $_FILES['gambar']['name']=$_POST['sd_gambar'];
        }

        if($_FILES['berkas']['name']!=''){
            $_FILES['berkas']['name']=$dir.$_FILES['berkas']['name'];
        }else if($_FILES['gambar']['name']==''){
            $_FILES['berkas']['name']=$_POST['sd_audio'];

        }

    if($_POST['jenis']=='pilihan'){
        
        $data=[
            'sd_type' =>$_POST['jenis'],            
            'sd_soal'=>$_POST['soal'],
            'sd_header'=>$_POST['lheader'],
            'sd_subheader'=>$_POST['subheader'],
            'sd_cerita'=>$_POST['cerita'],

            'sd_gambar' =>$_FILES['gambar']['name'],
            'sd_audio' =>$_FILES['berkas']['name'],
            'sd_a' =>$_POST['a'],
            'sd_b' =>$_POST['b'],
            'sd_c' =>$_POST['c'],
            'sd_d' =>$_POST['d'],
            'sd_e' =>'',
            'sd_kunci' =>$_POST['kunci'],
        ];


        $this->db->where('sd_master_soal',$_POST['sd_master_soal']);
        $this->db->where('sd_detailid',$_POST['sd_detailid']);
        $update_soal=$this->db->update('detail_soal_pilihan',$data);
    }


       // var_dump($_POST);exit();
    if($_POST['jenis']=='bs'){

        $data=[
            'sd_type' =>$_POST['jenis'],            
            'sd_soal'=>$_POST['soal'],
            'sd_gambar' =>$_FILES['gambar']['name'],
            'sd_audio' =>$_FILES['berkas']['name'],
            'sd_a' =>$_POST['a'],
            'sd_b' =>$_POST['b'],
            'sd_kunci' =>$_POST['kunci'],
        ];


        $this->db->where('sd_master_soal',$_POST['sd_master_soal']);
        $this->db->where('sd_detailid',$_POST['sd_detailid']);
        $update_soal=$this->db->update('detail_soal_benarsalah',$data);
    }

    if($_POST['jenis']=='esai'){
        $data=[
            'sd_type' =>$_POST['jenis'],         
            'sd_soal'=>$_POST['soal'],
            'sd_gambar' =>$_FILES['gambar']['name'],
            'sd_audio' =>$_FILES['berkas']['name'],

        ];

        
        $this->db->where('sd_master_soal',$_POST['sd_master_soal']);
        $this->db->where('sd_detailid',$_POST['sd_detailid']);
        $update_soal=$this->db->update('detail_soal_esai',$data);
    }


    $data['jenis']=$_POST['jenis'];
   /* $data['id_soal']=$id_soal;*/

    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
    /*$data['xx'] = str_replace($western_arabic, $eastern_arabic, $_POST['no']);*/

    $data['sd_master_soal']=$_POST['sd_master_soal'];
    $data['sd_detailid']=$_POST['sd_detailid'];
    $data['status']=true;
    
    return $data;
}

public function delete(){
        
    if($_POST['tipe']=='pilihan'){
        $this->db->where('sd_master_soal',$_POST['master']);
        $this->db->where('sd_detailid',$_POST['detail']);
        $delete=$this->db->delete('detail_soal_pilihan');
    }


       // var_dump($_POST);exit();
    if($_POST['tipe']=='bs'){
        $this->db->where('sd_master_soal',$_POST['master']);
        $this->db->where('sd_detailid',$_POST['detail']);
        $delete=$this->db->delete('detail_soal_benarsalah');
    }

    if($_POST['tipe']=='esai'){
        $this->db->where('sd_master_soal',$_POST['master']);
        $this->db->where('sd_detailid',$_POST['detail']);
        $delete=$this->db->delete('detail_soal_esai');
    }

    if($delete==true){
        $_POST['status']=true;
        return $_POST;
    }else{
        $_POST['status']=false;
        return $_POST;
    }



}

public function get_name($id){
    $this->db->select('t_id as id, t_a_code as name', false);
    $this->db->where_in('t_id', $id);
    return $this->db->get($this->table)->result();
}

public function get_matkul(){
    $this->db->select('id_subject as id, subject_ar_name as nama', false);        
    return $this->db->get('db_subject')->result();
}
public function edit_data($id){
    $this->db->select('*', false);      
    $this->db->where('ms_id', $id);  
    $data['master1']=$this->db->get('master_soal');

    if($data['master1']->num_rows()<=0){
        return array('status' =>false ,'info'=>"Ma'af, Data tidak ditemukan");
        exit();
    }
    $data['master']=$data['master1']->row();



    $this->db->select('*', false);     
    $this->db->where('sd_master_soal', $id);   
    $this->db->order_by('sd_detailid','asc');   
    $data['pilihan']=$this->db->get('detail_soal_pilihan')->result();

    $this->db->select('*', false); 
    $this->db->where('sd_master_soal', $id);  
    $this->db->order_by('sd_detailid','asc');     
    $data['bs']=$this->db->get('detail_soal_benarsalah')->result();

    $this->db->select('*', false); 
    $this->db->where('sd_master_soal', $id);   
    $this->db->order_by('sd_detailid','asc');   
    $data['esai']=$this->db->get('detail_soal_esai')->result();
    $data['status']=true;
    return $data;
}

public function edit_detail(){
    $id=$_POST['master'];
    $detail=$_POST['detail'];
    if($_POST['tipe']=='pilihan'){
        $this->db->select('*', false);     
        $this->db->where('sd_master_soal', $id);  
        $this->db->where('sd_detailid', $detail);
        $data['pilihan']=$this->db->get('detail_soal_pilihan')->row();
    }else if($_POST['tipe']=='bs'){
        $this->db->select('*', false); 
        $this->db->where('sd_master_soal', $id);  
        $this->db->where('sd_detailid', $detail);    
        $data['bs']=$this->db->get('detail_soal_benarsalah')->row();
    }else if($_POST['tipe']=='esai'){
        $this->db->select('*', false); 
        $this->db->where('sd_master_soal', $id);   
        $this->db->where('sd_detailid', $detail);     
        $data['esai']=$this->db->get('detail_soal_esai')->row();
        $data['status']=true;
    }
    return $data;
}
}