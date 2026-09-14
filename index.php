<?php
$pageTitle='أبشر للتوريدات والمعدات | توريدات صناعية وكتالوج معدات';
require 'includes/header.php';
$pub=array_values(array_filter(array_reverse(products()),fn($p)=>($p['status']??'')==='published'));
$brandNames=['BOSCH','Makita','HILTI','DEWALT','Milwaukee','STANLEY','metabo','LINCOLN ELECTRIC'];
$catIcons=['⚙','⌁','▣','⚒','◫','⌬','◈','⬡'];
?>
<div class="commercial-home">
<section class="commerce-hero">
  <div class="hero-main">
    <span class="eyebrow">ABSHAR INDUSTRIAL SUPPLY</span>
    <h1>توريدات ومعدات للمصانع والورش والمشروعات</h1>
    <p>ابحث بالموديل أو العلامة التجارية أو رقم القطعة، قارن الخيارات، واطلب عرض سعر موحد لقائمة مشتريات شركتك.</p>
    <div class="hero-actions"><a class="shop" href="catalog.php">تصفح المنتجات</a><a class="quote" href="quote.php">طلب عرض سعر</a></div>
  </div>
  <div class="hero-side">
    <article class="promo-card"><div><strong>توريد للشركات والمصانع</strong><p>طلبات جملة، احتياجات تشغيل وصيانة، وتجهيزات مشروعات.</p></div><a href="services.php">خدمات الشركات ←</a></article>
    <article class="promo-card"><div><strong>ابحث بالموديل مباشرة</strong><p>أدخل كود المنتج أو رقم القطعة للوصول السريع للمعدة المطلوبة.</p></div><a href="catalog.php">ابدأ البحث ←</a></article>
  </div>
</section>
<section class="trust-strip"><div><b>توريدات B2B</b><span>للمصانع والشركات</span></div><div><b>مواصفات موثقة</b><span>مصدر ودرجة ثقة</span></div><div><b>طلب عرض سعر</b><span>قائمة معدات موحدة</span></div><div><b>دعم مبيعات</b><span>متابعة مباشرة</span></div></section>
<section class="commercial-section"><div class="commercial-title"><div><h2>تسوق حسب القسم</h2><p>وصول مباشر إلى مجموعات المعدات الرئيسية</p></div><a href="catalog.php">عرض جميع الأقسام ←</a></div><div class="category-commerce"><?php foreach(array_slice(categories(),0,8) as $i=>$c):?><a class="category-box" href="catalog.php?category=<?=urlencode($c['name'])?>"><span class="category-icon"><?=e($catIcons[$i]??'⚙')?></span><div><h3><?=e($c['name'])?></h3><p><?=e(implode(' • ',array_slice($c['children']??[],0,3)))?></p></div></a><?php endforeach;?></div></section>
<section class="commercial-section"><div class="commercial-title"><div><h2>العلامات التجارية</h2><p>أشهر الشركات المصنعة للمعدات الاحترافية</p></div><a href="brands.php">كل العلامات ←</a></div><div class="brand-commerce"><?php foreach($brandNames as$b):?><a href="catalog.php?q=<?=urlencode($b)?>"><?=e($b)?></a><?php endforeach;?></div></section>
<section class="commercial-section"><div class="commercial-title"><div><h2>منتجات مختارة</h2><p>معدات متاحة للاستعلام وطلب عرض السعر</p></div><a href="catalog.php">عرض الكتالوج ←</a></div><div class="product-commerce"><?php $items=$pub?:[
['slug'=>'','name'=>'Hilti TE 70-ATC/AVR','brand'=>'Hilti','category'=>'عدد كهربائية','short_description'=>'مطرقة دورانية احترافية SDS Max للأعمال الشاقة.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'Bosch GBH 2-26 DRE','brand'=>'Bosch','category'=>'عدد كهربائية','short_description'=>'معدة حفر وتكسير احترافية للاستخدام اليومي.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'Makita GA9020','brand'=>'Makita','category'=>'تجليخ وقطع','short_description'=>'صاروخ قطع وتجليخ للاستخدامات الصناعية.','price'=>0,'price_label'=>'اطلب السعر','image'=>''],
['slug'=>'','name'=>'DEWALT DCD796','brand'=>'DeWalt','category'=>'دريل شحن','short_description'=>'دريل احترافي للتركيب والصيانة.','price'=>0,'price_label'=>'اطلب السعر','image'=>'']];foreach(array_slice($items,0,8) as$p):$href=!empty($p['slug'])?'product.php?slug='.urlencode($p['slug']):'catalog.php?q='.urlencode($p['name']);?><a class="commerce-product" href="<?=$href?>"><div class="media"><?php if(!empty($p['image'])):?><img src="<?=e($p['image'])?>" alt="<?=e($p['name'])?>"><?php else:?><span class="placeholder"><?=e(u_first($p['brand']??'A'))?></span><?php endif;?></div><div class="body"><span class="brandline"><?=e($p['brand']??'')?> · <?=e($p['category']??'')?></span><h3><?=e($p['name'])?></h3><p><?=e($p['short_description']??'معدات صناعية احترافية متاحة للاستعلام.')?></p><div class="price-row"><strong><?=!empty($p['price'])?money($p['price']):e($p['price_label']??'اطلب السعر')?></strong><span>التفاصيل ←</span></div></div></a><?php endforeach;?></div></section>
<section class="commercial-section" id="industries"><div class="business-banner"><div><h2>مشتريات الشركات والمشروعات</h2><p>أرسل قائمة الموديلات أو أرقام القطع المطلوبة وسنرتبها في طلب توريد واحد مع البدائل المتاحة ومصادر البيانات.</p><div class="points"><span>مطابقة الموديلات</span><span>مراجعة البدائل</span><span>تجميع RFQ واحد</span><span>متابعة المبيعات</span></div></div><div class="cta"><a href="quote.php">ابدأ طلب التوريد</a></div></div></section>
</div>
<?php require 'includes/footer.php';?>
