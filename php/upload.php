<?php
    include('class.uploader.php');
    include('Database.Class.php');
    $db = Mysql::getInstance();
    $uploader = new Uploader();
    //var_dump($_FILES);
    $data = $uploader->upload($_FILES['file'], array(
        'limit' => 10, //Maximum Limit of files. {null, Number}
        'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
        'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
        'required' => false, //Minimum one file is required for upload {Boolean}
        'uploadDir' => '../uploads/', //Upload directory {String}
        'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
        'perms' => null, //Uploaded file permisions {null, Number}
        'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
        'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
        'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
        'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
        'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
        'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
   
   $arr = [];
   $arr2 = [];
   foreach ($_POST['formdata'] as $val){
       $arr[] = json_decode($val);
   }
   foreach ($arr as $val){
       $arr2[$val->name] = $val->value;
   }
    if($data['isComplete']){
        $files = $data['data'];
        $sql = "insert into 5c_tab (TPR,Model,issueTime,Failure_Symptom,Root_Cause,Failure_Analysis,Corrective_Action,owner,status,filename) values( '{$arr2['tpr']}','{$arr2['model']}','{$arr2['issuetime']}','{$arr2['fs']}','{$arr2['rc']}','{$arr2['fa']}','{$arr2['ca']}','{$arr2['opr']}','{$arr2['select']}','{$files['files'][0]}' )";
        //die($sql);
        $result = $db->carrySql($sql);
        $result > 0 ? $files['res'] = $result : $files['res']=0;
        echo  json_encode($files);
    }

    if($data['hasErrors']){
        $errors = $data['errors'];
        echo  json_encode($errors);
    }
    
    function onFilesRemoveCallback($removed_files){
        foreach($removed_files as $key=>$value){
            $file = '../uploads/' . $value;
            if(file_exists($file)){
                unlink($file);
            }
        }
        
        return $removed_files;
    }

