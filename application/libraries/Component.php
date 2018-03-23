<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Component
{
    protected $ci;
    public $searchURL = "/admin/list";
    private $sw_summernoteScript = false;
    private $sw_image = false;
    private $sw_inputSearch = false;
    public function __construct()
    {
        $this->ci =& get_instance();
    }
    
    public function getTreeviewData($rows)
    {
        if(count($rows) === 0) return;
        foreach ($rows as $row) 
        {
            $addBtn=$this->variable(["component"=>"add","action"=>"/admin/".$this->ci->router->fetch_module()."/add?parent_id={$row->id}"]);
            $updateBtn=$this->variable(["component"=>"update","action"=>"/admin/".$this->ci->router->fetch_module()."/update/{$row->id}"]);
            $deleteBtn=$this->variable(["component"=>"ajaxDelete","action"=>"/admin/".$this->ci->router->fetch_module()."/delete/{$row->id}"]);
            $ajaxAlterSortForm=$this->variable(["component"=>"ajaxAlterSortForm","action"=>"/admin/".$this->ci->router->fetch_module()."/update/{$row->id}","row"=>$row]);
            $displayBtn=$this->variable(["component"=>"display","action"=>"/admin/".$this->ci->router->fetch_module()."/display/{$row->id}","row"=>$row]);
            $noDisplayBtn=$this->variable(["component"=>"noDisplay","action"=>"/admin/".$this->ci->router->fetch_module()."/noDisplay/{$row->id}","row"=>$row]);
            $sub_data["id"] = $row->id;
            $sub_data["name"] = $row->name;
            $sub_data["text"] = $row->id."&nbsp;&nbsp;|&nbsp;&nbsp;".$row->name."&nbsp;&nbsp;|&nbsp; 보이기".$row->is_display.$ajaxAlterSortForm.$addBtn.$updateBtn.$displayBtn.$noDisplayBtn.$deleteBtn;
            // $sub_data["selectable"] = false;
            // $sub_data["text"] = $row["name"];
            $sub_data["parent_id"] = $row->parent_id;
            $tree[] = $sub_data;

        }
      
        foreach ($tree as $key => &$row)
        {
            $tmpTree[$row["id"]] = &$row;
        }
      
        // var_dump($tree);
        foreach ($tmpTree as $key=>&$row)
         {
            if ($row["parent_id"] && isset($tmpTree[$row["parent_id"]])) 
            {
                $tmpTree[$row["parent_id"]]["nodes"][] = &$row;
            }
        }
    
        foreach ($tree as $key => &$row)
        {
            if ($row["parent_id"] && isset($tmpTree[$row["parent_id"]])) 
            {
                unset($tree[$key]);
            }
        }
        $tree = array_values($tree);
        
        return base64_encode(json_encode($tree));
    }

    public function variable($config)
    {
        $component = $config["component"];
        ob_start();
        $this->$component($config);
        return ob_get_clean();
    }
    public function add($config)
    {
        $action = $config["action"];
        ?> <button type="button" class="btn btn-default clickable"  onclick="document.location = $(this).data('href');" data-href="<?=my_site_url($action)?>">추가</button><?php
    }
    public function update($config)
    {
        $action = $config["action"];
        ?> 
            <button type="button"class="btn btn-default clickable "style="height:30px; padding-top:4px;"onclick="document.location = $(this).data('href');"   data-href="<?=my_site_url($action)?>">수정</button>
        <?php
    }
    public function ajaxDelete($config)
    {
        $action = $config["action"];
        ?><button class="btn btn-default" <?=$this->ci->ajax_helper->anchor(my_site_url($action),"복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?> >삭제</button><?php
    }
    public function display($config)
    {
        $action = $config["action"];
        ?>
        <button type="button" style="height:30px; padding-top:4px;" class="btn btn-default " <?=$this->ci->ajax_helper->anchor($action)?> >보이기</button>
        <?php
    }
    public function noDisplay($config)
    {
        $action = $config["action"];
        ?>
        <button type="button" style="height:30px; padding-top:4px;" class="btn btn-default " <?=$this->ci->ajax_helper->anchor($action)?> >안보이기</button>
        <?php
    }
    public function ajaxAlterSortForm($config)
    {
        $action = $this->assingVariable_fromConfig("action",$config);
        $this->row = $row = $config["row"];
        if(is_array($row)) $row = (object)$row;

?>
     <form style="display:inline-block" <?=$this->ci->ajax_helper->form(my_site_url($action))?>>
            <input class="form-control" style="width:60px;display:inline-block;" name="sort"  type="text" value=<?=my_set_value($row,"sort")?>>    
            <button class="btn btn-default" onclick="$(this).parents('form').eq(0).submit();">순서수정</button>
        </form>    
<?php 
    }
    
    public function ajaxImage($config)
    {
        
        if(!isset($config["inputName"])) throw new RuntimeException("need inputName");
        $inputName =$config["inputName"] ;
        if(!isset($config["row"])) throw new RuntimeException("need row");
        $row =$config["row"] ;
        $displayName =$config["displayName"] ;
        $imageSize =$config["imageSize"] ??"300";

        ?>
        <div class="ci-component ci-image">
        <div class="form-group">
            <label for="<?=$displayName?>"><?=$displayName?></label>
            <input type='file' style='visibility:hidden; height:0'  accept="image/*">
            <input type="hidden" name="<?=$inputName?>" value="<?=my_set_value($row,$inputName)?>">

            <div class="input-group input-file" >
                <span class="input-group-btn">
                    <button class="btn-file btn btn-default btn-choose" type="button">선택</button>
                </span>
                <input type="text" class="form-control" placeholder='선택된 파일 없음' />
                <!-- 삭제 -->
                <!-- <span class="input-group-btn">
                    <button class="btn btn-warning btn-reset" type="button">삭제</button>
                </span> -->
            </div>
            
        </div>
        <div class="form-group">
            <img class="img-thumbnail" style="width:<?=$imageSize?>px"   src="<?=my_set_value($row,$inputName)?>">
        </div>

           
        </div>
        <?php if($this->sw_image === true) return; 
        $this->sw_image = true;
        ?>
       
        <script>
        $(document).ready(function(){
            // 삭제
            // $(".ci-component.ci-image .btn-reset").click(function(){
            //     $this = $(this);
            //     let $ci_component = $this.parents(".ci-component").eq(0);
            //     $inputText =$ci_component.find("input[type=text]").eq(0);
            //     $inputText.val("");
            // });
            // 선택
            $(".ci-component.ci-image .btn-file").click(function()
            {
                $this = $(this);
                let $ci_component = $this.parents(".ci-component").eq(0);
                $inputFile =$ci_component.find("input[type=file]").eq(0);
                $inputFile.click();
                    // return false;
            });
            
            //ajax
            $(".ci-component.ci-image input[type=file]").change(function(){
                $this = $(this);
                let $ci_component = $this.parents(".ci-component").eq(0);
                let $inputText = $ci_component.find("input[type=text]").eq(0);
                $inputText.val(($this.val()).split('\\').pop());

                let files=this.files;
                let url = "/uploadImage";

                formData = new FormData();
                for (let i = 0; i < files.length; i++) {
                    formData.append("files[]", files[i]);
                }
                $.ajax({
                    // ajax를 통해 파일 업로드 처리
                    data: formData,
                    type: "POST",
                    url: url,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (data) {
                    
                        let files = data.files;
                        let result = files[0].result;
                        if (result === "success") {
                            $ci_component = $this.parents(".ci-component").eq(0);
                            $ci_component.find("img").attr("src",files[0].uri);
                            $ci_component.find("input[type=hidden]").val(files[0].uri);
                        }
                        else if (result === "fail")
                        {
                        }
                        
                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert('에러... or 데이터 용량이 너무많습니다.');
                        $('.loading').fadeOut(500);
                        console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                        console.log(errorThrown);
                    }

                });
                        
            });

            // $inputFile = $(".ci-component.ci-image input[type=file]");
            // $inputFile.change(function(){
            //     $this = $(this);
                
            // });
        
        });
        </script>
       
        <?php
    }
    public function text($config)
    {
        if(!isset($config["fieldName"])) throw new RuntimeException("need fieldName");
        $fieldName =$config["fieldName"] ;
        if(is_array($fieldName) === false)
        {
            $fieldName = [$fieldName];
        }
        if(!isset($config["displayName"])) throw new RuntimeException("need displayName");
        $displayName =$config["displayName"] ;
        if(is_array($displayName) === false)
        {
            $displayName = [$displayName];
        }

        if(!isset($config["row"])) throw new RuntimeException("need row");
        $this->row = $row =$config["row"] ;
        $displayName =$config["displayName"] ;
        $href =$this->assingVariable_fromConfig("href",$config);
        ?>
            
        <?php if ( $href !== "" ): ?>
        <a target="_blank" href="<?=$href?>">
        <?php endif; ?>
            <?php $i=0; foreach ( $fieldName  as $fieldnameItem ): ?>
            <div class="form-group">
            
                <label><?=$displayName[$i]?></label>
                <span><?=$row->$fieldnameItem ?? ""?></span>
            </div>
            <?php $i++; endforeach; ?>
        <?php if ( $href !== "" ): ?>
        </a>
        <?php endif; ?>
        <?php 
    }

    public function textarea($config)
    {
        if(!isset($config["inputName"])) throw new RuntimeException("need inputName");
        $inputName =$config["inputName"] ;
        if(!isset($config["row"])) throw new RuntimeException("need row");
        $row =$config["row"] ;
        $displayName =$config["displayName"] ;

        ?>
        <div class="form-group">
        <label for="<?=$displayName?>"><?=$displayName?></label>
        <textarea class="form-control" name="<?=$inputName?>" cols="30" rows="10"><?=my_set_value($row,$inputName)?></textarea>
        </div>
        <?php
    }
    
    public function summernote($config)
    {
        if(!isset($config["inputName"])) throw new RuntimeException("need inputName");
        $inputName =$config["inputName"] ;
        if(!isset($config["row"])) throw new RuntimeException("need row");
        $row =$config["row"] ;
        $displayName =$config["displayName"] ;
        ?>
        <div class="ci-component ci-summernote">
            <label for=""><?=$displayName?></label>
            <div class="editor"></div>
            <input class="editor-input" type="hidden" name="<?=$inputName?>" value='<?=my_set_value($row,$inputName)?>'>
         
        </div>
        <?php if($this->sw_summernoteScript === true) return; 
        $this->sw_summernoteScript = true;
        ?>
        <script>  
        $(document).ready(function(){
          
            //서머노트 위지위그 정의 시작
            $editor =$('.ci-component.ci-summernote .editor');    
            $editor.summernote({
                    placeholder: '내용',
                    tabsize: 2, // height: 100,
                    minHeight: 500, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false, // set focus to editable area after initializing summe
                    dialogsInBody: true,
                    dialogsFade: true,
                    callbacks: {
                        onImageUpload: function (files) {
                            formData = new FormData();
                            for (let i = 0; i < files.length; i++) {
                                formData.append("files[]", files[i]);
                            }
                            sendImages(formData, this);
                        },
                        onInit: function () {
                            $this = $(this);
                            $ci_component = $this.parents(".ci-component").eq(0);
                            $this.summernote('code', $ci_component.find(".editor-input").val());
                        },
                        onBlur: function() {
                            $this = $(this);
                            $ci_component = $this.parents(".ci-component").eq(0);
                            $ci_component.find(".editor-input").val($this.summernote('code'));
                        }
                    }
                });
            
            function sendImages(formData, editor) {
                    // 파일 전송을 위한 폼생성
                    var url = "/uploadImage";
                
                    $.ajax({
                        // ajax를 통해 파일 업로드 처리
                        data: formData,
                        type: "POST",
                        url: url,
                        cache: false,
                        contentType: false,
                        processData: false,
                        // beforeSubmit:function(e){
                        //     $('.uploading').show();
                        // },

                        success: function (data) {
                            
                            let files = data.files;
                            for (let i = 0; i < files.length; i++)
                            {
                                //업로드 성공시 에디터에 이미지삽입
                                let result = files[i].result;
                                if (result === "success") {
                                    $(editor).summernote('editor.insertImage', files[i].uri);
                                }
                                //개별 실패시
                                if (result === "fail") {
                                }
                            }
                            //한개라도 실패가 있을시
                            if(data.result === "fail")
                            {
                                alert(data.errors);
                            }
                        }
                    });
                }
         });

      </script>
       
        <?php
        
    }
    public function inputSearch($config) 
    {
        
        if(!isset($config["row"])) throw new RuntimeException("need row");
        $row = $config["row"];
        // var_dump($row);
        if(!isset($config["table"])) throw new RuntimeException("need table");
        $table = $config["table"];
        if(!isset($config["searchField"])) throw new RuntimeException("need searchField");
        $searchField = $config["searchField"];
        if(is_array($searchField) === false)
        {
            $searchField = [$searchField];
        }
        if(!isset($config["searchFieldDisplayName"])) throw new RuntimeException("need searchFieldDisplayName");
        $searchFieldDisplayName = $config["searchFieldDisplayName"];
        if(is_array($searchFieldDisplayName) === false)
        {
            $searchFieldDisplayName = [$searchFieldDisplayName];
        }

        $inputName = $config["inputName"] ?? "{$table}_id";
        $inputValue = $config["inputValue"] ?? "id";
        $displayName = $config["displayName"] ?? "검색";
        $updateDefault = $config["updateDefault"] ?? $searchField[0];

        
        ?> 
      


  
            <div class="form-group ci-component ci-search">
            <div class="row">
            <div class="col-xs-6">
                <label for=""><?=$displayName?></label>
                <input class="search form-control" data-name="<?=$inputName?>" data-value="<?=$inputValue?>" data-table="<?=$table?>" data-field="<?=$searchField[0]?>" type="text">
            </div>
            <div class="col-xs-2">
                <label for="search-mode">검색모드</label>
                <select style="width:200px;" class="search-field-selector form-control" name="" id="">
                    <?php foreach ( $searchField as $key=>$fieldValue ): ?>
                    <option value="<?=$fieldValue?>"><?=$searchFieldDisplayName[$key]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            </div>
                <ul class="search_scroller" data-sw="true"data-offset="0" style="overflow-y:scroll;overflow-x:hidden; height:100px; width:100%; margin-top:10px;" >
                    <?php if ( strpos($this->ci->router->fetch_method(),"update")>-1  && $updateDefault !== false): ?>
                    <div class="original-data">
                        <div class="radio">
                            <label><input checked type="radio" name="<?=$inputName?>" value="<?=$row->{$inputValue}?>" ><?=$row->{$updateDefault}?> (현재값)</label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="search_result_wapper" >
                    </div>
                </ul>
            </div>

        <?php if($this->sw_inputSearch === true) return; 
        $this->sw_inputSearch = true;
        ?>
            <script>
        $(document).ready(function () {
            $(".ci-component.ci-search .search-field-selector").change(function()
            {
                $this = $(this);
                let value = $this.find("option:selected").val();
                $ci_component =  $this.parents(".ci-component").eq(0);
                $ci_component.find(".search").eq(0).data("field",value)
                $search_scroller = $ci_component.find(".search_scroller").eq(0);
                $search_result_wapper = $search_scroller.find(".search_result_wapper").eq(0);
                $search_result_wapper.children().remove();
                
                getList(0,$search_scroller);
            })
        //
            $('.ci-component.ci-search .search').keypress(function(e) {
                clearTimeout($.data(this, 'timer'));
                var t = this;
                if (e.keyCode == 13)
                {
                    e.preventDefault();
                    search(true,t);

                }
                else
                {
                    $(this).data('timer', setTimeout(function(){search(false,t)}, 300));

                }
            });
            function search(force,t) {
                $this = $(t);
                $ci_component =  $this.parents(".ci-component").eq(0);
                var $search_scroller = $ci_component.find(".search_scroller").eq(0);
                var $search_result_wapper = $search_scroller.find(".search_result_wapper").eq(0);
                $search_scroller.data("sw",true);
                let table = $this.data("table");
                var field = $this.data("field");
                
                $search =  $ci_component.find(".search").eq(0);
                var existingString =$search.val();
                if (!force && existingString.length < 3) return; //wasn't enter, not > 2 char
                let url= "<?=$this->searchURL?>";
                let inputName =$search.data("name");
                let inputValue =$search.data("value");
                let data ={"table" : table, "search" : existingString,"value" : inputValue ,"field" : field,offset:0};

                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    data: data,
                    url: url,
                    beforeSend: function(){
                    },
                    success:function(data){
                        $search_result_wapper.children().remove();
                        $search_scroller.data("offset",data.offset);
                        let rows=data.rows;

                        for (let i = 0; i < rows.length; i++) {
                            href = "/admin/"+table+"/update/"+rows[i].id;
                            appendData($search_result_wapper,rows[i],field,inputName,inputValue,href);
                        }

                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert('에러... or 데이터 용량이 너무많습니다.');
                        $('.loading').fadeOut(500);
                        console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                        console.log(errorThrown);
                    }
                });
            }

            //init
            let $search_scroller =$(".ci-component .search_scroller");
            let $search_result_wapper =$(".ci-component .search_result_wapper");
            $search_scroller.each(function(idx)
            {
                getList(0,this);
            })
            
            //scroll event
            $search_scroller.scroll(function(){
                $this =$(this);
                $search_scroller = $this;
                let $ci_component =  $this.parents(".ci-component").eq(0);
                let $search_result_wapper = $search_scroller.find(".search_result_wapper").eq(0);
                let maxHeight = $search_result_wapper.height();
                let currentScroll = $search_scroller.scrollTop() + $search_scroller.height();
                let sw = $this.data("sw");
                if (maxHeight <= currentScroll + 100 && sw === true) 
                {
                    let offset = $this.data("offset");
                    $this.data("sw",false);
                    // console.log(offset);

                    getList(offset,this);
                }

            });
            function getList(offset,t)
            {
                let $this = $(t);
                $ci_component =  $this.parents(".ci-component").eq(0);
                let $search = $ci_component.find(".search").eq(0);
                let table =$search.data("table");
                let field =$search.data("field");
                let inputName =$search.data("name");
                let inputValue =$search.data("value");
                let searchString = $search.val();
                let data = {"offset" : offset, "field" : field,"value" : inputValue ,"table" : table, "search":searchString};
                let url= "<?=$this->searchURL?>";
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    data: data,
                    url: url,
                    beforeSend: function(){
                    },
                    success:function(data){
                        $this.data("offset",data.offset);
                        let rows=data.rows;
                        let $search_result_wapper=$this.find(".search_result_wapper");
                        
                        for (let i = 0; i < rows.length; i++) 
                        {
                            href = "/admin/"+table+"/update/"+rows[i].id;
                            appendData($search_result_wapper,rows[i],field,inputName,inputValue,href);
                        
                        }
                        if(rows.length === 0)
                            $this.data("sw",false);                    
                        else
                            $this.data("sw",true);                    


                    },
                    error: function(xhr, textStatus, errorThrown){
                        alert('에러... or 데이터 용량이 너무많습니다.');
                        $('.loading').fadeOut(500);
                        console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                        console.log(errorThrown);
                    }
                });
            }
            function appendData($search_result_wapper,row,field,name,value,href)
            {
                $li=$("<li style='list-style:none'>");
                $div = $("<div class='radio'>");
                $label = $("<label>");
                $label.text(row[field]);
                
                $input=$("<input type='radio'>");
                $input.attr("name",name)
                $input.val(row[value]);

                $anchor = $("<a target='_blank' href='"+href+"'>");
                $anchor.html("&nbsp;&nbsp;&nbsp; 보러가기");

                $label.prepend($input);
                $div.append($label);
                $div.append($anchor);
                $li.append($div);
                $search_result_wapper.append($li);
            }

        });
        </script>

        <?php
    }
    // public function input($row,string $type,string $inputName, string $values,string $texts,string $default,bool $search =false)
    
    private function assingVariable_fromConfig($variableName,$config,$default ="")
    {
        $variable = $config[$variableName] ?? $default;
        if(is_callable($variable) === true)
        {
            $variable = $variable($this->row);
        }
        return $variable;
    }
    

    public function input($config)
    {
        if(!isset($config["row"])) throw new RuntimeException("need row");
        if(!isset($config["inputName"])) throw new RuntimeException("need inputName");
        $row = $config["row"] ?? "";
        $this->row = $row;
        $type = $config["type"] ?? "text";
        $inputName = $config["inputName"] ?? "";
        $values = $config["inputValue"] ?? "";
        $displayName = $config["displayName"] ?? "";
        $inputDisplayName = $config["inputDisplayName"] ?? "";
        $default = $this->assingVariable_fromConfig("default",$config);
        $search = $config["search"] ?? false;

        if(is_array($inputDisplayName) === false)
        {
            $inputDisplayName = [$inputDisplayName];
        }
        if(is_array($values) === false)
        {
            $values = [$values];
        }
        if(is_array($displayName) === false)
        {
            $displayName = [$displayName];
        }
        ?>
        <?php if($type ==="radio" || $type ==="checkbox"): ?>
            <label for=""><?=$displayName[0]?></label>
        <?php endif; ?>
        <?php for ( $i = 0 ; $i < count($inputDisplayName) ; $i++ ):
            $tmp_displayName = $displayName[$i] ?? "";
            $value = $values[$i] ?? "";
            $tmp_inputDisplayName =  $inputDisplayName[$i] ?? "";
          
            if(!property_exists($row,$inputName))
            {
                $row->$inputName = $default;
            }
            if($type ==="radio" || $type ==="checkbox")
            {
                
                $html ="<input type='$type'  name='$inputName' ";
                $html .= "value='$value' ";
                $html .= call_user_func_array("my_set_checked",array($row,$inputName,$value));
                $html .=">";
                $html =$this->wapperInput_byRadioBox($html,$tmp_inputDisplayName,$type);
            }
            else
            {
                $html ="<input type='$type' class='form-control' name='$inputName' ";
                $html .= "value='";
                
                if($inputName!== "password")
                {
                    $html .= call_user_func_array("my_set_value",array($row,$inputName));
                }
             
                $html .= "'";
                $params = array($row,$inputName);
                $html .=">";
                $html =$this->wapperInput_byText($html,$tmp_displayName);
                $html =$this->wapperInput_byFormGroup($html);
            }
            
            echo $html;
            ?>
        <?php endfor; ?>
        <?php if ( $search === true ): ?>
            </ul>            
        <?php endif; ?>
        <?php
    }
    private function wapperInput_byFormGroup(string $html)
    {
        return "<div class='form-group'> {$html} </div>";
    }
    private function wapperInput_byRadioBox(string $html,string $labelName,string $type="radio")
    {
        return "<div class='{$type}'><label>{$html}{$labelName}</label></div>";
    } 
    private function wapperInput_byText(string $html,string $labelName)
    {
        return "<label>{$labelName}</label>{$html}";
    } 
    public function datepicker(string $inputName,string $text)
    {
        ?>
        <?=$text?><input type="text" name="<?=$inputName?>">
        <?php
    }
  
    public function loadJquery()
    {
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <?php
    }

 
}

/* End of file Component.php */

?>