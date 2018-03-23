<link rel="stylesheet" href="/public/libraries/bootstrapTreeview/bootstrap-treeview.min.css">

    
<?php if ( count($fieldData ?? false) === 0 ): ?>
	<div class="alert alert-danger">
  		<strong>경고 -</strong> <?=$moduleName?>_m에서 listData_admin가 정의되지 않았습니다.
	</div>
<?php endif; ?>
<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/admin/{$moduleName}/add?parent_id=0")?>">추가</button>
<button class="btn btn-defualt tree-view expand-all">모두 펼치기</button>
<button class="btn btn-defualt tree-view collapse-all">모두 접기</button>
<br>
<br>

<input type="text" class="list-tree-search-input form-control" placeholder="검색">
<br>
<div id="tree"></div>


<script>

    $(document).ready(function(){

        //검색
        $('.list-tree-search-input').keyup(function(e) {
            var value =this.value;
            clearTimeout($.data(this, 'timer'));
         
            if (e.keyCode == 13)
            {
                searchTreeView(value);
                e.preventDefault();

            }
            else
            {
                $(this).data('timer', setTimeout(function(){
                    searchTreeView(value);
                }, 300));

            }
        });

        //트리 구조 받기
        var tree="<?=$tree?>";
        if(tree === "") return;
        tree =JSON.parse(atob(tree));
        $('#tree').treeview({data: tree});
        
        //초기화
        $('#tree').treeview('expandAll', { silent: true });
       
        $(".tree-view.expand-all").click(function()
        {
            $('#tree').treeview('expandAll', { silent: true });
        });
        $(".tree-view.collapse-all").click(function()
        {
            $('#tree').treeview('collapseAll', { silent: true });
        });
        function searchTreeView($value){
            $('#tree').treeview('search', [ $value, {
            ignoreCase: true,     // case insensitive
            exactMatch: false,    // like or equals
            revealResults: true,  // reveal matching nodes
            }]);
        }
       
        // $('#tree').treeview('clearSearch');
    });

</script>



<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/admin/{$moduleName}/add?parent_id=0")?>">추가</button>
<button class="btn btn-defualt tree-view expand-all">모두 펼치기</button>
<button class="btn btn-defualt tree-view collapse-all">모두 접기</button>

<script src="/public/libraries/bootstrapTreeview/bootstrap-treeview.js")" type="text/javascript"></script>
