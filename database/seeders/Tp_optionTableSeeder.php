<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tp_optionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tp_options')->insert([
            [
                'id' => 1,
                'option_name' => 'general_settings',
                'option_value' => json_encode([
                    'company' => 'Theme Posh',
                    'email' => 'martsutta@gmail.com',
                    'phone' => '7827422855',
                    'site_name' => 'Organis',
                    'site_title' => 'Mart sutta online shop & Laravel11 eCommerce',
                    'address' => 'sector 12 $ 22 Noida 201301 uttar pradesh india. ',
                    'timezone' => 'Asia/india'
                ]),
                'created_at' => '2021-03-31 15:59:45',
                'updated_at' => '2022-09-09 04:20:21',
            ],
            [
                'id' => 2,
                'option_name' => 'google_recaptcha',
                'option_value' => json_encode([
                    'sitekey' => '---------------------------------------------------------------',
                    'secretkey' => '---------------------------------------------------------------',
                    'is_recaptcha' => 0
                ]),
                'created_at' => '2021-03-31 17:56:01',
                'updated_at' => '2022-09-09 04:13:38',
            ],
            [
                'id' => 3,
                'option_name' => 'mail_settings',
                'option_value' => json_encode([
                    'ismail' => 0,
                    'from_name' => 'Martsutta',
                    'from_mail' => 'Martsutta@gmail.com',
                    'to_name' => 'Theme Posh',
                    'to_mail' => 'martsutta@gmail.com',
                    'mailer' => 'smtp',
                    'smtp_host' => 'mail.companyname.com',
                    'smtp_port' => '465',
                    'smtp_security' => 'ssl',
                    'smtp_username' => 'admin@admin.com',
                    'smtp_password' => 'companyname'
                ]),
                'created_at' => '2021-06-03 19:33:17',
                'updated_at' => '2022-09-09 04:14:48',
            ],
            [
                'id' => 4,
                'option_name' => 'theme_option_seo',
                'option_value' => json_encode([
                    'og_title' => 'Lorem Ipsum un testo segnaposto utilizzato nel settore della tipografia e della stampa.',
                    'og_image' => '01072022095735-200x200-h1-layer5.png',
                    'og_description' => 'Lorem Ipsum un testo segnaposto utilizzato nel settore della tipografia e della stampa.',
                    'og_keywords' => 'Lorem Ipsum un testo segnaposto utilizzato nel settore della tipografia e della stampa.',
                    'is_publish' => '1',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 5,
                'option_name' => 'theme_logo',
                'option_value' => json_encode([
                    'favicon' => '24062022060012-favicon.ico',
                    'front_logo' => '24062022060027-200x200-logo.png',
                    'back_logo' => '24062022060027-200x200-logo.png',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 6,
                'option_name' => 'facebook',
                'option_value' => json_encode([
                    'fb_app_id' => null,
                    'is_publish' => '2',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 7,
                'option_name' => 'twitter',
                'option_value' => json_encode([
                    'twitter_id' => null,
                    'is_publish' => '2',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 8,
                'option_name' => 'whatsapp',
                'option_value' => json_encode([
                    'whatsapp_id' => '0123456789',
                    'whatsapp_text' => null,
                    'position' => 'left',
                    'is_publish' => '1',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 9,
                'option_name' => 'cash_on_delivery',
                'option_value' => json_encode([
                    'description' => 'Please pay money directly to the postman, if you choose cash on delivery method (COD).',
                    'isenable' => 1,
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 10,
                'option_name' => 'paypal',
                'option_value' => json_encode([
                    'paypal_client_id' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'paypal_secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'paypal_currency' => 'USD',
                    'ismode_paypal' => 1,
                    'isenable_paypal' => 0,
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 11,
                'option_name' => 'cookie_consent',
                'option_value' => json_encode([
                    'title' => 'Cookie Consent',
                    'message' => 'This website uses cookies or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to our',
                    'button_text' => 'Accept',
                    'learn_more_url' => 'https://organis.themeposh.net/page/47/cookie-policy',
                    'learn_more_text' => 'Privacy Policy',
                    'style' => 'minimal',
                    'position' => 'left',
                    'is_publish' => '1',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ],
            [
                'id' => 12,
                'option_name' => 'currency',
                'option_value' => json_encode([
                    'currency_name' => 'USD',
                    'currency_icon' => '$',
                    'currency_position' => 'left',
                    'thousands_separator' => 'comma',
                    'decimal_separator' => 'point',
                    'decimal_digit' => '2',
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('2025-03-11 10:38:12')),
            ]
            ]);
    }
}
