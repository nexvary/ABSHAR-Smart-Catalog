<?php
require 'includes/bootstrap.php';
$slug=(string)($_GET['slug']??'');
$p=product_by_slug($slug);
if(!$p){
  http_response_code(404);
  $pageTitle='المنتج غير موجود';
  require 'includes/header.php';
  echo '<section class="section"><div class="empty"><h1>المنتج غير موجود</h1><p>تحقق من الرابط أو ارجع إلى الكتالوج.</p><a class="primary-cta" href="catalog.php">العودة للكتالوج</a></div></section>';
  require 'includes/footer.php';
  exit;
}
$pageTitle=$p['name'].' | أبشر';
$metaDescription=$p['short_description']??'';
$all=array_values(array_filter(products(),fn($x)=>($x['status']??'')==='published' && ($x['slug']??'')!==$slug));
$related=array_values(array_filter($all,fn($x)=>(($x['category']??'')===($p['category']??'')) || (($x['brand']??'')===($p['brand']??''))));
$related=array_slice($related,0,4);
$msg='مرحبًا، أريد عرض سعر للمنتج: '.$p['name'].(!empty($p['model'])?' | الموديل: '.$p['model']:'');
$wa='https://wa.me/'.preg_replace('/\D/','',(string)config('whatsapp_number')).'?text='.urlencode($msg);
$sourceUrl=(string)($p['source_url']??'');
$confidence=(int)($p['confidence']??0);
$isVerified=$confidence>=85 && $sourceUrl!=='';
$availability=(string)($p['availability']??'متوفر حسب الطلب');
$schema=[
 '@context'=>'https://schema.org','@type'=>'Product','name'=>$p['name'],'description'=>$p['short_description']??'',
 'brand'=>['@type'=>'Brand','name'=>$p['brand']??''],'model'=>$p['model']??'',
 'sku'=>$p['model']??($p['id']??''),'url'=>site_url('product.php?slug='.urlencode($slug))
];
if(!empty($p['image']))$schema['image']=[$p['image']];
if(!empty($p['price']))$schema['offers']=['@type'=>'Offer','price'=>(string)$p['price'],'priceCurrency'=>(string)config('currency_code','EGP'),'availability'=>'https://schema.org/InStock','url'=>site_url('product.php?slug='.urlencode($slug))];
require 'includes/header.php';
?>
<script type="application/ld+json"><?=json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)?></script>
<section class="pd-breadcrumb"><a href="index.php">الرئيسية</a><span>›</span><a href="catalog.php">الكتالوج</a><span>›</span><a href="catalog.php?category=<?=urlencode($p['category']??'')?>"><?=e($p['category']??'')?></a><span>›</span><b><?=e($p['model']??$p['name'])?></b></section>
<section class="pd-shell">
  <div class="pd-gallery">
    <div class="pd-gallery-head"><span>PRODUCT / <?=e(strtoupper((string)($p['brand']??'INDUSTRIAL')))?></span><span class="pd-id">ID: <?=e($p['id']??'—')?></span></div>
    <div class="pd-main-image">
      <?php if(!empty($p['image'])):?><img src="<?=e($p['image'])?>" alt="<?=e($p['name'])?>"><?php else:?><div class="pd-placeholder"><span><?=e(u_first($p['brand']??'A'))?></span><b><?=e($p['brand']??'INDUSTRIAL')?></b><small><?=e($p['model']??'PRO EQUIPMENT')?></small></div><?php endif;?>
      <?php if($isVerified):?><span class="pd-verified">✓ بيانات موثقة</span><?php endif;?>
    </div>
    <div class="pd-thumb-row"><button class="active" type="button">01</button><button type="button" disabled>02</button><button type="button" disabled>03</button><span>أضف صور المنتج من لوحة الإدارة</span></div>
  </div>
  <aside class="pd-summary">
    <div class="pd-badges"><span class="brand-badge"><?=e($p['brand']??'')?></span><span class="availability-badge"><?=e($availability)?></span></div>
    <h1><?=e($p['name'])?></h1>
    <?php if(!empty($p['model'])):?><div class="pd-model">MODEL <b><?=e($p['model'])?></b></div><?php endif;?>
    <p class="pd-lead"><?=e($p['short_description']??'')?></p>
    <div class="pd-price-block"><span>السعر</span><strong><?=!empty($p['price'])?money($p['price']):e($p['price_label']??'اطلب السعر')?></strong><small>السعر النهائي حسب الكمية والتوريد</small></div>
    <div class="pd-actions"><a class="pd-rfq" target="_blank" rel="noopener" href="<?=e($wa)?>">▤ اطلب عرض سعر</a><a class="pd-call" href="tel:<?=e((string)config('phone_number'))?>">☎ اتصل بالمبيعات</a></div>
    <div class="pd-procure-grid"><div><span>الفئة</span><b><?=e($p['category']??'—')?></b></div><div><span>التوفر</span><b class="status-green"><?=e($availability)?></b></div><div><span>المصدر</span><b><?=e($p['source_name']??'إدخال يدوي')?></b></div><div><span>ثقة البيانات</span><b class="<?= $confidence>=85?'status-green':'status-warn' ?>"><?=$confidence?>%</b></div></div>
    <div class="pd-buy-note"><b>للمشتريات والشركات</b><p>أرسل الموديل والكمية المطلوبة، ويمكن إضافة بدائل أو منتجات أخرى داخل طلب توريد واحد.</p><a href="quote.php?product=<?=urlencode($p['name'])?>">إضافة إلى طلب توريد ←</a></div>
  </aside>
