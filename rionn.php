<!-- サンプルコード -->
<h3>カレンダー年月選択</h3>
<?php
//年月の指定があれば
if(isset($_POST['yyyy']) && $_POST['yyyy'] != '' && isset($_POST['mm']) && $_POST['mm'] != ''){
    $yyyy = $_POST['yyyy'];
    $mm =   $_POST['mm'];
//指定がなければ本日の年月
}else{
    $yyyy = date('Y');
    $mm =   date('m');
}
$dd = 1;
?>
 
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
 
<select name="yyyy">
<?php
for($i = 1990; $i <= 2030; $i++){
     echo '<option value="'.$i.'"'; if($i == $yyyy) echo ' selected'; echo '>'.$i.'</option>'."\n";
}
?>
</select>年
 
<select name="mm">
<?php
for($i = 1; $i <= 12; $i++){
    echo '<option value="'.$i.'"'; if($i == $mm) echo ' selected'; echo '>'.$i.'</option>'."\n";
}
?>
</select>月
 
<input type="submit" value="更新">
 
</form>
 
<h3>カレンダー</h3>
<?php
//カレンダー関数
function calendar($yyyy, $mm, $dd){
 
    //選択日のタイムスタンプ
    $iSctDayTimeStamp = mktime(0,0,0,$mm,$dd,$yyyy);
    ?>
    <table border ="0" bgcolor="#cccccc" cellspacing="1">
    <?php
 
    ### 月列
    if(checkdate($mm, 1, $yyyy)){
    ?>
        <tr>
        <td bgcolor="#ffffff" colspan="7">
        <?php echo $yyyy; ?>年<?php echo $mm; ?>月 (<?php echo date('t',mktime(0, 0, 0, $mm, 1, $yyyy)); ?>日間)
        </td>
        </tr>
    <?php
    }
    ?>
 
    <?php
    ### 曜日列
    ?>
    <tr>
    <td bgcolor="#ffd0d0">日</td>
    <td bgcolor="#f7ffde">月</td>
    <td bgcolor="#f7ffde">火</td>
    <td bgcolor="#f7ffde">水</td>
    <td bgcolor="#f7ffde">木</td>
    <td bgcolor="#f7ffde">金</td>
    <td bgcolor="#def9ff">土</td>
    </tr>
 
    <?php
    ### 日付列
 
    //曜日NO
    $iWNoMthFst = date('w',mktime(0,0,0,$mm,1,$yyyy));//0:日～6:土
 
    //日付が始まる前の空白
    for($iFstWeekBnk = 0 ;$iFstWeekBnk < $iWNoMthFst ;$iFstWeekBnk++){
    ?>
        <td align='center' bgcolor='#FFFFFF'> </td>
    <?php
    }
 
    //日付記述 年月日の妥当性がtrueであればループ
    for($dd = 1 ;checkdate($mm, $dd, $yyyy); $dd++ ){
 
        //本日のタイムスタンプ
        $iTodayTimeStamp = mktime(0,0,0,date('m'),date('d'),date('Y'));
        //指定年月のループ日付のタイムスタンプ
        $iDisplayDaysTimeStamp = mktime(0,0,0,$mm,$dd,$yyyy);
 
        //1日が日曜日のとき　1　8　15　22　29が　== 1となる
        //日曜日
        if(($dd+$iWNoMthFst)%7 == 1){
            echo '<tr><td bgcolor="';
            //本日
            if($iTodayTimeStamp == $iDisplayDaysTimeStamp) echo '#ffe293';
            else echo '#ffd0d0';
            ?>
            "><?php echo $dd; ?></td>
        <?php
        }
        //土曜日
        elseif(($dd+$iWNoMthFst)%7 == 0){
            echo '<td bgcolor="';
            //本日
            if($iTodayTimeStamp == $iDisplayDaysTimeStamp) echo '#ffe293';
            else echo '#def9ff';
            ?>
            "><?php echo $dd; ?></td></tr>
        <?php
        }
        //平日
        else{
            echo '<td bgcolor="';
            //本日
            if($iTodayTimeStamp == $iDisplayDaysTimeStamp) echo '#ffe293';
            else echo '#ffffff';
            ?>
            "><?php echo $dd; ?></td>
        <?php
        }
    }
    //指定月最終日の曜日$ddは32になっている
    $iWNoMthEnd = date('w',mktime(0,0,0,$mm,$dd,$yyyy));
    if($iWNoMthEnd != 0){
        //もし32が日曜日すなわち0ならそれで終了
        for($iWeekBlank = 0 ; $iWeekBlank < 7-$iWNoMthEnd; $iWeekBlank++){
            //0以外は が必要
            echo '<td align="center" bgcolor="#FFFFFF"> </td>';
        }
    }
    ?>
    </tr></table>
    <?php
}// end function
?>
 
<?php
//カレンダー表示
calendar($yyyy, $mm, $dd);
?>
<?php
  <form id="form1" action="#">
    <p>日付:<br>
    <input type="text" name="day" id="day">
    <p>メモ内容:<br>
    <textarea name="text" cols="40" rows="8" id="text"></textarea>
    <input type="button" onclick="showMessage()" value="メモ">
  </form>
  <p id="output-message"></p>
  <script language="javascript" type="text/javascript">
    const showMessage = () => {
      const day = document.getElementById("day");
      const textbox = document.getElementById("text");
      const inputValue = day.value;
      const memoBox = textbox.value;

      const output = inputValue + "の予定は" + memoBox + "です。";

      document.getElementById("output-message").innerHTML = output;
    }
  </script>
?>