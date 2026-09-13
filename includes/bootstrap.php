<?php
declare(strict_types=1);
$config=require __DIR__.'/../config.php';
define('ROOT',dirname(__DIR__));define('DATA_DIR',ROOT.'/data');define('UPLOAD_DIR',ROOT.'/uploads');
if(PHP_SAPI!=='cli'&&session_status()!==PHP_SESSION_ACTIVE){session_name('abshar_admin');session_start();}
function e(string $v):string{return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function u_lower(string $v):string{return function_exists('mb_strtolower')?mb_strtolower($v,'UTF-8'):strtolower($v);}function u_first(string $v):string{if(function_exists('mb_substr'))return mb_substr($v,0,1,'UTF-8');if(preg_match('/^./us',$v,$m))return$m[0];return substr($v,0,1);}
function load_json(string $n,array $d=[]):array{$p=DATA_DIR.'/'.$n.'.json';if(!is_file($p))return$d;$x=json_decode((string)file_get_contents($p),true);return is_array($x)?$x:$d;}
function save_json(string $n,array $d):void{file_put_contents(DATA_DIR.'/'.$n.'.json',json_encode($d,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT),LOCK_EX);}
function settings():array{return load_json('settings',[]);}function integrations():array{return load_json('integrations',[]);}function brands():array{return load_json('brands',[]);}function categories():array{return load_json('categories',[]);}function products():array{return load_json('products',[]);}
function config(string $k,mixed $d=null):mixed{global $config;$s=settings();$i=integrations();return $i[$k]??$s[$k]??$config[$k]??$d;}
function is_installed():bool{return is_file(DATA_DIR.'/.install.lock')||(string)config('site_name','')!=='';}
function site_url(string $path=''):string{$https=!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off';$host=$_SERVER['HTTP_HOST']??'localhost';return($https?'https':'http').'://'.$host.'/'.ltrim($path,'/');}
function normalize(string $s):string{$s=u_lower($s);$s=strtr($s,['أ'=>'ا','إ'=>'ا','آ'=>'ا','ى'=>'ي','ة'=>'ه']);return preg_replace('/[\s\-_\/\.]+/u','',$s)??$s;}
function product_score(array$p,string$q):int{if($q==='')return 1;$n=normalize($q);$h=normalize(implode(' ',[$p['name']??'',$p['brand']??'',$p['model']??'',$p['category']??'',implode(' ',$p['keywords']??[])]));if(str_contains($h,$n))return 100;similar_text($n,normalize(($p['brand']??'').($p['model']??'')),$pct);return(int)$pct;}
function product_by_slug(string $s):?array{foreach(products()as$p)if(($p['slug']??'')===$s&&($p['status']??'published')==='published')return$p;return null;}
function money(float|int|string $p):string{return number_format((float)$p,0).' '.config('currency','ج.م');}
function csrf_token():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(24));return $_SESSION['csrf'];}function verify_csrf():void{if(!hash_equals($_SESSION['csrf']??'',(string)($_POST['csrf']??''))){http_response_code(419);exit('انتهت صلاحية الطلب');}}
function is_admin():bool{return !empty($_SESSION['admin']);}function require_admin():void{if(!is_admin()){header('Location: login.php');exit;}}
