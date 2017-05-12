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

        <vue-perfect-scrollbar id="tables">
            <ul>
                <li v-for="(item, index) in indexDatas">
                    <el-tooltip 
                        :content="item.remark" placement="top" effect="light">
                        <el-button class="title">{{item.indexName}}</el-button>
                    </el-tooltip>
                    <table class="index-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>第一类</th>
                                <th>第二类</th>
                                <th>第三类</th>
                                <th>第四类</th>
                                <th>第五类</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="item.index.length == 5">
                                <td>选项</td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 9}" 
                                    @click="changeValue(item.indexName, 9)">
                                    非常好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 7}" 
                                    @click="changeValue(item.indexName, 7)">
                                    比较好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 5}" 
                                    @click="changeValue(item.indexName, 5)">
                                    一般
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 3}" 
                                    @click="changeValue(item.indexName, 3)">
                                    比较不好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 1}" 
                                    @click="changeValue(item.indexName, 1)">
                                    非常不好
                                </td>
                            </tr>
                            <tr v-if="item.index.length == 4">
                                <td>选项</td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 9}" 
                                    @click="changeValue(item.indexName, 9)">
                                    非常好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 7}" 
                                    @click="changeValue(item.indexName, 7)">
                                    比较好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 5}" 
                                    @click="changeValue(item.indexName, 5)">
                                    一般
                                </td>
                                <td 
                                    colspan="2" 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 2}" 
                                    @click="changeValue(item.indexName, 2)">
                                    比较不好~非常不好
                                </td>
                            </tr>
                            <tr v-if="item.index.length == 3">
                                <td>选项</td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 9}" 
                                    @click="changeValue(item.indexName, 9)">
                                    非常好
                                </td>
                                <td 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 7}" 
                                    @click="changeValue(item.indexName, 7)">
                                    比较好
                                </td>
                                <td 
                                    colspan="3" 
                                    :class="{pointer: true, 'pointer-click': modelValue[index].value == 1}" 
                                    @click="changeValue(item.indexName, 1)">
                                    非常不好
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr v-if="item.more">
                                <td colspan="6">
                                    <ul v-if="item.index.length == 5">
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 8}" 
                                            @click="changeValue(item.indexName, 8)">
                                            1~2
                                        </li>
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 6}" 
                                            @click="changeValue(item.indexName, 6)">
                                            2~3
                                        </li>
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 4}" 
                                            @click="changeValue(item.indexName, 4)">
                                            3~4
                                        </li>
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 2}" 
                                            @click="changeValue(item.indexName, 2)">
                                            4~5
                                        </li>
                                    </ul>
                                    <ul v-if="item.index.length == 4">
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 8}" 
                                            @click="changeValue(item.indexName, 8)">
                                            1~2
                                        </li>
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 6}" 
                                            @click="changeValue(item.indexName, 6)">
                                            2~3
                                        </li>
                                    </ul>
                                    <ul v-if="item.index.length == 3">
                                        <li 
                                            :class="{pointer: true, 'pointer-click': modelValue[index].value == 8}" 
                                            @click="changeValue(item.indexName, 8)">
                                            1~2
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td 
                                    colspan="6" 
                                    class="next-level-btn"
                                    @click="more(index)"
                                    >
                                    <i v-if="item.more" class="el-icon-arrow-up"></i>
                                    <i v-else class="el-icon-arrow-down"></i>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="detail">
                        <p>度量值：{{modelValue[index].value}}</p>
                        <p>说明：{{detail(index)}}</p>
                    </div>
                </li>
            </ul>
        </vue-perfect-scrollbar>
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

    #tables {
        padding: pxToRem(20) 0;
        margin: 0 pxToRem(25);

        &>ul>li {
            padding: 15px 0;
            overflow: hidden;
            border-bottom: 1px solid #dfe6ec;
        }

        .title {
            float: left;
            margin-bottom: pxToRem(7);
            clear: both;
        }

        .title {
            cursor: pointer;
        }

        .index-table {

            float: left;
            clear: both;
            margin-right: pxToRem(20);

            tr {
                background-color: #fff;
            }

            th, td {
                width: pxToRem(100);
                height: pxToRem(50);
                font-weight: normal;
                text-align: center;
                border: 1px solid #dfe6ec;

                ul {
                    margin-left: pxToRem(150);

                    li {
                        float: left;
                        width: pxToRem(100);
                        height: pxToRem(50);
                        line-height: pxToRem(50);
                        border-left: 1px solid #dfe6ec;
                    }

                    li:last-child {
                        border-right: 1px solid #dfe6ec;
                    }
                    
                }
            }

            .next-level-btn {
                height: pxToRem(20);
                cursor: pointer;
            }

            .pointer {
                cursor: pointer;
            }

            .pointer-click, .pointer:hover {
                color: white;
                background-color: #00BCD4;
            }
        }

        .detail {
            float: left;
            min-width: pxToRem(300);
            max-width: 40%;
            min-height: pxToRem(79);
            padding: pxToRem(10);
            border: 1px solid #d9d9d9;
        }
    }
</style>

<script>

    import {mapGetters} from 'vuex'
    import {indexDatas, modelValue} from './data.js'

    export default{
        name:'Model',
        data () {
        	return {
                indexDatas: indexDatas,
                modelValue: modelValue
            }
        },
        computed: {
            ...mapGetters([
                'navbarName',
                'subNavBarName'
            ])
        },
        methods: {
            changeValue (indexName, value) {
                for(let item of this.modelValue) {
                    if(item.indexName === indexName) {
                        item.value = value
                    }
                }
            },

            detail (index) {
                for(let item of this.indexDatas[index].index) {
                    if(item.value == this.modelValue[index].value) {
                        return item.desc
                    }
                }
                switch(this.modelValue[index].value) {
                    case 8: 
                        return '介于非常好与比较好之间'
                    case 6:
                        return '介于比较好和一般之间'
                    case 4:
                        return '介于一般和比较不好之间'
                    case 2:
                        return '介于比较不好和非常不好之间'
                }
            },

            more (index) {
                this.indexDatas[index].more = !this.indexDatas[index].more
            }
        }
    }
</script>
