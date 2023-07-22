<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EducationModel extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function insertData($data)
     {
        
        $indata = array(
            'parentname'=> $data['parentsname'],
            'email'=> $data['emaila'],
            'mobileno'=> $data['mobileno'],
            'grades'=> $data['grades'],

        );
        $insert = $this->db->insert('parents',$indata);
        $getData = $this->db->get('parents');
        $data = $getData->result();
        
        if($data){
             
             $data['data'] = $data;
             return $data;
        }else{
            return false;
        }
       
     }
}?>