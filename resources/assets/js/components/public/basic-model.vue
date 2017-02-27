/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div class="middle">
    
        <!-- 导航条模块 -->
        <el-breadcrumb separator="/" id="nav">
            <el-breadcrumb-item>{{navbarName}}</el-breadcrumb-item>
            <el-breadcrumb-item>{{subNavBarName}}</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- tabs模块 -->
        <el-tabs v-model="activeName" id="tabs" @tab-click="tabClick">
            <el-tab-pane v-for="(model, index) in models" :label="model.tab" :name="'index' + index"></el-tab-pane>
        </el-tabs>

        <!-- 操作模块 -->
        <div id="operate">
            <div id="btns">
                <el-button type="primary" icon="plus">新增</el-button>
                <el-button type="primary" icon="delete">删除</el-button>
                <component 
                	v-for="typeOperate in typeComponent" 
                	:is="typeOperate.component" 
                	:params="typeOperate.params" 
                	class="operateBtns"
            	></component>
            </div>
            <div id="inputs">
                <el-input
                  placeholder="请选择日期"
                  icon="search"
                  v-model="inputValue"
                  :on-icon-click="search">
                </el-input>
            </div>
        </div>

        <!-- 列表模块 -->
        <div id="list">
            <el-table
                :data="tableData3"
                @selection-change="handleSelectionChange">
                <el-table-column
                  type="selection"
                  width="55">
                </el-table-column>
                <template v-for="(item, index) in theads">
                	<template v-if="colComponent[protos[index]] == null">
                		<el-table-column
		                	:prop="protos[index]"
		                    :label="item"
		                    :min-width="widths[index]">
		                </el-table-column>
                	</template>
                	<template v-else>
                		<el-table-column
		                    :label="item"
		                    :min-width="widths[index]">
		                  <template scope="scope">
		                  	<component :is="colComponent[protos[index]]" :scope="scope"></component>
		                  </template>
		                </el-table-column>
                	</template>
                </template>
              </el-table>
        </div>

        <!-- 分页模块 -->
        <el-pagination
            :current-page="3"
            :page-size="15"
            layout="prev, pager, next, jumper"
            :total="100"
            class="pagination">
        </el-pagination>

        <!-- 新增弹窗 -->

        <!-- 删除弹窗 -->

    </div>
</template>

<style lang="sass" scoped>
    @import "../../../sass/function";

    .middle {
        position: absolute;
        top: pxToRem(48);
        right: 0;
        bottom: 0;
        left: pxToRem(180);
    }

    #nav {
        height: pxToRem(62);
        line-height: pxToRem(62);
        padding-left: pxToRem(25);
        font-size: pxToRem(20);
    }

    #tabs {
        height: pxToRem(62);
        line-height: pxToRem(62);
        padding: 0 pxToRem(25);
    }

    #operate {
        height: pxToRem(62);
        line-height: pxToRem(62);
        padding: 0 pxToRem(25);
        margin-top: pxToRem(10);

        #btns {
            float: left;

            .operateBtns {
            	display: inline-block;
            	margin: 0 pxToRem(10);
            }
        }

        #inputs {
            float: right;
        }
    }

    #list {
        overflow: hidden;
        padding: 0 pxToRem(25);
    }

    .pagination {
        position: absolute;
        bottom: 35px;
        left: 0;
        right: 0;
        text-align: center;
    }

</style>

<script>

    export default{
        name:'BasicModel',
        props: {
            navbarName: {
                type: String,
                default: '预警信息管理'
            },
            subNavBarName: {
                type: String,
                default: '机构管理'
            },
            models: {
            	type: Array,
            	default () {
            		return [
            			{
            				key: 'userManage',
            				tab: '用户管理',
            				url: '',
            				newComponent: null,
            				typeComponent: [{component: null, params: {}}],
            				theads: ['日期', '姓名', '地址'],
            				protos: ['date', 'name', 'address'],
            				widths: [120, 120, 120],
            				colComponent: []
            			}
            		]
            	}
            }
        },
        data () {
        	return {
        		inputValue: '',
                activeName: 'index0',
                modelIndex: 0,
                tableData3: [{
                      date: '2016-05-03',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-02',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-04',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-01',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-08',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-06',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                    }, {
                      date: '2016-05-07',
                      name: '王小虎',
                      address: '上海市普陀区金沙江路 1518 弄'
                }], 
                multipleSelection: []
        	}
        },
        computed: {
            model () {
                return this.$route.params.model
            },

            theads () {
            	return this.models[this.modelIndex].theads
            },

            protos () {
            	return this.models[this.modelIndex].protos
            },

            widths () {
            	return this.models[this.modelIndex].widths
            },

            colComponent () {
            	return this.models[this.modelIndex].colComponent
            },

            typeComponent () {
            	return this.models[this.modelIndex].typeComponent
            }
        },
        methods: {
            search () {

            },

            /**
             * 列表选择事件
             */
            handleSelectionChange () {

            },

            /**
             * tab点击事件
             */
            tabClick(tab, event) {
            	console.log(tab.$data.index);
            	this.modelIndex = tab.$data.index
            }
        }
    }

</script>
