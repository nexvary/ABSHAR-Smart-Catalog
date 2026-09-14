<?php
require_once __DIR__.'/bootstrap.php';
$metaDescription=$metaDescription??(string)config('site_tagline','توريدات ومعدات صناعية');
$currentPage=basename($_SERVER['PHP_SELF']??'index.php');
$canonical=$canonical??site_url($currentPage);
?>
<!doctype html><html lang="ar" dir="rtl"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#0C1319">
<title><?=e($pageTitle??config('site_name'))?></title><meta name="description" content="<?=e($metaDescription)?>"><link rel="canonical" href="<?=e($canonical)?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="assets/storefront-v9.css"></head><body>
<div class="topbar"><div class="container"><div class="top-links"><span>توريدات صناعية للشركات والمصانع</span><a href="services.php">حلول المشتريات B2B</a></div><div class="top-meta"><a href="contact.php">دعم المبيعات</a><span>العربية</span></div></div></div>
<header class="site-head"><div class="container">
<a class="brand" href="index.php" aria-label="أبشر"><span class="brand-mark">A</span><span class="brand-copy"><strong>أبشر</strong><small>للتوريدات والمعدات</small><em>ABSHAR INDUSTRIAL SUPPLY</em></span></a>
<form class="global-search" action="catalog.php" role="search"><input name="q" aria-label="البحث" placeholder="ابحث بالمنتج، الموديل، رقم القطعة أو العلامة التجارية..."><button type="submit" aria-label="بحث">⌕</button></form>
<a class="rfq-btn" href="quote.php">طلب عرض سعر</a>
</div></header>
<nav class="mainnav"><div class="container nav-row" aria-label="التنقل الرئيسي">
<a class="<?=$currentPage==='index.php'?'active':''?>" href="index.php">الرئيسية</a>
<a class="<?=$currentPage==='catalog.php'?'active':''?>" href="catalog.php">كل الأقسام</a>
<a class="<?=$currentPage==='brands.php'?'active':''?>" href="brands.php">العلامات التجارية</a>
<a href="catalog.php?offer=1">العروض</a>
<a href="index.php#industries">حسب النشاط</a>
<a class="<?=$currentPage==='services.php'?'active':''?>" href="services.php">خدمات الشركات</a>
<a class="<?=$currentPage==='about.php'?'active':''?>" href="about.php">من نحن</a>
<a class="<?=$currentPage==='contact.php'?'active':''?>" href="contact.php">اتصل بنا</a>
</div></nav>
<main>
