<div class="col-md-3" data-col="<?=$num?>">
    <div class="new" data-id="<?=$num?>" class="product-gallery">
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
                <input type="file" style="display: none;" id="file<?=$num?>" name="file<?=$num?>" />
                <span class="btn did btn-outline file-btn" data-num="<?=$num?>" id="load-img<?=$num?>">Загрузить</span>
                <span class="btn red btn-outline file-del-btn" data-del="<?=$num?>">Удалить</span>
            </div>
        </div>
    </div>
</div>
<div class="last"></div>