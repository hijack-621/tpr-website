<?php
session_start();

if (empty($_SESSION["uname"])){
	echo "10000";
	return;
}

if (!empty($_REQUEST['action'])) {
    try {
        $action = explode('/', $_REQUEST['action']);
        $class_name = $action[0];
        $method_name = $action[1];
        require $class_name . '.php';
        //ʵ����������
        $class = new ReflectionClass($class_name);
        //�ж����Ƿ����
        if (class_exists($class_name)) {
        	//�ж������Ƿ��и÷���
            if ($class->hasMethod($method_name)) {
            	/*
            	//��ø���ķ�����
                $func = $class->getmethod($method_name);
                //���Ǿ�̬������Ҫʵ��������
                $instance = $class->newInstance();
                //$func->invokeArgs($instance, array($_REQUEST));
                //$result = $instance->getResult();
                //ִ�и���ķ���
                $result = $func->invoke($instance);
                */
            	$instance = $class->newInstance();
            	if (!isset($_POST['urldata'])){
            		$result=$instance->$method_name();
            	}else{
            		$result=$instance->$method_name($_POST['urldata']);
            	}
            	return $result;
            }
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}