<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title> file list </title>
</head>
<body>
<?php
  $path = ".";

  $directory = dir($path);

  // $path以下のファイルやディレクトリを最終更新日付きで配列に入れる
  $path_arr = array();
  while(false !== ($entry = $directory->read())) { // PHPではファイル名が'0'とかだとfalseと判定されるのでこう書く
    $path_arr[] = array(
      'name' => $entry,
      'filemtime' => filemtime($entry)
    );
  }
  $directory->close();

  // 最終更新日で比較する関数
  // usortで使用する
  function cmp_filemtime($a, $b) {
    if($a['filemtime'] == $b['filemtime']) {
      return 0;
    }
    return ($a['filemtime'] < $b['filemtime']) ? -1 : 1;
  }

  // 最終更新日で$path_arrを並び替える
  usort($path_arr, "cmp_filemtime");

  // 出力
  print "<OL>";
  foreach($path_arr as $v) {
    print "<LI>";
    print sprintf("<a href='%s/%s'>%s</a>", $path, $v['name'], $v['name']);
    print "<FONT size='-1'>";
    print date("Y/m/d h:i:s", $v['filemtime']);
    print "</FONT>";
    print "</LI>";
  }
  print "</OL>";
?>
</body>
