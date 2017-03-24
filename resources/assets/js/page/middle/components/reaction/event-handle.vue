<template>
    <div class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                <tr>
                    <td class="form-label">
                        <label for="plan">预案选择</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-button size="small" icon="plus" @click="showPlanSelectDialog">预案选择</el-button>
                        <el-button size="small" icon="delete" @click="plan.id=0">清除</el-button>
                    </td>
                </tr>

                <tr v-if="plan.id">
                    <td colspan="3" class="selected-td">
                        <div class="selected-content" @click="planDialogVisible=true">
                            <i class="el-icon-document"></i>
                            <p>{{plan.name}}</p>
                            <div>点击查看详情</div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="information">专题选择</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-button size="small" icon="plus" @click="showInformationSelectDialog">专题选择</el-button>
                        <el-button size="small" icon="delete" @click="information.id=0">清除</el-button>
                    </td>
                </tr>

                <tr v-if="information.id">
                    <td colspan="3" class="selected-td">
                        <div class="selected-content" @click="informationDialogVisible=true">
                            <i class="el-icon-document"></i>
                            <p>{{information.name}}</p>
                            <div>点击查看详情</div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">专家选择</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{expert | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showExpertAddDialog"></el-button>
                            <el-button size="mini" icon="edit" @click="showExpertDeleteDialog"></el-button>
                        </div>
                    </td>
                </tr>
                
            </tbody>

            <tfoot class="form-footer">
                <tr>
                    <td colspan="3">
                        <el-button @click="cancel">取 消</el-button>
                        <el-button type="primary" @click="handleEvent">处 理</el-button>
                    </td>
                </tr>
            </tfoot>
        </table>

        <el-dialog title="预案选择" v-model="planDialogTableVisible" size="tiny">
            <!-- table data -->
            <el-table :data="plans" highlight-current-row @row-click="handlePlanSelectionChange">
                <el-table-column 
                    prop="plan_type_name" 
                    label="预案类型" 
                    width="150" 
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column 
                    prop="name" 
                    label="预案名称" 
                    show-overflow-tooltip>
                </el-table-column>
            </el-table>
            
            <!-- pagination -->
            <el-pagination
                small
                :current-page="paginator.current_page"
                :page-size="paginator.per_page"
                layout="prev, pager, next"
                :total="paginator.total"
                @current-change="pageChange"
                class="pagination">
            </el-pagination>

            <!-- dialog footer -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="planDialogTableVisible = false">返回</el-button>
            </div>
        </el-dialog>

        <el-dialog title="专题选择" v-model="informationDialogTableVisible" size="tiny">
            <!-- table data -->
            <el-table :data="informations" highlight-current-row @row-click="handleInformationSelectionChange">
                <el-table-column 
                    prop="information_type_name" 
                    label="专题类型" 
                    width="150" 
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column 
                    prop="name" 
                    label="专题名称" 
                    show-overflow-tooltip>
                </el-table-column>
            </el-table>
            
            <!-- pagination -->
            <el-pagination
                small
                :current-page="paginator.current_page"
                :page-size="paginator.per_page"
                layout="prev, pager, next"
                :total="paginator.total"
                @current-change="pageChange"
                class="pagination">
            </el-pagination>

            <!-- dialog footer -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="planDialogTableVisible = false">返回</el-button>
            </div>
        </el-dialog>
        
        <el-dialog title="专家选择" v-model="addDialogTableVisible" size="tiny">
            <!-- table data -->
            <el-table :data="addCrew" @selection-change="handleExpertSelectionChange">
                <el-table-column 
                    type="selection" 
                    width="55">
                </el-table-column>
                <el-table-column 
                    prop="name" 
                    label="姓名" 
                    width="100" 
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column 
                    prop="org_name" 
                    label="所属机构" 
                    width="100" 
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column 
                    prop="duty" 
                    label="职务" 
                    show-overflow-tooltip>
                </el-table-column>
            </el-table>
            
            <!-- pagination -->
            <el-pagination
                small
                :current-page="paginator.current_page"
                :page-size="paginator.per_page"
                layout="prev, pager, next"
                :total="paginator.total"
                @current-change="pageChange"
                class="pagination">
            </el-pagination>

            <!-- dialog footer -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="addDialogTableVisible = false">取 消</el-button>
                <el-button type="primary" @click="addCrewFn">确 定</el-button>
            </div>
        </el-dialog>

        <el-dialog title="已选专家" v-model="deleteDialogTableVisible" size="tiny">
            
            <!--  -->
            <div>
                <el-button-group v-for="(item, index) in deleteCrew" class="select-item">
                    <el-button :plain="true" :disabled="true" size="mini">{{item.name}}</el-button>
                    <el-button :plain="true" size="mini" @click="deleteCrewFn(item, index)">X</el-button>
                </el-button-group>
            </div>
            
            <!-- dialog footer -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="deleteDialogTableVisible = false">返 回</el-button>
            </div>
        </el-dialog>

        <plan :dialogVisible="planDialogVisible" :msg="plan" @cancel="planDialogVisible=false"></plan>
        <information :dialogVisible="informationDialogVisible" :msg="information" @cancel="informationDialogVisible=false"></information>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex'
    import Plan from './plan.vue'
    import Information from './information.vue'

    export default {
        name: 'EventHandle',
        data () {
            return {
                plans: [],
                informations: [],
                // 应急人员
                addCrew: [],
                deleteCrew: [],
                // 是否显示预案选择弹窗
                planDialogTableVisible: false,
                // 是否显示预案详情弹窗
                planDialogVisible: false,
                // 是否显示专题详情弹窗
                informationDialogVisible: false,
                // 是否显示专家选择弹窗
                addDialogTableVisible: false,
                // 是否显示专家删除弹窗
                deleteDialogTableVisible: false,
                paginator: {
                    current_page: 0,
                    total: 0,
                    per_page: 0
                },
                plan: {id: 0, name: '', content: ''},
                information: {id: 0, name: '', content: ''},
                // 专家
                expert: [],
                expertSelection: []
            }
        },
        computed: {
            ...mapGetters([
                'formMsg',
                'ws'
            ])
        },
        components: {
            Plan,
            Information
        },
        mounted () {
            console.log();
        },
        methods: {


            /**
             * 返回
             */
            cancel () {
                this.$router.back()
            },

            showPlanSelectDialog (page=1) {
                this.planDialogTableVisible = true
                axios.get(this.$adminUrl('plan/query'), {params: {page: page, page_size:5}})
                .then((responce) => {
                    this.$set(this, 'plans', responce.data.data)
                    this.paginator = responce.data
                })
            },

            showInformationSelectDialog (page=1) {
                this.informationDialogTableVisible = true
                axios.get(this.$adminUrl('information/query'), {params: {page: page, page_size:5}})
                .then((responce) => {
                    this.$set(this, 'informations', responce.data.data)
                    this.paginator = responce.data
                })
            },

            handlePlanSelectionChange (val) {
                this.plan = val
                this.planDialogTableVisible = false
            },

            handleInformationSelectionChange (val) {
                this.information = val
                this.informationDialogTableVisible = false
            },

            /**
             * 获取未被选中的专家
             */
            getCrew (page=1) {
                let ids = []
                for(let item of this.expert) {
                    ids.push(item.id)
                }
                axios.get(this.$adminUrl('expert/query'), {params: {page: page, page_size:5, except_ids: ids}})
                .then((responce) => {
                    this.$set(this, 'addCrew', responce.data.data)
                    this.paginator = responce.data
                })
            },

            /**
             * 显示选择专家的窗口
             */
            showExpertAddDialog () {
                this.$set(this, 'addCrew', [])
                this.addDialogTableVisible = true
                this.getCrew()
            },

            /**
             * 显示已选专家的窗口
             */
            showExpertDeleteDialog () {
                this.$set(this, 'deleteCrew', this.expert)
                this.deleteDialogTableVisible = true
            },

            /**
             * 点击分页
             */
            pageChange (val) {
                this.getCrew(val)
            },

            /**
             * 专家选择窗口多选触发事件
             */
            handleExpertSelectionChange (val) {
                this.multipleSelection = val
            },

            /**
             * 把选中的应急人员加入对应的数组里面
             */
            addCrewFn () {
                this.expert = this.expert.concat(this.multipleSelection)
                this.$set(this, 'multipleSelection', [])
                this.addDialogTableVisible = false
            },

            /**
             * 删除对应数组里面的专家
             */
            deleteCrewFn (item, index) {
                this.deleteCrew.splice(index, 1)
            },

            handleEvent () {
                if(!this.plan) {
                     this.$message.error('请选择预案');
                }
                let ids = []
                for(let item of this.expert) {
                    ids.push(item.id)
                }
                let params = {
                    event_id: this.formMsg.id,
                    event_status: this.formMsg.status,
                    plan_id: this.plan.id,
                    information_id: this.information.id,
                    expert_ids: ids
                }
                let _this = this
                axios.all([
                    axios.get(this.$adminUrl('emergencycrew/query-crew/') + this.plan.id),
                    axios.post(this.$adminUrl('eventhandle'), params)
                ])
                .then(axios.spread(function (emergencycrews, responce) {
                    if(responce.data) {
                        let type = _this.$route.params.model.split('-')[1]
                        if(type == 1) {
                            _this.$router.push('/index/reaction/early-warning/1')
                        }
                        if(type == 4) {
                            _this.$router.push('/index/reaction/emergency/1')
                        }

                        let broadcast = _this.$broadcast(_this.expert, emergencycrews.data)

                        if(_this.formMsg.status == 1) {
                            _this.formMsg.status = 2
                        }
                        if(_this.formMsg.status == 4) {
                            _this.formMsg.status = 5
                        }
                        _this.ws.send(JSON.stringify({
                            msg: _this.formMsg,
                            broadcast: broadcast,
                            type: 'event'
                        }))
                    }
                }))
            }

        }
    }
</script>

<style lang="sass" scoped>
    .pagination {
        margin-top: 22px;
        text-align: center;
    }
    .dialog-footer {
        text-align: center;
    }
    .select-name {
        display: inline-block;
        width: 100px;
        height: 24px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        word-break: keep-all;
    }
    .select-btns {
        float: right;
    }
    .select-item {
        margin-top: 7px;
        margin-right: 5px;
    }
    .selected-td {
        padding: 12px 0;
        .selected-content {
            position: relative;
            height: 67px;
            border: 1px solid #bfcbd9;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;

            i {
                float: left;
                margin-left: 27px;
                height: 69px;
                line-height: 69px;
                font-size: 34px;
                color: #d3d3d3;
            }

            p {
                width: 180px;
                margin: 7px auto;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                word-break: keep-all;
            }

            div {
                color: #9E9E9E;
                font-size: 14px;
            }
        }
    }
    
</style>
