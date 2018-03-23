<?php 
namespace payapp;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->get = true;
        // $this->list = true;
        // $this->add = true;
        // $this->update = true;
        // $this->delete = true;
        // $this->noDisplay = true;
    }
    public function add()
    {
        $this->load->helper('payapp');
        
        /*
        TODO : 이곳에서 결제요청전 정보를 저장합니다.
        
        ex) INSERT INTO payrequest (orderno,memberid,goodcode,goodname,goodprice) VALUES ('1234567890','kim','abcdefg','테스트상품',1000)
        */
        
        // 결제요청 정보(파라메터 목록을 참고하세요)
        // payapp_popup.php에서 전달한 변수들을 POST로 받아서 정의합니다.
        // test시 임의의 값으로 정의하셔도 무방합니다.
        $cmd         = "payrequest";           // 결제요청, 필수
        $userid      = "payapptest";           // 판매자 아이디, 필수
        $goodname    = $_POST['goodname'];
        $price       = $_POST['price'];
        $recvphone   = $_POST['recvphone'];
        $memo        = "결제요청 테스트 메모";
        $reqaddr     = 0;
        $feedbackurl = "http://고객사 도메인/payapp_feedbackurl.php";
        $var1        = $_POST['var1'];
        $var2        = $_POST['var2'];
        $smsuse      = "n";
        $reqmode     = "krw";
        $vccode      = "";
        $returnurl   = "http://고객사 도메인/결제완료페이지.php";
        $openpaytype = "card";
        $checkretry  = "y";
        
        $postdata = array(
            'cmd'           => $cmd,
            'userid'        => $userid,
            'goodname'      => $goodname,
            'price'         => $price,
            'recvphone'     => $recvphone,
            'memo'          => $memo,
            'reqaddr'       => $reqaddr,
            'feedbackurl'   => $feedbackurl,
            'var1'          => $var1,
            'var2'          => $var2,
            'smsuse'        => $smsuse,
            'reqmode'       => $reqmode,
            'vccode'        => $vccode,
            'returnurl'     => $returnurl,
            'openpaytype'   => $openpaytype,
            'checkretry'    => $checkretry
        );
        
        $oResData = payapp_oapi_post($postdata);
        if ($oResData['state'] == '1') {
            // 결제요청성공
            // 결제요청번호($oResData['mul_no'])를 고객사 DB에 저장해 놓으셔야 합니다.
            // 요청이 성공한 것으로 결제완료 상태가 아닙니다. 여기에서 상품배송/서비스 제공을 하면 안됩니다.
            // 결제완료는 feedbackurl에서만 확인이 가능합니다.
            /*
            $oResData['mul_no'];    // 결제요청번호
            $oResData['payurl'];    // 결제창 URL
            */
        
            /*
            # TODO : 이곳에서 결제요청 성공 정보를 저장합니다.
            ex) UPDATE payrequest SET mul_no='{$oResData['mul_no']}' WHERE orderno='1234567890'
            */
        
            /*
            # TODO : 아래처럼 'payurl'로 페이지를 이동 하시면 결제할 수 있는 페이지가 열립니다.
            echo <<<EOT
            <script type='text/javascript'>
                location.href = '{$oResData['payurl']}';
            </script>
            EOT;
            */
        
        } else {
            // 결제요청실패
            // 오류메시지($oResData['errorMessage'])를 확인하고, 오류를 수정하셔야 합니다.
            /*
            $oResData['errorMessage'];    // 오류메시지
            $oResData['errno'];            // 오류코드
            */
        
            /*
            TODO : 이곳에서 결제요청 실패 정보를 저장하거나, 이전 페이지로 이동해서 다시 시도할 수 있도록 해야 합니다.
        
            ex) UPDATE payrequest SET errorMessage='{$oResData['errorMessage']}' WHERE orderno='1234567890'
            */
            /*
            echo <<<EOT
            <script type='text/javascript'>
                alert('{$oResData['errorMessage']}');
                window.close();
            </script>
            EOT;
            */
    }

//     public function get($id)
//     {
//         parent::get($id);
//     }
//     public function list()
//     {
//         parent::list();
//     }
//     public function add()
//     {
//         parent::add();
//     }
//     public function update($id)
//     {
//         parent::update($id);
//     }
//     public function delete($id)
//     {
//         parent::_ajaxDelete($id);
//     }
}

/* End of file Admin.php */

?>