</section>
<section class="pd-content">
  <nav class="pd-tabs"><a href="#specs" class="active">المواصفات الفنية</a><a href="#description">الوصف</a><a href="#source">المصدر والتوثيق</a><a href="#related">منتجات مرتبطة</a></nav>
  <div class="pd-content-grid">
    <div class="pd-main-col">
      <section id="specs" class="pd-panel"><div class="pd-panel-title"><div><span>TECHNICAL DATA</span><h2>المواصفات الفنية</h2></div><small><?=count($p['specs']??[])?> بيانات</small></div>
        <?php if(!empty($p['specs'])):?><div class="pd-spec-table"><?php $i=0;foreach(($p['specs']??[]) as $k=>$v):$i++;?><div class="pd-spec-row"><span><?=str_pad((string)$i,2,'0',STR_PAD_LEFT)?></span><dt><?=e((string)$k)?></dt><dd><?=e((string)$v)?></dd></div><?php endforeach;?></div><?php else:?><div class="pd-empty">لم تضاف مواصفات فنية بعد.</div><?php endif;?>
      </section>
      <section id="description" class="pd-panel"><div class="pd-panel-title"><div><span>PRODUCT OVERVIEW</span><h2>عن المعدة</h2></div></div><p class="pd-description"><?=nl2br(e($p['description']??$p['short_description']??''))?></p></section>
      <section id="source" class="pd-panel"><div class="pd-panel-title"><div><span>DATA VERIFICATION</span><h2>المصدر والتوثيق</h2></div></div>
        <div class="source-card"><div class="source-score <?= $isVerified?'verified':'' ?>"><strong><?=$confidence?>%</strong><span>درجة الثقة</span></div><div><b><?=e($p['source_name']??'إدخال يدوي')?></b><p><?= $isVerified?'تم ربط بيانات المنتج بمصدر خارجي موثوق. راجع المصدر عند اتخاذ قرار شراء فني نهائي.':'هذه البيانات تحتاج إلى مراجعة إضافية قبل اعتمادها الفني النهائي.' ?></p><?php if($sourceUrl):?><a target="_blank" rel="noopener nofollow" href="<?=e($sourceUrl)?>">فتح المصدر الرسمي ↗</a><?php endif;?></div></div>
      </section>
    </div>
    <aside class="pd-side-col"><div class="pd-side-card"><span>PROCUREMENT SNAPSHOT</span><h3>ملخص سريع للمشتريات</h3><dl><div><dt>العلامة</dt><dd><?=e($p['brand']??'—')?></dd></div><div><dt>الموديل</dt><dd><?=e($p['model']??'—')?></dd></div><div><dt>الفئة</dt><dd><?=e($p['category']??'—')?></dd></div><div><dt>الحالة</dt><dd><?=e($availability)?></dd></div></dl><a href="quote.php?product=<?=urlencode($p['name'])?>">إنشاء RFQ لهذا المنتج</a></div><div class="pd-side-card compare-help"><span>COMPARE / ALTERNATIVES</span><h3>تحتاج بديلاً؟</h3><p>يمكننا مطابقة نفس المواصفات مع موديلات بديلة من علامات أخرى عند توفرها.</p><a href="catalog.php?category=<?=urlencode($p['category']??'')?>">استعرض نفس الفئة ←</a></div></aside>
  </div>
</section>
<section id="related" class="section pd-related"><div class="section-title"><div><span class="eyebrow">RELATED PRODUCTS</span><h2>منتجات مرتبطة وبدائل محتملة</h2></div><a href="catalog.php?category=<?=urlencode($p['category']??'')?>">عرض الفئة كاملة ←</a></div><div class="product-grid"><?php foreach($related as $r):?><a class="product-card premium" href="product.php?slug=<?=urlencode($r['slug'])?>"><div class="product-image"><?php if(!empty($r['image'])):?><img src="<?=e($r['image'])?>" alt="<?=e($r['name'])?>"><?php else:?><div class="product-placeholder"><span><?=e(u_first($r['brand']??'A'))?></span><small><?=e($r['brand']??'INDUSTRIAL')?></small></div><?php endif;?></div><div class="product-body"><small><?=e($r['brand']??'')?> · <?=e($r['model']??'')?></small><h3><?=e($r['name'])?></h3><div class="card-foot"><strong><?=!empty($r['price'])?money($r['price']):e($r['price_label']??'اطلب السعر')?></strong><span>التفاصيل ←</span></div></div></a><?php endforeach;?><?php if(!$related):?><div class="pd-no-related"><b>لا توجد بدائل منشورة بعد</b><p>سيظهر هنا تلقائيًا أي منتج من نفس الفئة أو العلامة التجارية عند إضافته.</p><a href="catalog.php?category=<?=urlencode($p['category']??'')?>">البحث داخل الفئة ←</a></div><?php endif;?></div></section>
<?php require 'includes/footer.php';?>