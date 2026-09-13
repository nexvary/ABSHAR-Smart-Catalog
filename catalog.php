<?php
require 'includes/bootstrap.php';
$q=trim((string)($_GET['q']??''));
$cat=trim((string)($_GET['category']??''));
$brand=trim((string)($_GET['brand']??''));
$sort=(string)($_GET['sort']??'relevance');
$minPrice=max(0,(float)($_GET['min_price']??0));
$maxPrice=max(0,(float)($_GET['max_price']??0));
$offer=(string)($_GET['offer']??'');
$view=in_array(($_GET['view']??'grid'),['grid','table'],true)?$_GET['view']:'grid';
$allPublished=array_values(array_filter(products(),fn($p)=>($p['status']??'')==='published'));
$brandNames=[];
foreach($allPublished as $p){$b=trim((string)($p['brand']??''));if($b!=='')$brandNames[$b]=true;}
$brandNames=array_keys($brandNames);sort($brandNames,SORT_NATURAL|SORT_FLAG_CASE);
$items=array_values(array_filter($allPublished,function($p)use($q,$cat,$brand,$minPrice,$maxPrice,$offer){
 if($cat!==''&&($p['category']??'')!==$cat)return false;
 if($brand!==''&&strcasecmp((string)($p['brand']??''),$brand)!==0)return false;
 if($q!==''&&product_score($p,$q)<45)return false;
 $price=(float)($p['price']??0);
 if($minPrice>0&&($price<=0||$price<$minPrice))return false;
 if($maxPrice>0&&($price<=0||$price>$maxPrice))return false;
 if($offer==='1'&&!($p['offer']??$p['is_offer']??false)&&empty($p['old_price'])&&empty($p['discount_price']))return false;
 return true;
}));
usort($items,function($a,$b)use($q,$sort){
 if($sort==='name')return strcasecmp((string)($a['name']??''),(string)($b['name']??''));
 if($sort==='price_asc')return (float)($a['price']??PHP_FLOAT_MAX)<=>(float)($b['price']??PHP_FLOAT_MAX);
 if($sort==='price_desc')return (float)($b['price']??0)<=>(float)($a['price']??0);
 return product_score($b,$q)<=>product_score($a,$q);
});
$pageTitle='كتالوج المعدات | أبشر';
require 'includes/header.php';
?>
<section class="catalog-shell">
  <header class="catalog-hero">
    <div><span class="eyebrow">INDUSTRIAL CATALOG / PRODUCT FINDER</span><h1><?=$q!==''?'نتائج البحث: '.e($q):'كتالوج المعدات الصناعية'?></h1><p>ابحث، صفِّ النتائج، قارن الموديلات ثم اطلب عرض سعر من شاشة واحدة.</p></div>
    <div class="catalog-count"><b><?=count($items)?></b><span>منتج مطابق</span></div>
  </header>
  <div class="catalog-workspace">
    <aside class="filter-panel" aria-label="فلاتر المنتجات">
      <div class="filter-title"><strong>تصفية النتائج</strong><a href="catalog.php">مسح الكل</a></div>
      <form method="get" action="catalog.php">
        <?php if($q!==''):?><input type="hidden" name="q" value="<?=e($q)?>"><?php endif;?>
        <div class="filter-group"><h3>القسم</h3><label class="filter-option"><span><input type="radio" name="category" value="" <?=$cat===''?'checked':''?>> كل الأقسام</span><em><?=count($allPublished)?></em></label><?php foreach(categories() as $c):$count=count(array_filter($allPublished,fn($p)=>($p['category']??'')===$c['name']));?><label class="filter-option"><span><input type="radio" name="category" value="<?=e($c['name'])?>" <?=$cat===$c['name']?'checked':''?>> <?=e($c['name'])?></span><em><?=$count?></em></label><?php endforeach;?></div>
        <div class="filter-group"><h3>العلامة التجارية</h3><label class="filter-option"><span><input type="radio" name="brand" value="" <?=$brand===''?'checked':''?>> كل العلامات</span></label><?php foreach(array_slice($brandNames,0,12) as $b):?><label class="filter-option"><span><input type="radio" name="brand" value="<?=e($b)?>" <?=$brand===$b?'checked':''?>> <?=e($b)?></span></label><?php endforeach;?></div>
        <div class="filter-group"><h3>السعر</h3><div class="price-row"><input name="min_price" inputmode="decimal" value="<?=$minPrice?:''?>" placeholder="من"><input name="max_price" inputmode="decimal" value="<?=$maxPrice?:''?>" placeholder="إلى"></div></div>
        <div class="filter-group"><label class="filter-option"><span><input type="checkbox" name="offer" value="1" <?=$offer==='1'?'checked':''?>> عروض خاصة</span><em>CRIMSON</em></label><button class="apply-filter" type="submit">تطبيق الفلاتر</button></div>
      </form>
    </aside>
    <div class="catalog-main">
      <div class="result-toolbar">
        <div class="toolbar-right"><span class="compare-badge">✓ المواصفات الموثقة باللون الأخضر</span><span class="compare-badge">يمكن تحديد منتجات للمقارنة</span></div>
        <div class="toolbar-left"><form method="get" action="catalog.php"><?php foreach(['q'=>$q,'category'=>$cat,'brand'=>$brand,'min_price'=>$minPrice?:'','max_price'=>$maxPrice?:'','offer'=>$offer] as $k=>$v):if($v!==''):?><input type="hidden" name="<?=$k?>" value="<?=e((string)$v)?>"><?php endif;endforeach;?><select class="sort-select" name="sort" onchange="this.form.submit()"><option value="relevance" <?=$sort==='relevance'?'selected':''?>>الأكثر صلة</option><option value="name" <?=$sort==='name'?'selected':''?>>الاسم</option><option value="price_asc" <?=$sort==='price_asc'?'selected':''?>>السعر: الأقل</option><option value="price_desc" <?=$sort==='price_desc'?'selected':''?>>السعر: الأعلى</option></select></form><button class="view-toggle <?=$view==='grid'?'active':''?>" data-view="grid" aria-label="عرض شبكي">▦</button><button class="view-toggle <?=$view==='table'?'active':''?>" data-view="table" aria-label="عرض جدولي">☷</button></div>
      </div>
      <?php if($q!==''||$cat!==''||$brand!==''||$minPrice||$maxPrice||$offer==='1'):?><div class="active-filters"><?php if($q!==''):?><span class="active-filter">بحث: <?=e($q)?></span><?php endif;?><?php if($cat!==''):?><span class="active-filter">القسم: <?=e($cat)?></span><?php endif;?><?php if($brand!==''):?><span class="active-filter">العلامة: <?=e($brand)?></span><?php endif;?><?php if($minPrice):?><span class="active-filter">من: <?=e((string)$minPrice)?></span><?php endif;?><?php if($maxPrice):?><span class="active-filter">إلى: <?=e((string)$maxPrice)?></span><?php endif;?><?php if($offer==='1'):?><span class="active-filter">عروض</span><?php endif;?></div><?php endif;?>
      <div class="catalog-products <?=$view==='table'?'table-view':''?>" id="catalogProducts">
        <?php foreach($items as $p):$isOffer=(bool)($p['offer']??$p['is_offer']??false)||!empty($p['old_price'])||!empty($p['discount_price']);$confidence=(int)($p['confidence']??0);$verified=$confidence>=90||!empty($p['source_url']);$specs=$p['specifications']??$p['specs']??[];$specPairs=[];if(is_array($specs)){foreach($specs as $k=>$v){if(is_scalar($v)){$specPairs[]=[is_string($k)?$k:'مواصفة',(string)$v];if(count($specPairs)>=2)break;}}}?>
        <article class="catalog-product <?=$isOffer?'is-offer':''?> <?=$verified?'is-verified':''?>">
          <a class="catalog-product-media" href="product.php?slug=<?=urlencode($p['slug'])?>"><?php if(!empty($p['image'])):?><img src="<?=e($p['image'])?>" alt="<?=e($p['name'])?>"><?php else:?><div class="catalog-product-placeholder"><?=e(u_first($p['brand']??'A'))?></div><?php endif;?><?php if($verified):?><span class="status-tag">✓ موثق</span><?php endif;?><?php if($isOffer):?><span class="offer-tag">عرض</span><?php endif;?></a>
          <div class="catalog-product-body"><div><div class="product-meta"><?=e($p['brand']??'')?> · <?=e($p['model']??'')?> · <?=e($p['category']??'')?></div><h3><a href="product.php?slug=<?=urlencode($p['slug'])?>"><?=e($p['name'])?></a></h3><p><?=e($p['short_description']??'معدات صناعية متاحة للاستعلام وطلب عرض السعر.')?></p><?php if($specPairs):?><div class="mini-specs"><?php foreach($specPairs as [$sk,$sv]):?><span><?=e($sk)?>: <?=e($sv)?></span><?php endforeach;?></div><?php endif;?><label class="compare-check"><input type="checkbox" class="compare-product" value="<?=e($p['slug'])?>"> إضافة للمقارنة</label></div><div class="catalog-card-foot"><b><?=!empty($p['price'])?money($p['price']):e($p['price_label']??'اطلب السعر')?></b><a href="product.php?slug=<?=urlencode($p['slug'])?>">التفاصيل والمواصفات ←</a></div></div>
        </article><?php endforeach;?>
        <?php if(!$items):?><div class="empty-state"><h3>لا توجد نتائج مطابقة</h3><p>جرّب إزالة بعض الفلاتر أو كتابة جزء من رقم الموديل فقط.</p><a class="primary-cta" href="quote.php">اطلب البحث عن المعدة</a></div><?php endif;?>
      </div>
    </div>
  </div>
</section>
<?php require 'includes/footer.php';?>