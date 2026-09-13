<?php
return [
 'app_version'=>'2.0.0','site_name'=>'مؤسسة أبشر للتوريدات والمعدات','site_tagline'=>'معدات احترافية. بيانات موثوقة. طلب مباشر.',
 'whatsapp_number'=>'','phone_number'=>'','currency'=>'ج.م','currency_code'=>'EGP','admin_username'=>'','admin_password_hash'=>'',
 'google_api_key'=>getenv('ABSHAR_GOOGLE_API_KEY')?:'','google_cx'=>getenv('ABSHAR_GOOGLE_CX')?:'','openai_api_key'=>getenv('ABSHAR_OPENAI_API_KEY')?:'','openai_model'=>getenv('ABSHAR_OPENAI_MODEL')?:'gpt-5-mini',
 'max_upload_mb'=>8,'login_max_attempts'=>7,'login_window_seconds'=>900
];