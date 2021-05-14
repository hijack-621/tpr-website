<?php
$ppid=$_POST['ppid'];
//$ppid="3";
$dirPath="D:/TestLog";
//鐎规矮绠熼崗銊ョ湰閸欐﹢鍣�閻€劋绨崣鏍у毐閺佷即鍣烽棃銏㈡畱閸婏拷
$paths=array();
//閹笛嗩攽闁秴宸�
recursion_readdir($dirPath);

/**
 *@summary   闁帒缍婄拠璇插絿閻╊喖缍�
 *@param $dirPath 閻╊喖缍�
 *@param $Deep=0 濞ｅ崬瀹抽敍宀�暏娴滃海缂夋潻锟介弮鐘绘付閹靛濮╃拋鍓х枂
 *@return 閺冿拷
 */
function recursion_readdir($dirPath,$Deep=0){
    global $paths;
    global $ppid;
    $resDir=opendir($dirPath);
    while(false!=($file=readdir($resDir))){
        //瑜版挸澧犻弬鍥︽鐠侯垰绶�
        $path=$dirPath.'/'.$file;
        if(is_dir($path) AND $file!='.' AND $file!='..'){
            //閺勵垳娲拌ぐ鏇礉閹垫挸宓冮惄顔肩秿閸氬稄绱濈紒褏鐢绘潻顓濆敩
            //echo $path.'/<br/>';
            $Deep++;//濞ｅ崬瀹�1
            recursion_readdir($path,$Deep);
        }else if(basename($path)!='.' AND basename($path)!='..'){
            //娑撳秵妲搁弬鍥︽婢剁櫢绱濋幍鎾冲祪閺傚洣娆㈤崥锟�            global $ppid;
                if ($ppid==basename($path,".log")){
					if(strpos($path,"QC2")){
						@copy($path,"../../html/search_PPID/tempqc2/".$ppid.".log");
						$paths[]=$path;
					}else if(strpos($path,"QC3")){
						@copy($path,"../../html/search_PPID/tempqc3/".$ppid.".log");
						$paths[]=$path;
						}
                     }
        }
    }

    closedir($resDir);

}
echo json_encode($paths);
?>