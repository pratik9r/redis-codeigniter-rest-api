 
 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class educontroller extends CI_Controller{
    
    public function index(){
         $this->load->view('weatherview.php');
    }

    public function acceptform(){
       $this->load->model('EducationModel');
       $inserted_data = $this->EducationModel->insertData($_POST);
      
       $msg = $inserted_data['data'];
    //    if($msg['data']){
    //      $msg['msg'] ="form submitted successfully";
    //    }else{
    //     $msg['msg'] ="form not submitted";
    //    }
       
       echo json_encode($msg);
       
    }
}

?>