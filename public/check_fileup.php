<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
$login_user = $_SESSION['login_user'];

$user = new UserLogic;
$error = array();
// ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
// 一時保管場所のパス
$tmp_path = $file['tmp_name'];
// エラーを拾う
$file_err = $file['error'];
// サイズを拾う
$filesize = $file['size'];
$upload_dir = '../images/';
$save_filename = date('YmdHis') . $filename;
$save_path = $upload_dir . $save_filename;

// ファイルのバリデーション
// ファイルサイズ1MB未満か
if ($filesize > 1048576 || $file_err == 2) {
    array_push($error, 'ファイルサイズは1MB未満にしてください');
}
// 拡張子は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
// 拡張子を取得
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
// 拡張子が配列の中にあったらOK
if (!in_array(strtolower($file_ext), $allow_ext)) {/**strtolowerは大文字を小文字に変える */
    array_push($error, '画像ファイルを添付してください');
}/**終わり-バリデーション */


   // 空の連想配列は削除する
   $judge=array_filter($error);
   
   if(empty($judge)){
       // ファイルはあるかどうか
    if (is_uploaded_file($tmp_path)) {
        // エラーがなかったので画像をDB保存
        if (move_uploaded_file($tmp_path, $save_path)) {
            // DB保存(ファイル名、ファイルパス）
            $result = $user->fileSave($filename,$save_path,$login_user['user_id']);
            if($result){
                include('ok_profile.php');
            }else{
                echo'データベースへの保存が失敗しました';
            }
        }
    }

      
   }else{
    //    エラーがあれば戻る
       include('form_fileup.php');
   }
