/**
 * 
 * 预警模型构建组件
 * @description 
 * @author 苏锐佳
 * @date 2017/05/09
 * 
 */
<template>
    <div class="middle">
        <!-- 导航条模块 -->
        <el-breadcrumb separator="/" id="nav" v-if="navbarName">
            <el-breadcrumb-item>{{navbarName}}</el-breadcrumb-item>
            <el-breadcrumb-item>{{subNavBarName}}</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="model-handle">
            <div>
                <el-button>溯源数据</el-button>
                <el-button>导入数据</el-button>
                <el-button>生成模型</el-button>
            </div>
        </div>
        
        <el-upload
            class="upload-demo"
            drag
            action="//jsonplaceholder.typicode.com/posts/"
            mutiple>
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            <div class="el-upload__tip" slot="tip">只能上传excel文件</div>
        </el-upload>

    </div>
</template>

<style lang="sass" scoped>
    @import "../../../sass/function";

    #nav {
        height: pxToRem(62);
        line-height: pxToRem(62);
        padding-left: pxToRem(25);
        font-size: pxToRem(20);
    }

    .model-handle {

        padding: pxToRem(20) 0;
        margin: 0 pxToRem(25);
        border-bottom: 1px solid #d9d9d9;

        div {
            margin-right: 10px;
            display: inline-block;
        }
    }
</style>

<script>

    import {mapGetters} from 'vuex'

    export default{
        name:'Model',
        data () {
            return {}
        },
        computed: {
            ...mapGetters([
                'navbarName',
                'subNavBarName'
            ])
        },
        methods: {}
    }
</script>
