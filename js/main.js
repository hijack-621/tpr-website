let name_arr = [];
(function(){
    laydate.render({
        elem:'#laydate-range',
        range:'~',
        format:'yyyy-MM-dd',
        type:'date',
        ready:function(date){ //初始打开回调
            let c = document.querySelectorAll('.layui-laydate-content');
            c.forEach(v=>{
               let t =  v.querySelectorAll('table>tbody>tr>td');
               [...t].filter(v=>{
                  if([...v.classList].includes('layui-this')){
                   return v.classList.remove('layui-this');
                  }
               })
            })
            //console.log(c);
        }
    })
    
    let mxl = xmSelect.render({
        el:'#mxl',
        filterable:true,
        language:'zn',
        height:'150px',
        radio:true,
        paging: true,
        searchTips:'请输入model关键字',
        theme:{
            color:'#5fb878',
        },
        data:[
           
        ],
    });
    let txl = xmSelect.render({
        el:'#txl',
        filterable:true,
        language:'zn',
        height:'150px',
        radio:true,
        theme:{
            color:'#5fb878',
        },
        data:[
           {name:'RLC_SH',value:'TPR_RLC-SH'},
           {name:'CEP',value:'TPR_CEP'},
           {name:'CEB',value:'TPR_CEB'},
           {name:'IGS',value:'TPR_IGS'},
           {name:'IVY',value:'TPR_IVY'},
           {name:'Bizcom',value:'TPR_Bizcom'},
           {name:'ICC-RLG',value:'TPR_ICC-RLG'},
           {name:'CTDI',value:'TPR_CTDI'},
        ],
    });
    let sxl = xmSelect.render({
        el:'#sxl',
        filterable:true,
        language:'zn',
        height:'150px',
        radio:true,
        theme:{
            color:'#5fb878',
        },
        data:[
           {name:'Open',value:'Status_open'},
           {name:'On-Going',value:'Status_ing'},
           {name:'Close',value:'Status_close'},
           
        ],
    });
    $.ajax({
        url:'./php/main.php',
        type:'post',
        datatype:'json',
        method:'post',
        data:{flag:'getopts'},
        success:function(data){
            // console.log(JSON.parse(data));
            let arr = [];
           
            for (const val of JSON.parse(data)) {
                let obj = {};
                obj.name = val.model;
                obj.value = 'Model_'+val.model;
                arr.push(obj);
            }
            // console.log(arr);
            mxl.update({
                data:arr,
                AutoRow:true,
            })

        },
        error:function(data){

        }
    })
})()

function search(){
    let fd = $('#fm').serializeArray();
    let fdt = fd.filter(v=>{ //得到值不为空的数据
        return v.value !='';
    });
    
    $.ajax({
        url:'./php/main.php',
        type:'post',
        dataType:'json',
        data:{flag:'search',data:fdt},
        success:function(data){
            console.log(data);
            let ftr = $('.mt>table>tbody');
            if(data.length==0){
                //console.log(ftr[0].innerHTML);
                ftr[0].innerHTML = ftr[0].innerHTML.replace(/[\s\S]+/,(v)=>{ 
                    return `<tr>
                        <td colspan="4">no data was Found</td>
                    </tr>`;
                })
            }else{
                ftr[0].innerHTML = '';
                let html = ``;
                for(let i=0;i<data.length;i++){
                    let t = data[i]['filename'].split('/');
                    name_arr.push(t[t.length-1]);
                    html+=`<tr>
                        <td>${data[i]['TPR']}</td>
                        <td><a href="${data[i]['filename'].replace(/[(../)]*/,'./')}" download='${t[t.length-1]}'>${t[t.length-1]}</a></td>
                        <td>${data[i]['issueTime']}</td>
                        <td>${data[i]['owner']}</td>
                    </tr>`
                }
                ftr[0].innerHTML = html;
                console.log(name_arr);
            }
        },
        error:function(data){

        }
    })
    
    

}
function dar(){
    $.ajax({
        url:'./php/main.php',
        type:'post',
        dataType:'json',
        data:{flag:'download'},
        success:function(data){
            if(JSON.parse(data)=='200'){
                let a = document.createElement('a');
                a.href="./uploads/report/reports.zip";
                a.download = 'reports.zip';
                let event = new MouseEvent('click');
                if(a.dispatchEvent(event)){
                    alert('请求ok，正在执行下载，请稍后...');
                }
                
            }
        }
    })
}

export {search,name_arr,dar};
   






