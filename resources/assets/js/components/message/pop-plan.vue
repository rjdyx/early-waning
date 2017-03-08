<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                <tr>
                    <td class="form-label">
                        <label for="name">预案名称</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.name" 
                        v-validate.initial="form.name" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="预案名称" 
                        type="text" id="name" class="el-input__inner" name="name" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('name')" class="error">
                    <td colspan="3">{{ verrors.first('name') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="plan_type_id">预案类型</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.plan_type_id" placeholder="请选择预案类型">
                            <el-option 
                                v-for="planLevel in planLevels" 
                                :label="planLevel.name" 
                                :value="planLevel.id">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">内容</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-input type="textarea" v-model="form.content" id="content"></el-input>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">组长</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{leader | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showCrewAddDialog('选择组长', 1)"></el-button>
                            <el-button size="mini" icon="edit" @click="showCrewDeleteDialog('已选组长', 1)"></el-button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">副组长</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{subLeader | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showCrewAddDialog('选择副组长', 2)"></el-button>
                            <el-button size="mini" icon="edit" @click="showCrewDeleteDialog('已选副组长', 2)"></el-button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">成员</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{member | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showCrewAddDialog('选择成员', 3)"></el-button>
                            <el-button size="mini" icon="edit" @click="showCrewDeleteDialog('已选成员', 3)"></el-button>
                        </div>
                    </td>
                </tr>
                
            </tbody>

            <tfoot class="form-footer">
                <tr>
                    <td colspan="3">
                        <el-button @click="cancel">取 消</el-button>
                        <el-button type="primary" native-type="submit">确 定</el-button>
                    </td>
                </tr>
            </tfoot>
        </table>

        
        <el-dialog :title="addDialogTitle" v-model="addDialogTableVisible" size="tiny">
            <!-- table data -->
            <el-table :data="addCrew" @selection-change="handleSelectionChange">
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

        <el-dialog :title="deleteDialogTitle" v-model="deleteDialogTableVisible" size="tiny">
            
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

    </form>
</template>

<script>

    export default {
        name: 'PopOrg',
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        id: '',
                        name: '',
                        content: '',
                        plan_type_id: 0
                    }
                }
            },
            // 表示此模块是编辑模块还是新增模块的标志
            edit: {
                type: Boolean,
                default: false
            },
        },
        data () {
            return {
                // 作为编辑组件时，用于临时备份父组件传递过来的数据，
                // 以便在修改了数据但不保存时可以复原数据
                tmp: {
                    id: '',
                    name: '',
                    content: '',
                    plan_type_id: 0
                },
                // 机构等级
                planLevels: [],
                // 应急人员
                addCrew: [],
                deleteCrew: [],
                // 是否显示人员选择弹窗
                addDialogTableVisible: false,
                // 选择弹窗标题
                addDialogTitle: '',
                // 是否显示人员删除弹窗
                deleteDialogTableVisible: false,
                // 删除弹窗标题
                deleteDialogTitle: '',
                // 弹窗类型
                dialogType: 1,
                paginator: {
                    current_page: 0,
                    total: 0,
                    per_page: 0
                },
                // 组长
                leader: [],
                // 副组长
                subLeader: [],
                // 成员
                member: [],
                multipleSelection: []
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getplanLevel()
            if(this.edit) this.getAllCrew()
        },
        methods: {

            /**
             * 获取预案类型
             */
            getplanLevel () {
                axios.get(this.$adminUrl('normal-type?type=3'))
                    .then((responce) => {
                        this.$set(this, 'planLevels', responce.data)
                        if(!(this.form.plan_type_id))this.form.plan_type_id = this.planLevels[0].id
                    })
            },

            /**
             * 获取所有类型的应急人员
             * @return {[type]} [description]
             */
            getAllCrew () {
                axios.get(this.$adminUrl('emergencycrew/query-crew/' + this.form.id))
                .then((responce) => {
                    this.$set(this, 'leader', responce.data.leader)
                    this.$set(this, 'subLeader', responce.data.subLeader)
                    this.$set(this, 'member', responce.data.member)
                })
            },

            /**
            * 提交表单
            */
            validateBeforeSubmit () {

                // 验证表单
                this.$validator.validateAll()
                // 如果表单报错则不提交
                if(this.verrors.any()) {
                    return false
                }else {

                    this.form = this.$filterObj(this.form)
                    if(this.leader.length) {
                        this.form.leader = this.getObjectArrIds(this.leader)
                    }
                    if(this.subLeader.length) {
                        this.form.subLeader = this.getObjectArrIds(this.subLeader)
                    }
                    if(this.member.length) {
                        this.form.member = this.getObjectArrIds(this.member)
                    }

                    if(this.edit) {
                        axios.put(this.$adminUrl('plan/') + this.form.id, this.form)
                        .then((responce) => {
                            if(responce.data) {
                                this.$message({
                                  message: '修改成功',
                                  type: 'success'
                                })
                                this.$router.back()
                            }
                        })
                    }else {
                        axios.post(this.$adminUrl('plan'), this.form)
                        .then((responce) => {
                            if(responce.data) {
                                this.$message({
                                  message: '新增成功',
                                  type: 'success'
                                })
                                this.$emit('addSuccess')
                            }
                        })
                    }
                    
                }
            },

            /**
             * 返回
             */
            cancel () {
                this.$router.back()
            },

            /**
             * 获取未被选中的应急人员
             */
            getCrew (page=1) {
                let ids = []
                let crew = []
                switch(this.dialogType) {
                    case 1:
                        crew = this.leader
                        break
                    case 2:
                        crew = this.subLeader
                        break
                    case 3:
                        crew = this.member
                        break
                }
                for(let item of crew) {
                    ids.push(item.id)
                }
                axios.get(this.$adminUrl('emergencycrew/query'), {params: {page: page, page_size:5, except_ids: ids}})
                .then((responce) => {
                    this.$set(this, 'addCrew', responce.data.data)
                    this.paginator = responce.data
                })
            },

            /**
             * 显示选择应急人员的窗口
             * @param  {String} title 窗口标题
             * @param  {Integer} type 对应职位
             */
            showCrewAddDialog (title, type) {
                this.$set(this, 'addCrew', [])
                this.addDialogTitle = title
                this.dialogType = type
                this.addDialogTableVisible = true
                this.getCrew()
            },

            /**
             * 显示已选应急人员的窗口
             * @param  {String} title 窗口标题
             * @param  {Integer} type 对应职位
             */
            showCrewDeleteDialog (title, type) {
                this.$set(this, 'deleteCrew', [])
                this.deleteDialogTitle = title
                this.dialogType = type
                this.deleteDialogTableVisible = true
                switch(this.dialogType) {
                    case 1:
                        this.deleteCrew = this.leader
                        break
                    case 2:
                        this.deleteCrew = this.subLeader
                        break
                    case 3:
                        this.deleteCrew = this.member
                        break
                }
            },

            /**
             * 点击分页
             */
            pageChange (val) {
                this.getCrew(val)
            },

            /**
             * 应急人员选择窗口多选触发事件
             */
            handleSelectionChange (val) {
                this.multipleSelection = val
            },

            /**
             * 把选中的应急人员加入对应的数组里面
             */
            addCrewFn () {
                switch(this.dialogType) {
                    case 1:
                        this.leader = this.leader.concat(this.multipleSelection)
                        break
                    case 2:
                        this.subLeader = this.subLeader.concat(this.multipleSelection)
                        break
                    case 3:
                        this.member = this.member.concat(this.multipleSelection)
                        break
                }
                this.$set(this, 'multipleSelection', [])
                this.addDialogTableVisible = false
            },

            /**
             * 删除对应数组里面的应急人员
             */
            deleteCrewFn (item, index) {
                this.deleteCrew.splice(index, 1)
            },

            getObjectArrIds (arr) {
                let ids = []
                for(let item of arr) {
                    ids.push(item.id)
                }
                return ids
            }

        },
        destroyed () {
            if(this.edit){
                for(let key of Object.keys(this.form)){
                    this.form[key] = this.tmp[key];
                }
            }
        },
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
        width: 130px;
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
</style>
