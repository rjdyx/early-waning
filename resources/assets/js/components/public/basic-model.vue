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
                <router-link :to="'/index/new-form/' + url + '/new'" exact>
                    <el-button type="primary" icon="plus">新增</el-button>
                </router-link>
                
                <el-button type="primary" icon="delete" @click="handleDelete">删除</el-button>
                <component 
                	v-for="typeOperate in typeComponent" 
                	:is="typeOperate.component" 
                	:params="typeOperate.params" 
                	class="operateBtns"
            	></component>
            </div>
            <div id="inputs">
                <el-input
                  :placeholder="searchPlaceholder"
                  icon="search"
                  v-model="inputValue"
                  :on-icon-click="search">
                </el-input>
            </div>
        </div>

        <!-- 列表模块 -->
        <vue-perfect-scrollbar id="list">
            <el-table
                :data="tableData" 
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
                <el-table-column
                    label="操作"
                    :width="150">
                  <template scope="scope">
                    <el-button
                        size="small"
                        @click="handleEdit(scope)">编辑</el-button>
                </el-table-column>
              </el-table>
        </vue-perfect-scrollbar>

        <!-- 分页模块 -->
        <el-pagination
            :current-page="paginator.current_page"
            :page-size="paginator.per_page"
            layout="prev, pager, next, jumper"
            :total="paginator.total"
            @current-change="pageChange"
            class="pagination">
        </el-pagination>


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

    .pagination {
        position: absolute;
        bottom: 35px;
        left: 0;
        right: 0;
        text-align: center;
    }

</style>

<script>

    import {mapMutations} from 'vuex'

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
            				key: 'orgManage',
            				tab: '用户管理',
            				url: 'org',
                            searchPlaceholder: '',
            				newComponent: null,
            				typeComponent: [{component: null, params: {}}],
            				theads: ['机构名称'],
            				protos: ['name'],
            				widths: [50],
            				colComponent: []
            			}
            		]
            	}
            }
        },
        data () {
        	return {
                // 搜索框内容
        		inputValue: '',
                // tab模块选择标志
                activeName: 'index' + this.$route.params.index,
                // tab对应的模块下标
                modelIndex: this.$route.params.index,
                // 列表数据
                tableData: [], 
                // 被选中的列表项数组
                multipleSelection: [],
                // 分页对象
                paginator: {
                    // 当前页
                    current_page: 0,
                    // 总页数
                    total: 0,
                    // 每页数目
                    per_page: 0
                }
                
        	}
        },
        computed: {

            modelUrlParams () {
                return this.$route.params.model
            },

            url () {
                return this.models[this.modelIndex].url
            },

            searchPlaceholder () {
                return this.models[this.modelIndex].searchPlaceholder
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
            },

            newComponent () {
            	return this.models[this.modelIndex].newComponent
            }
        },
        watch: {
            url () {
                this.tableData = []
                this.getAllMsg()
            }
        },
        mounted () {
            this.getAllMsg()
        },
        methods: {

            ...mapMutations([
                'setFormMsg'
            ]),

            /**
             * 初始化
             */
            init (index=0) {
                this.inputValue = ''
                this.activeName = 'index' + index
                this.modelIndex = index
                this.$set(this, 'tableData', [])
                this.$set(this, 'multipleSelection', [])
            },

            /**
             * 获取所有数据
             */
            getAllMsg (params='') {
                let host = '/query'
                if(params.length) host += '?' + params
                axios.get(this.$adminUrl(this.url) + host)
                    .then((responce) => {
                        this.$set(this, 'tableData', responce.data.data)
                        this.paginator = responce.data
                    })
            },

            /**
             * 搜索
             */
            search () {
                this.getAllMsg('query_text=' + this.inputValue)
            },

            /**
             * 列表选择事件
             */
            handleSelectionChange (val) {
                this.multipleSelection = val
            },

            /**
             * tab点击事件
             */
            tabClick(tab, event) {
            	this.modelIndex = tab.$data.index
                let model = this.$route.params.model
                this.$router.push('/index/message/' + model + '/' + this.modelIndex)
            },

            /**
             * 编辑
             */
            handleEdit ({ $index, row }) {
                this.setFormMsg(row)
                this.$router.push('/index/new-form/' + this.url + '/edit')
            },

            /**
             * 删除
             */
            handleDelete () {
                let ids = []
                this.multipleSelection.forEach((item) => {
                    ids.push(item.id)
                })
                if(!ids.length) {
                    return this.$message('请选择')
                }
                this.$confirm('确定删除?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.delete(this.$adminUrl(this.url), {data: {ids: ids}})
                    .then((responce) => {
                        if(typeof responce.data !== 'number') {
                            this.$message('被使用，无法删除')
                            return false
                        }
                        this.$message({
                          message: '成功删除' + responce.data + '条',
                          type: 'success'
                        })
                        // multipleSelection数组正序排序，tableData数组逆序排序
                        // 连续使用splice方法删除tableData数组里的某一项需从尾部开始，
                        // 否则会删错，故multipleSelection从头遍历，tableData从尾部遍历
                        // 此方法虽然使用两个循环，但时间复杂度是O(multipleSelection.length + tableData.length) + k
                        // 而不是O(multipleSelection.length * tableData.length) + k
                        if(this.tableData.length == this.multipleSelection.length) {
                            this.$set(this, 'tableData', [])
                        } else {
                            this.multipleSelection = this.$sortObj(this.multipleSelection, 'id')
                            let tableDataIndex = this.tableData.length - 1
                            for(let selectItem of this.multipleSelection) {
                                for(; tableDataIndex >= 0; tableDataIndex--) {
                                    if(selectItem.id == this.tableData[tableDataIndex].id) {
                                        this.tableData.splice(tableDataIndex, 1)
                                        tableDataIndex--
                                        break
                                    }
                                }
                            }
                        }
                        this.$set(this, 'multipleSelection', [])
                    })
                })
                
            },

            /**
             * 点击分页
             */
            pageChange (val) {
                this.getAllMsg('page='+ val +'&query_text=' + this.inputValue)
            }
        }
    }

</script>
