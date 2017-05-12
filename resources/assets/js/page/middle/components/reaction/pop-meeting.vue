<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                <tr>
                    <td class="form-label">
                        <label for="date">会议时间</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-date-picker
                            v-model="form.date"
                            type="datetime"
                            format="yyyy-MM-dd HH:mm:ss"
                            placeholder="选择日期时间"
                            align="right">
                        </el-date-picker>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="location">会议地址</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.location" 
                        v-validate.initial="form.location" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="会议地址" 
                        type="text" id="location" class="el-input__inner" name="location" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('location')" class="error">
                    <td colspan="3">{{ verrors.first('location') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="master">主持人</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.master" 
                        v-validate.initial="form.master" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="主持人" 
                        type="text" id="master" class="el-input__inner" name="master" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('master')" class="error">
                    <td colspan="3">{{ verrors.first('master') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="recorder">记录人员</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.recorder" 
                        v-validate.initial="form.recorder" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="记录人员" 
                        type="text" id="recorder" class="el-input__inner" name="recorder">
                    </td>
                </tr>

                <tr v-show="verrors.has('recorder')" class="error">
                    <td colspan="3">{{ verrors.first('recorder') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="title">会议主题</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.title" 
                        v-validate.initial="form.title" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="会议主题" 
                        type="text" id="title" class="el-input__inner" name="title" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('title')" class="error">
                    <td colspan="3">{{ verrors.first('title') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">会议内容</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-input type="textarea" v-model="form.content" id="content"></el-input>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">应急人员</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{emergencycrews | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showCrewAddDialog('选择应急人员', 1)"></el-button>
                            <el-button size="mini" icon="edit" @click="showCrewDeleteDialog('已选应急人员', 1)"></el-button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="content">专家</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <div class="select-name">{{experts | objectToString}}</div>
                        <div class="select-btns">
                            <el-button size="mini" icon="plus" @click="showCrewAddDialog('选择专家', 2)"></el-button>
                            <el-button size="mini" icon="edit" @click="showCrewDeleteDialog('已选专家', 2)"></el-button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="meno">备注</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.meno" 
                        v-validate.initial="form.meno" 
                        data-vv-rules="required|max:255" 
                        data-vv-as="备注" 
                        type="text" id="meno" class="el-input__inner" name="meno">
                    </td>
                </tr>

                <tr v-show="verrors.has('meno')" class="error">
                    <td colspan="3">{{ verrors.first('meno') }}</td>
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
        name: 'PopMeeting',
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        id: '',
                        date: '',
                        location: '',
                        master: '',
                        recorder: '',
                        title: '',
                        content: '',
                        meno: '',
                        status: 1
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
                    date: '',
                    location: '',
                    master: '',
                    recorder: '',
                    title: '',
                    content: '',
                    meno: '',
                    status: 1
                },
                // 人员
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
                // 应急人员
                emergencycrews: [],
                // 专家
                experts: [],
                multipleSelection: []
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            if(this.edit) this.getAllCrew()
        },
        methods: {

            /**
             * 获取所有类型的应急人员
             * @return {[type]} [description]
             */
            getAllCrew () {
                axios.get(this.$adminUrl('meeting/query-crew/' + this.form.id))
                .then((responce) => {
                    this.$set(this, 'emergencycrews', responce.data.emergencycrews)
                    this.$set(this, 'experts', responce.data.experts)
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
                    if(this.emergencycrews.length) {
                        this.form.emergencycrews = this.getObjectArrIds(this.emergencycrews)
                    }
                    if(this.experts.length) {
                        this.form.experts = this.getObjectArrIds(this.experts)
                    }

                    if(this.edit) {
                        axios.put(this.$adminUrl('meeting/') + this.form.id, this.form)
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
                        axios.post(this.$adminUrl('meeting'), this.form)
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
             * 获取未被选中的人员
             */
            getCrew (page=1) {
                let ids = []
                let crew = []
                let url = ''
                switch(this.dialogType) {
                    case 1:
                        crew = this.emergencycrews
                        url = this.$adminUrl('emergencycrew/query')
                        break
                    case 2:
                        crew = this.experts
                        url = this.$adminUrl('expert/query')
                        break
                }
                for(let item of crew) {
                    ids.push(item.id)
                }
                axios.get(url, {params: {page: page, page_size:5, except_ids: ids}})
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
                        this.deleteCrew = this.emergencycrews
                        break
                    case 2:
                        this.deleteCrew = this.experts
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
             * 人员选择窗口多选触发事件
             */
            handleSelectionChange (val) {
                this.multipleSelection = val
            },

            /**
             * 把选中的人员加入对应的数组里面
             */
            addCrewFn () {
                switch(this.dialogType) {
                    case 1:
                        this.emergencycrews = this.emergencycrews.concat(this.multipleSelection)
                        break
                    case 2:
                        this.experts = this.experts.concat(this.multipleSelection)
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
