<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/

/** This file is part of KCFinder project
  * 
  * @desc Japanese localization
  * @package KCFinder
  * @version 2.54
  * @author yama yamamoto@kyms.jp
  * @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  * @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  */

$lang = array(

    '_locale' => "ja_JP.UTF-8",  // UNIX localization code
    '_charset' => "utf-8",       // Browser charset

    // Date time formats. See http://www.php.net/manual/en/function.strftime.php
    '_dateTimeFull' => "%Y/%m/%d %H:%M",
    '_dateTimeMid' => "%Y/%m/%d %H:%M",
    '_dateTimeSmall' => "%Y/%m/%d %H:%M",

    "You don't have permissions to upload files." => "アップロード権限がありません。",
    "You don't have permissions to browse server." => "サーバーを閲覧する権限がありません",
    "Cannot move uploaded file to target folder." => "ファイルを移動できません。",
    "Unknown error." => "原因不明のエラーです。",
    "The uploaded file exceeds {size} bytes." => "アップロードしたファイルは {size} バイトを越えました。",
    "The uploaded file was only partially uploaded." => "アップロードしたファイルは、一部のみ処理されました。",
    "No file was uploaded." => "ファイルはありません。",
    "Missing a temporary folder." => "tempフォルダが見つかりません。",
    "Failed to write file." => "ファイルの書き込みに失敗しました。",
    "Denied file extension." => "このファイルは扱えません。",
    "Unknown image format/encoding." => "この画像ファイルの種別を判定できません。",
    "The image is too big and/or cannot be resized." => "画像ファイルのサイズが大き過ぎます。",
    "Cannot create {dir} folder." => "「{dir}」フォルダを作成できません。",
    "Cannot rename the folder." => "フォルダ名を変更できません",
    "Cannot write to upload folder." => "アップロードフォルダに書き込みできません。",
    "Cannot read .htaccess" => ".htaccessが読み込めません。",
    "Incorrect .htaccess file. Cannot rewrite it!" => "不正な .htaccess ファイルです。再編集できません!",
    "Cannot read upload folder." => "アップロードフォルダを読み取れません。",
    "Cannot access or create thumbnails folder." => "サムネイルフォルダにアクセス、または作成できません。",
    "Cannot access or write to upload folder." => "アップロードフォルダにアクセス、または書き込みできません。",
    "Please enter new folder name." => "新しいフォルダ名を入力して下さい。",
    "Unallowable characters in folder name." => "フォルダ名に使用できない文字が含まれています。",
    "Folder name shouldn't begins with '.'" => "フォルダ名は、'.'で開始しないで下さい。",
    "Please enter new file name." => "新しいファイル名を入力して下さい。",
    "Unallowable characters in file name." => "ファイル名に使用できない文字が含まれています。",
    "File name shouldn't begins with '.'" => "ファイル名は「. 」で始めることはできません。",
    "Are you sure you want to delete this file?" => "このファイルを本当に削除してもよろしいですか?",
    "Are you sure you want to delete this folder and all its content?" => "このフォルダとフォルダ内の全てのコンテンツを本当に削除してもよろしいですか?",
    "Non-existing directory type." => "存在しないディレクトリの種類です。",
    "Undefined MIME types." => "定義されていないMIMEタイプです。",
    "Fileinfo PECL extension is missing." => "Fileinfo PECL 拡張モジュールが見付かりません。",
    "Opening fileinfo database failed." => "fileinfo データベースを開くのに失敗しました。",
    "You can't upload such files." => "このようなファイルをアップロードできません。",
    "The file '{file}' does not exist." => "ファイル「{file}」は存在しません。",
    "Cannot read '{file}'." => "「{file}」を読み取れません。",
    "Cannot copy '{file}'." => "「{file}」をコピーできません。",
    "Cannot move '{file}'." => "「{file}」を移動できません。",
    "Cannot delete '{file}'." => "「{file}」を削除できません。",
    "Cannot delete the folder." => "フォルダを削除できません",
    "Click to remove from the Clipboard" => "クリップボードから削除する",
    "This file is already added to the Clipboard." => "このファイルは既にクリップボードに追加されています。",
    "The files in the Clipboard are not readable." => "クリップボードからファイルを読み取れません",
    "{count} files in the Clipboard are not readable. Do you want to copy the rest?" => "クリップボード内の {count} 個のファイルが読み取れません。残りをコピーしてもよろしいですか?",
    "The files in the Clipboard are not movable." => "クリップボードからファイルを移動できません",
    "{count} files in the Clipboard are not movable. Do you want to move the rest?" => "クリップボード内の {count} 個のファイルが移動できません。残りを移動してもよろしいですか?",
    "The files in the Clipboard are not removable." => "クリップボードを初期化できません",
    "{count} files in the Clipboard are not removable. Do you want to delete the rest?" => "クリップボード内の {count} 個のファイルが削除出来ません。残りを削除してもよろしいですか?",
    "The selected files are not removable." => "選択したファイルは削除できません。",
    "{count} selected files are not removable. Do you want to delete the rest?" => "選択された {count} 個のファイルは削除できません。残りを削除してもよろしいですか?",
    "Are you sure you want to delete all selected files?" => "選択された全てのファイルを本当に削除してもよろしいですか?",
    "Failed to delete {count} files/folders." => "{count} 個のファイル / フォルダの削除に失敗しました。",
    "A file or folder with that name already exists." => "その名前のファイル、またはフォルダは既に存在します。",
    "Copy files here" => "ここにコピー",
    "Move files here" => "ここに移動",
    "Delete files" => "これらを全て削除",
    "Clear the Clipboard" => "クリップボードを初期化",
    "Are you sure you want to delete all files in the Clipboard?" => "クリップボードに記憶した全てのファイルを実際に削除します。",
    "Copy {count} files" => "ファイル({count}個)をここに複写",
    "Move {count} files" => "ファイル({count}個)をここに移動",
    "Add to Clipboard" => "クリップボードに記憶",
    "Inexistant or inaccessible folder." => "存在しない、またはアクセスできないフォルダです。",
    "New folder name:" => "フォルダ名(半角英数):",
    "New file name:" => "ファイル名(半角英数):",
    "Upload" => "アップロード",
    "Refresh" => "再表示",
    "Settings" => "表示設定",
    "Maximize" => "最大化",
    "About" => "About",
    "files" => "ファイル",
    "selected files" => "選択したファイル",
    "View:" => "表示スタイル:",
    "Show:" => "表示項目:",
    "Order by:" => "表示順:",
    "Thumbnails" => "サムネイル",
    "List" => "リスト",
    "Name" => "ファイル名",
    "Type" => "タイプ",
    "Size" => "サイズ",
    "Date" => "日付",
    "Descending" => "順序を反転",
    "Uploading file..." => "ファイルをアップロード中",
    "Loading image..." => "画像を読み込み中",
    "Loading folders..." => "フォルダを読み込み中",
    "Loading files..." => "読み込み中",
    "New Subfolder..." => "フォルダを作る",
    "Rename..." => "名前の変更",
    "Delete" => "削除",
    "OK" => "OK",
    "Cancel" => "キャンセル",
    "Select" => "このファイルを選択",
    "Select Thumbnail" => "サムネイルを選択",
    "Select Thumbnails" => "サムネイルを選択",
    "View" => "プレビュー",
    "Download" => "ダウンロード",
    "Download files" => "ファイルをダウンロードする",
    "Clipboard" => "クリップボード",
    "Checking for new version..." => "新しいバージョンを確認中",
    "Unable to connect!" => "接続できません",
    "Download version {version} now!" => "新しいバージョン（{version}）をダウンロードできます",
    "KCFinder is up to date!" => "KCFinderは最新です。",
    "Licenses:" => "ライセンス",
    "Attention" => "注意",
    "Question" => "確認",
    "Yes" => "はい",
    "No" => "いいえ",
    "You cannot rename the extension of files!" => "ファイルの拡張子を変更できませんでした",
    "Uploading file {number} of {count}... {progress}" => "ファイルをアップロード中（{number}/{count}）... {progress}",
    "Failed to upload {filename}!" => "{filename}のアップロードに失敗しました",
);

?>
