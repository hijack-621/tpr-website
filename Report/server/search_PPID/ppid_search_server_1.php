<?php
$ppid=$_POST['ppid'];
$bgtime=$_POST['bgtime'];
$edtime=$_POST['edtime'];
$dirPath="D:/TestLog";
//闂佽姘﹂～澶愭儗椤斿墽涓嶉柣鏃傚帶缁�倿鏌曟繛鍨姢婵狅拷鍗抽弻娑樷枎閹版儼锟介梺闈╃秶閹风兘姊洪悜鈺佷壕闁告柨顑囬懞閬嶎敆閸曨偆鐓戦梺鍝勮癁閸愨晝妲梻浣芥〃濡炴帡宕￠幎钘夐棷闁绘垼濮らˉ鍫ユ煏韫囧鐏柣锝変憾閺屾稒绻濊箛鏂款伓
$paths=array();
//闂備礁婀遍悷鎶藉幢閳哄倹鏉搁梻鍌欑贰閸撴瑧绮旈弶鎴晠闁跨噦鎷�
recursion_readdir($dirPath);
/**
 *@summary   闂傚倷绶￠崑鍛暜閹烘梻绀婂┑鐘插鐎氭岸鎮归崶銊ョ祷缂佹彃娼￠弻锝夊煛婵犲倹鐏堢紓鍌氱▌閹凤拷 *@param $dirPath 闂備胶鍎甸弲鈺呭窗閺嶎偆绀婇柨鐕傛嫹 *@param $Deep=0 婵犵數鍎戠徊钘夌暦椤掑偊鎷烽柟鎯板Г閺咁剛锟介敓鑺ュ闁哄棗绻愰湁婵犲﹤鍟幑锝囩磽閸屾凹妲规繛鐓庮煼閺佹挻绂掔�顏嗙潉闂佺粯顭囩划顖涚濮楋拷鐓欓梻鍫熶緱閸庡繐鈹戦瑙勬珖闁瑰嘲顑夊畷婊嗩槾闁哄鎷� *@return 闂備礁鎼崰娑㈠箯閿燂拷*/
function recursion_readdir($dirPath,$Deep=0){
   global $paths,$qc2_file,$qc3_file,$bgtime,$edtime;
    $resDir=opendir($dirPath);
    while(false!=($file=readdir($resDir))){
        //闁荤喐绮庢晶妤呭箰閸涘﹥娅犻柣妯款嚙濡﹢鏌涢妷顖炴妞ゆ劒绮欓幃瑙勭瑹椤栨氨浠╃紓浣筋啇閹凤拷        $path=$dirPath.'/'.$file;
        $path=$dirPath.'/'.$file;
        if(is_dir($path) AND $file!='.' AND $file!='..'){
            if ($Deep>7){
                if ($file>$bgtime&&$file<$edtime){
                    $paths[]=$path;
                }
            }
            //闂備礁鎼�鐑藉垂閸愯娲箯鐏炶姹楅梺鍝勬祩娴滅偟绮堟径鎰厵闁割煈鍋呯亸顓狅拷閹惧啿鏆ｉ柟顖氬椤㈡瑩鎳栭埡鍐冾參姊洪崨濠呭缂佸瀚Σ鎰攽閸垻锛滈悷婊冪箻閹晫绱掑Ο璁虫唉濡炪倖鎸荤换鍌炲极閿燂拷            //echo $path.'/<br/>';
            $Deep++;//婵犵數鍎戠徊钘夌暦椤掑偊鎷烽柨鐕傛嫹
            recursion_readdir($path,$Deep);
        }
        }


    closedir($resDir);

}
$path_arr=array();
$qc2_file=array();
$qc3_file=array();
$time=array();
//閻庣數鎳撻崣楣冩嚔瀹勬壆绻侀柣銊ュ椤戜線宕ラ崼鐔歌拫濞寸姴澧庡▓鎴﹀棘閸ワ附顐藉鎯邦潐閺嗙喓绱掗崟顔界グ濠㈣泛瀚幃锟�for ($i=0;$i<count($paths);$i++){
    $resDir=opendir($paths[$i]);
    while(false!=($file=readdir($resDir))){
        $path=$paths[$i].'/'.$file;
        if(!is_dir($path) AND $file!='.' AND $file!='..'){
            if ($ppid==basename($file,".log")){
                if (strpos($path,"QC2")){
                    $qc2_file[]=$path;//$i

                }else if(strpos($path,"QC3")){
                    $qc3_file[]=$path;//$i

                }
            }
        }
    }
}
//闁硅泛锕ラ弸鍐╃鐠轰警妲婚柛鎺曟硾閸╁瞼绱旈幋锔猴拷闁哄倸娲ｅ▎銏″緞閻熸澘鏁堕柛娆樺灟娴滄帗绋夌�顓熺グ
//闁告帇鍊栭弻鍥及椤栨碍鍎婇柡鍫濐槹閺嗙喖骞戦敓锟�
if(count($qc2_file)>0){
$time=explode("/",$qc2_file[0]);
$final_path=$qc2_file[0];
$temp_file=explode("/",$qc2_file[0]);
for($d=0;$d<count($qc2_file);$d++){
    $temp=explode("/",$qc2_file[$d]);
    if($temp[4]>$time[4]){
        $time=explode("/",$qc2_file[$d]);
        $temp_file=explode("/",$qc2_file[$d]);
        $final_path= $qc2_file[$d];
    }
}
@copy($final_path,"../../html/search_PPID/tempqc2/".$temp_file[5]);
$path_arr[]=$final_path;
}else {

}
if(count($qc3_file)>0){
$time=explode("/",$qc3_file[0]);
$final_path=$qc3_file[0];
$temp_file=explode("/",$qc3_file[0]);
for($d=0;$d<count($qc3_file);$d++){
    $temp=explode("/",$qc3_file[$d]);
    if($temp[4]>$time[4]){
        $time=explode("/",$qc3_file[$d]);
        $temp_file=explode("/",$qc3_file[$d]);
        $final_path= $qc3_file[$d];
    }
}
@copy($final_path,"../../html/search_PPID/tempqc3/".$temp_file[5]);
$path_arr[]=$final_path;
}
echo json_encode($path_arr);

?>