<?php
declare(strict_types=1);
require __DIR__.'/../includes/bootstrap.php';
$checks=[];
$checks['products_array']=is_array(products());
$checks['categories_array']=is_array(categories());
$checks['brands_array']=is_array(brands());
$checks['quotes_array']=is_array(quotes());
$checks['csrf_token']=strlen(csrf_token())>=32;
$checks['dashboard_stats']=isset(dashboard_stats()['quality']);
$checks['quality_range']=array_reduce(products(),fn($ok,$p)=>$ok&&product_quality($p)>=0&&product_quality($p)<=100,true);
$checks['admin_files']=is_file(ROOT.'/admin/index.php')&&is_file(ROOT.'/admin/products.php')&&is_file(ROOT.'/admin/quotes.php')&&is_file(ROOT.'/admin/security.php');
$checks['public_files']=is_file(ROOT.'/index.php')&&is_file(ROOT.'/catalog.php')&&is_file(ROOT.'/product.php')&&is_file(ROOT.'/quote.php');
$failed=array_keys(array_filter($checks,fn($v)=>!$v));
foreach($checks as$name=>$ok)echo ($ok?'PASS ':'FAIL ').$name.PHP_EOL;
if($failed){fwrite(STDERR,'Failed: '.implode(', ',$failed).PHP_EOL);exit(1);}echo 'ALL CORE SMOKE CHECKS PASSED'.PHP_EOL;