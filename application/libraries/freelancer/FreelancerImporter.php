<?php
namespace freelancer;
 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class FreelancerImporter
{
   private $ci;
   private $fieldInfos;
   private $freelancers;
   public $testMode;
   public function __construct()
   {
      $this->ci = &get_instance();
      $freelancerData = new FreelancerData();
      $this->freelancers = $freelancerData->GetData();
      $this->fieldInfos = [
         (object)array("newName"=>"비지니스","oldName"=>"biness","oldNameCount"=>"7"),
         (object)array("newName"=>"재무/회계","oldName"=>"jemu","oldNameCount"=>"7"),
         (object)array("newName"=>"법률/공증","oldName"=>"law","oldNameCount"=>"7"),
         (object)array("newName"=>"의학/과학","oldName"=>"science","oldNameCount"=>"7"),
         (object)array("newName"=>"IT/컴퓨터","oldName"=>"it","oldNameCount"=>"4"),
         (object)array("newName"=>"산업/기술","oldName"=>"san","oldNameCount"=>"12"),
         (object)array("newName"=>"인문/사회","oldName"=>"inmun","oldNameCount"=>"9"),
         (object)array("newName"=>"엔터테인먼트","oldName"=>"ent","oldNameCount"=>"7"),
         (object)array("newName"=>"예체능","oldName"=>"art","oldNameCount"=>"7"),
         (object)array("newName"=>"홈페이지","oldName"=>"homepage","oldNameCount"=>"2"),
         (object)array("newName"=>"일반","oldName"=>"illban","oldNameCount"=>"5"),
      ];
      $this->testMode = false;
   }
   public function getCount()
   {
         return count($this->freelancers);
   }
   public function import($start,$end)
   {
      //    $start = $config["start"];
      //    $end = $config["end"];
      set_time_limit(1800);
      $ci = $this->ci;
      echo "<br>";
      echo $start;
      echo "<br>";
echo $end;
echo "<br>";
      // foreach($this->freelancers as $row)
      for($j=(int)$start ; $j < (int)$end ; $j++)
      {
            echo "<br>";
            echo $j;
            $row= $this->freelancers[$j];
         $ci->db->trans_start();
         //기본 정보 추가
         $ci->db->set("profile_image",$row["userfile"]);
         $ci->db->set("name",$row["name"]);
         $ci->db->set("birth_year",$this->getBirthYearByBirth($row["birth"]));
         $ci->db->set("birth_month",$this->getBirthMonthByBirth($row["birth"]));
         $ci->db->set("birth_day",$this->getBirthDayByBirth($row["birth"]));
         $ci->db->set("old_address",$row["add"]);
         $ci->db->set("tel",$row["tel"]);
         $ci->db->set("phone",$row["mobile"]);
         $ci->db->set("email",$row["email"]);
         $ci->db->set("sex",$this->convertSex($row["sex"]));
         $ci->db->set("is_have_career",$this->convertGuToIsHaveCareer($row["gu"]));
         $ci->db->set("account_bank",$this->getAccountBankByAccuont($row["account"]));
         $ci->db->set("account_number",$this->getAccountNumberByAccuont($row["account"]));
         $ci->db->set("account_name",$this->getAccountNameByAccuont($row["account"]));
         $ci->db->set("nation",$row["nation"]) ;
         $ci->db->set("apply_field",$this->convertApplyField($row["jifield"]));
         $ci->db->set("translation_direction",$row["direction"]);
         $ci->db->set("university",$row["school"]);
         $ci->db->set("experience",$row["ex"]);
         $ci->db->set("etc",$row["ect"]);
         $ci->db->set("application_file_directory1",$this->convertEstimateToapplication_file_directory($row["estimate1"]));
         $ci->db->set("application_file_directory2",$this->convertEstimateToapplication_file_directory($row["estimate2"]));
         $ci->db->set("is_employed",$this->ConverJobToIsEmployed($row["job"]));
         $ci->db->set("can_working_day",$row["work"]);
         $ci->db->set("num_translation_per_day",$row["bun"]);
         $ci->db->set("admin_score",$row["pfile"]);
         $ci->db->set("admin_memo",$row["pfile1"]);
         $ci->db->set("created",$row["date"]);
         $ci->db->set("is_admin_confirm",$this->convertAdminSelectToIsAdminConfirm($row["AdminSelect"]));
         $ci->db->set("level",$row["sujun"]);
         $ci->db->insert("freelancer");
         $insertedFreelancerId = $ci->db->insert_id();

         //번역 언어 추가
         for ($i=1; $i <= 8; $i++) 
            $this->addLanguageToFreelancer($insertedFreelancerId,$row["language{$i}"]);
         $this->addLanguageToFreelancer($insertedFreelancerId,$row["languagee"]);

         //번역 분야 추가
         foreach ($this->fieldInfos as $fieldInfo) 
            for($i=1 ; $i <= (int)$fieldInfo->oldNameCount ; $i++)
               $this->addTranslationFieldToFreelancer($insertedFreelancerId,$fieldInfo->newName,$row["{$fieldInfo->oldName}{$i}"]);
         $this->addTranslationFieldToFreelancer($insertedFreelancerId,"기타",$row["selfinput"]);
            $this->ci->load->model("count_m");
            $this->ci->count_m->plusOneToField("num_freelancer");
         $ci->db->trans_complete();

         if ($ci->db->trans_status() === FALSE)
            echo "실패 :{$row['no']}  {$row['name']} <br>";
         if($this->testMode)
            return ;
      }
   }

   private function addLanguageToFreelancer($freelancer_id, $language)
   {
      if($language === null || $language === "" || $language === " ") 
         return;
      $this->ci->db->set("freelancer_id",$freelancer_id);
      $this->ci->db->set("language",$language);
      $this->ci->db->insert("freelancer_translation_language");
   }

   private function addTranslationFieldToFreelancer($freelancer_id,$field,$detail)
   {
      if($detail === null || $detail === "" || $detail === " "  )
         return;
      $this->ci->db->set("freelancer_id",$freelancer_id);
      $this->ci->db->set("field",$field);
      $this->ci->db->set("detail",$detail);
      $this->ci->db->insert("freelancer_translation_field");
   }

   private function convertEstimateToapplication_file_directory($estimate2)
   {
      $estimate2=str_replace("upload/","",$estimate2); 
      return "/public/upload/regacy/{$estimate2}";
   }

   private function getBirthYearByBirth($birth)
   {
      if($birth === null)
      return null;
      return mb_substr($birth,0,4);
   }

   private function getBirthMonthByBirth($birth)
   {
         if($birth === null)
         return null;
      return mb_substr($birth,7,2);
   }

   private function getBirthDayByBirth($birth)
   {
      if($birth === null)
      return null;
      return mb_substr($birth,12,2);
   }

   private function convertSex($sex)
   {
      if($sex === "남자")
         return "남성";
      else if ($sex === "여자")
         return "여성";
      else
         return null;
   }
   
   private function convertGuToIsHaveCareer($career)
   {
   if($career==="유경력자")
      return "1";
   else if($career ==="경력없음")
      return "0";
   else
      return null;  
   }

   private function getAccountBankByAccuont($account)
   {
      $endIndex = mb_strpos($account," 은행 계좌번호");
      return  mb_substr($account,0, $endIndex);
   }

   private function getAccountNumberByAccuont($account)
   {
      $startNeedle = "은행 계좌번호 ";
      $startIndex = mb_strpos($account,$startNeedle) + mb_strlen($startNeedle); 
      $endIndex = mb_strpos($account," 예금주");
      return  mb_substr($account,$startIndex, $endIndex- $startIndex);
   }

   private function getAccountNameByAccuont($account)
   {
      $startNeedle = "예금주 ";
      $startIndex = mb_strpos($account,$startNeedle) + mb_strlen($startNeedle); 
      return  mb_substr($account,$startIndex);
   }

   private function ConverJobToIsEmployed($job)
   {
      if($job ==="제직중")
         return 1;
      else if($job ==="무직")
         return 0;
      else
         return null;
   }

   private function convertApplyField($jifield)
   {
      if($jifield === "/번역")
         return "번역";
      else if($jifield === "통역/")
         return "통역";
      else if($jifield === "통역/번역")
         return "번역,통역";
      else
         return null;
   }

   private function convertAdminSelectToIsAdminConfirm($adminSelect)
   {
      if($adminSelect ==="yes")
         return 1;
      else 
         return 0;
   }

   private $testFreelancers = array(
      array('no' => '10','userfile' => 'upload/사진.jpg','name' => '박철민','birth' => '1978 년 06 월 20 일 ',
      'add' => '수원시 영통구 이의동 1326번지 이편한세상광교 6104동 703호','tel' => '010 - 9516 - 0419','mobile' => '010 - 9516 - 0419',
      'email' => 'bromike@naver.com / @','sex' => '남자','gu' => '유경력자','account' => '국민은행 은행 계좌번호 620-01-0629-728 예금주 박철민',
      'nation' => '-1, -2','jifield' => '/번역','language1' => '영어','language2' => '','language3' => '','language4' => '','language5' => '',
      'language6' => '','language7' => '','language8' => '','languagee' => '','direction' => '외국어<->한국어','sujun' => '상','biness1' => '',
      'biness2' => '','biness3' => '','biness4' => '','biness5' => '','biness6' => '','biness7' => '','jemu1' => '','jemu2' => '',
      'jemu3' => '','jemu4' => '','jemu5' => '','jemu6' => '','jemu7' => '','law1' => '','law2' => '','law3' => '','law4' => '','law5' => '',
      'law6' => '','law7' => '','science1' => '생명공학','science2' => '','science3' => '','science4' => '','science5' => '보고서',
      'science6' => '
      논문','science7' => '학술발표자료','it1' => '','it2' => '','it3' => '','it4' => '','san1' => '토목','san2' => '건설','san3' => '',
      'san4' => '','san5' => '선박','san6' => '','san7' => '자동차','san8' => '','san9' => '','san10' => '','san11' => '','san12' => '',
      'inmun1' => '사회','inmun2' => '','inmun3' => '역사','inmun4' => '교육','inmun5' => '','inmun6' => '정치','inmun7' => '보고서',
      'inmun8' => '논문','inmun9' => '학술발표자료','ent1' => '','ent2' => '','ent3' => '','ent4' => '','ent5' => '','ent6' => '',
      'ent7' => '','art1' => '','art2' => '','art3' => '','art4' => '체육','art5' => '','art6' => '','art7' => '','homepage1' => '',
      'homepage2' => '','illban1' => '','illban2' => '','illban3' => '에세이','illban4' => '','illban5' => '','selfinput' => '',
      'school' => '서울외국어대학원대학교 국제회의 졸업
      아주대학교 영어영문 / 국제통상 졸업
      영국 노팅엄대학교 교환학생 스포그램 수료','ex' => '아주대 간호대학 영문홈페이지 번역
      기타 이력서 참조바랍니다. ','ect' => '','estimate1' => 'upload/박철민_CV_통번역사.doc','estimate2' => '','job' => '제직중','work' => '야간',
      'bun' => '4','pfile' => '1','pfile1' => '','date' => '2013-03-11 17:26:17','AdminSelect' => 'yes'),
   );
}
?>