@extends('admin/layout.app')
@section('content')

<!-- vue 作用域 -->
<div id="xxcctty">
    <!---- 头部标题及导航链接 ---->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">货架管理</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

<div class="row" style="padding:20px;background:rgba(0, 0, 0, 0.15);">
    <div class="col-sm-8" style="
    height:600px;">
        <div class="col-sm-12 border bg-white" style="padding:10px;overflow-y: scroll; height:600px;">

            <div class="col-sm-12 " v-for="(val,key,index) in pallets" v-bind:class="{'btn-primary':palletShow===index}" @click="palletShow=index;palletActive=val"  style="background:#eee;margin-top:5px; padding:10px; display:flex;align-items:center;">
                <div class="col-sm-2 text-center">@{{key}}</div>

                <div class="col-sm-2" v-for="(item1,index1) in val" v-if="index1<5">
                    <el-tooltip class="item" effect="dark" v-bind:content="item1.product.zn_name" placement="top-start">
                        <img v-bind:src="item1.product.product_image" alt="" class="img-thumbnail">
                    </el-tooltip>
                </div>
                
            </div>

        </div>
    </div>
    <div class="col-sm-4 " style="pading: 10px;
    height:600px;">
        <div class="col-sm-12 bg-white"style="
        padding:10px;
        height:600px;">
            <div class="row " style="padding:5px">
                <el-input placeholder="请输入内容" v-model="search" class="input-with-select" size="medium">
                    <el-button slot="append" icon="el-icon-search"></el-button>
                </el-input>
            </div>
        <div class="row" style="height:530px;overflow-y: scroll;">

            <div class="col-sm-6" style="padding:10px" v-for="(item,index) in huojiaList"  >
                <div class="col-sm-12  text-center" v-bind:class="{'btn-primary':huojiaShow===index}" @click="huojiaShow=index"
                style="
                    background:#eee;
                    height:160px;
                    display:flex;
                    align-items:center;
                    justify-content: center;">
                    <p>@{{item.name}}</p>
                </div>
            </div>
        
        </div>
        </div>
    </div>
    <div class="col-sm-12" style="display:flex;align-items:center;justify-content: flex-end;margin-top: 20px;padding-right: 40px;">
        <button type="button" class="btn btn-primary" @click="save">SAVE</button>
    </div>
</div>

</div>
<!-- vue 作用域 end-->
<style>
.bgcolor{
    background:blue
}
</style>
<script>
var vm=new Vue({
    el:'#xxcctty',
    data:{
        search:'',
        huojiaShow:'',
        palletShow:'',
        pallets:[],
        huojia:[],
        palletActive:''
    },
    mounted() {
        
        $.get('/get/upper', function (res) {
                console.log(res)
                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('没有pallet');
                        return;
                    } else {
                        console.log(res)
                        vm.pallets=res.data.pallet
                        vm.huojia=res.data.shelves
                        alertify.success('数据加载完成');
                        
                    }
                
                } else {
                    alertify.alert(res.message);
                }

            })
    },
    methods: {
        save(){
            if(vm.huojiaShow.toString().length>0 && vm.palletShow.toString().length>0){
                var arr=[]
                vm.palletActive.forEach((item)=>{
                    var e={
                        "product_id":item.product_id,"count":item.count,"overdue":item.overdue
                    }
                    arr.push(JSON.stringify(e))
                })

                var data={
                    'pallet_id':vm.palletActive[0].pallet_id,
                    'shelves':vm.huojiaList[vm.huojiaShow].id,
                    'product':`[${arr}]`,
                    '_token': '{{csrf_token()}}'
                }
                $.post('/pallet/select', data, function (res) {

                    if (res.status) {
                        alertify.success('上架成功');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        alertify.alert(res.message);
                    }
                })
            }else{
                alertify.alert('请选择pallet&货架');
            }
        }
    },
    computed: {
        huojiaList(){
            var list=[]
            if(this.search.length>0){
                this.huojia.forEach((item)=>{
                    if(item.name.indexOf(this.search)>-1){

                        list.push(item)
                    }
                })
            }else{
                list=this.huojia
            }
            return list
        }
    },
})
</script>
@endsection