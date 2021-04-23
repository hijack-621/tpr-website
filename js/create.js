
function save(){
  let formdata = $('#fm').serializeArray();
  //console.log(formdata);
    //   let files = $('#demo-fileInput-6')[0].files;
  let fdata = new FormData();
  import('./custom.js')
    .then( (v)=>{//v为返回的module对象，包含export导出的方法和变量
        // console.dir(v);
        if(v.curfiles.length==0){
            let files = $('#demo-fileInput-6')[0].files;
            Array.apply(null,files).forEach(file=>{
                fdata.append('file[]',file);
            })
        }else{
            v.curfiles.forEach(file=>{
                fdata.append('file[]',file);
            })
        }
        for (const val of formdata) {
            fdata.append('formdata[]',JSON.stringify(val));
            //formdata传递数组或者对象是，先转成json字符串在append
        }
        //console.log(fdata.getAll('formdata[]'));
        return new Promise( (resolve,reject)=>{
            resolve(fdata);
        })
       
    }).then(v=>{
        let len = v.getAll('file[]').length;
        //console.log(formdata.entries());

        if(len>0){
            for (const val of formdata.values()) {
                if(val.value==''){
                    alert(val.name+'栏位为空,如无需完整填写，请用none代替空');
                    return ;
                }
            }
           
            $.ajax({
                    url:'./php/upload.php',
                    method:'post',
                    dataType:'json',
                    processData:false,
                    contentType:false,
                    data:fdata,
                    success:function(data){
                        console.log(data);
                        if(data['res']==1){
                            layer.msg('success!',{icon:1},function(){
                                //window.location.reload();
                            })
                        }
                    },
                    error:function(msg){
                        console.log(msg)
                    }

            })
           

        }else {
            alert('文件不能为空');
        }
        
        // if(len>0){ //>0 有file上传

        // }
       

    })
    
 
  
}

// let file = document.querySelector('[name="files[]"]');
// file.addEventListener('change',function(ev){
//     console.log(ev.target.files);
// });
export {save}
