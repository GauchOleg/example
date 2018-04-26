
<div id="new-<?=$id?>" class="product-gallery">
    <div class="col-md-3">
        <div class="form-group">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <a href="javascript:;" class="thumbnail">
                                <img src="http://www.placehold.it/320x200/EFEFEF/AAAAAA&amp;text=no+image" alt="Новое фото" style="display: block;"> </a>
                        </div>
                    </div>
                </div>
                <input type="file" style="display: none;" name="file" />
                <span class="btn did btn-outline file-btn" id="load-img">Загрузить</span>
                <span class="btn red btn-outline" id="del-img">Удалить</span>
            </div>
        </div>
    </div>
</div>

<script>
    $(".file-btn").click(function(){
        $("input[type='file'").trigger('click');
    });
</script>