<?php
$pageTitle='أبشر للتوريدات والمعدات | توريدات صناعية وكتالوج معدات';
require 'includes/header.php';
$pub=array_values(array_filter(array_reverse(products()),fn($p)=>($p['status']??'')==='published'));
$brandNames=['BOSCH','Makita','HILTI','DEWALT','Milwaukee','STANLEY','metabo','LINCOLN ELECTRIC'];
$catIcons=['⚙','⌁','▣','⚒','◫','⌬','◈','⬡'];
$items=$pub?:[
['slug'=>'','name'=>'Hilti TE 70-ATC/AVR','brand'=>'Hilti','category'=>'عدد كهربائية','short_description'=>'مطرقة دورانية احترافية SDS Max للأعمال الشاقة.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'Bosch GBH 2-26 DRE','brand'=>'Bosch','category'=>'عدد كهربائية','short_description'=>'معدة حفر وتكسير احترافية للاستخدام اليومي.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'Makita GA9020','brand'=>'Makita','category'=>'تجليخ وقطع','short_description'=>'صاروخ قطع وتجليخ للاستخدامات الصناعية.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'DEWALT DCD796','brand'=>'DeWalt','category'=>'دريل شحن','short_description'=>'دريل احترافي للتركيب والصيانة.','price'=>0,'price_label'=>'اطلب السعر','image'=>'']];
?>
<div class="home-wrap"><div class="container">
<section class="hero">
  <div class="hero-main">
    <span class="eyebrow">ABSHAR INDUSTRIAL SUPPLY</span>
    <h1>معدات وتوريدات احترافية للمصانع والورش والمشروعات</h1>
    <p>ابحث بالموديل أو رقم القطعة أو العلامة التجارية، راجع المواصفات، واجمع احتياجات شركتك داخل طلب عرض سعر واحد.</p>
    <div class="hero-actions"><a class="primary" href="catalog.php">تصفح المنتجات</a><a class="secondary" href="quote.php">طلب عرض سعر</a></div>
  </div>
  <div class="hero-side">
    <article class="info-card"><div><span class="icon">▦</span><h3>توريد للشركات والمصانع</h3><p>طلبات جملة، تشغيل وصيانة، وتجهيزات مشروعات من علامات تجارية متعددة.</p></div><a href="services.php">خدمات الشركات ←</a></article>
    <article class="info-card"><div><span class="icon">⌕</span><h3>ابحث بالموديل مباشرة</h3><p>اكتب كود المنتج أو رقم القطعة للوصول إلى المعدة المطلوبة بشكل أسرع.</p></div><a href="catalog.php">ابدأ البحث ←</a></article>
  </div>
</section>
<section class="trust-strip">
  <div class="trust-item"><b>توريدات B2B</b><span>للمصانع والشركات</span></div>
  <div class="trust-item"><b>مواصفات موثقة</b><span>مصدر ودرجة ثقة</span></div>
  <div class="trust-item"><b>طلب عرض سعر موحد</b><span>قائمة معدات واحدة</span></div>
  <div class="trust-item"><b>دعم مبيعات</b><span>متابعة مباشرة</span></div>
</section>
<section class="section-block">
  <div class="section-head"><div><h2>تسوق حسب القسم</h2><p>وصول مباشر إلى مجموعات المعدات الرئيسية</p></div><a href="catalog.php">عرض جميع الأقسام ←</a></div>
  <div class="category-grid"><?php foreach(array_slice(categories(),0,8) as $i=>$c):?><a class="category-card" href="catalog.php?category=<?=urlencode($c['name'])?>"><span class="category-icon"><?=e($catIcons[$i]??'⚙')?></span><div><h3><?=e($c['name'])?></h3><p><?=e(implode(' • ',array_slice($c['children']??[],0,3)))?></p></div></a><?php endforeach;?></div>
</section>
<section class="section-block">
  <div class="section-head"><div><h2>العلامات التجارية</h2><p>أشهر الشركات المصنعة للمعدات الاحترافية</p></div><a href="brands.php">كل العلامات ←</a></div>
  <div class="brand-grid"><?php foreach($brandNames as$b):?><a href="catalog.php?q=<?=urlencode($b)?>"><?=e($b)?></a><?php endforeach;?></div>
</section>
<section class="section-block">
  <div class="section-head"><div><h2>منتجات مختارة</h2><p>معدات متاحة للاستعلام وطلب عرض السعر</p></div><a href="catalog.php">عرض الكتالوج ←</a></div>
  <div class="product-grid"><?php foreach(array_slice($items,0,8) as$p):$href=!empty($p['slug'])?'product.php?slug='.urlencode($p['slug']):'catalog.php?q='.urlencode($p['name']);?><a class="product-card" href="<?=$href?>"><div class="product-media"><?php if(!empty($p['image'])):?><img src="<?=e($p['image'])?>" alt="<?=e($p['name'])?>"><?php else:?><div class="product-placeholder"><?=e(u_first($p['brand']??'A'))?></div><?php endif;?></div><div class="product-body"><span class="product-meta"><?=e($p['brand']??'')?> · <?=e($p['category']??'')?></span><h3><?=e($p['name'])?></h3><p><?=e($p['short_description']??'معدات صناعية احترافية متاحة للاستعلام.')?></p><div class="product-foot"><strong><?=!empty($p['price'])?money($p['price']):e($p['price_label']??'اطلب السعر')?></strong><span>التفاصيل ←</span></div></div></a><?php endforeach;?></div>
</section>
<section class="section-block" id="industries">
  <div class="business-banner"><div><h2>مشتريات الشركات والمشروعات</h2><p>أرسل قائمة الموديلات أو أرقام القطع وسنرتبها في طلب توريد واحد مع مراجعة البدائل والمصادر المتاحة.</p><div class="business-points"><span>مطابقة الموديلات</span><span>مراجعة البدائل</span><span>تجميع RFQ واحد</span><span>متابعة المبيعات</span></div></div><div class="business-cta"><a href="quote.php">ابدأ طلب التوريد</a></div></div>
</section>
</div></div>
<?php require 'includes/footer.php';?>
