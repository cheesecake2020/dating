<?php
/**
 * XSS対策：エスケープ処理
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */
function h($str){
    return htmlspecialchars($str, ENT_QUOTES,"UTF-8");
}

/**
 * csrf対策：ワンタイムトークン
 * @param void
 * @return string $csrf_token
 */
function setToken(){
    // トークンの生成
    // フォームからトークンの生成
    // 送信後の画面でそのトークンを紹介
    // トークンの削除
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}
$blood_types = [
    ''=>'選択下さい',
    'A'=>'A',
    'B'=>'B',
    'O'=>'O',
    'AB'=>'AB'
];
$school = [
    ''=>'選択下さい',
    'tyugaku'=>'中学卒業',
    'koukou'=>'高校卒業',
    'tandai'=>'短大・専門学校卒業',
    'kousen'=>'高専卒業',
    'daigaku'=>'大学卒業',
    'daigakuin'=>'大学院卒業',
    'sonota'=>'その他'
];

$states = [
    ''      => '選択下さい。',
    'hokkai'     => '北海道',
    'aomori'     => '青森県',
    'iwate'      => '岩手県',
    'miyagi'     => '宮城県',
    'akita'      => '秋田県',
    'yamagata'   => '山形県',
    'fukushima'  => '福島県',
    'ibaraki'    => '茨城県',
    'tochigi'    => '栃木県',
    'gunma'      => '群馬県',
    'saitama'    => '埼玉県',
    'chiba'      => '千葉県',
    'tokyo'      => '東京都',
    'kanagawa'   => '神奈川県',
    'yamanashi'  => '山梨県',
    'nagano'     => '長野県',
    'nigata'     => '新潟県',
    'toyama'     => '富山県',
    'ishikawa'   => '石川県',
    'hukui'      => '福井県',
    'gihu'       => '岐阜県',
    'shizuoka'   => '静岡県',
    'aichi'      => '愛知県',
    'mie'        => '三重県',
    'shiga'      => '滋賀県',
    'kyouto'     => '京都府',
    'osaka'      => '大阪府',
    'hyogo'      => '兵庫県',
    'nara'       => '奈良県',
    'wakayama'   => '和歌山県',
    'totori'     => '鳥取県',
    'shimane'    => '島根県',
    'okayama'    => '岡山県',
    'hiroshima'  => '広島県',
    'yamaguchi'  => '山口県',
    'tokushima'  => '徳島県',
    'kagawa'     => '香川県',
    'ehime'      => '愛媛県',
    'kouchi'     => '高知県',
    'fukuoka'    => '福岡県',
    'saga'       => '佐賀県',
    'nagasaki'   => '長崎県',
    'kumamoto'   => '熊本県',
    'oita'       => '大分県',
    'miyazaki'   => '宮崎県',
    'kagoshima'  => '鹿児島県',
    'okinawa'    => '沖縄県'
];
$works =[
    ''=>'選択下さい',
    'IT'=>'IT関連',
    'iryo'=>'医療関係',
    'kyouiku'=>'教育関係',
    'noougyou'=>'農業',
    'biyou'=>'美容・アパレル',
    'insyoku'=>'飲食関係',
    'keiei'=>'経営者',
    'sonota'=>'その他'
];
    
?>
