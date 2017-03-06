<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <el-tabs v-model="active" @tab-click="handleClick" class="tabs">
            <el-tab-pane label="必填信息" name="0" class="tabs-item"><template v-if="detailMsgError">详细信息有错误</template></el-tab-pane>
            <el-tab-pane label="详细信息" name="1" class="tabs-item"><template v-if="requireMsgError">必填信息有错误</template></el-tab-pane>
        </el-tabs>

        <table class="form-table">
            <tbody class="form-body">
                <tr v-show="requireMsg">
                    <td class="form-label">
                        <label for="name">应急人员姓名</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.name" 
                        v-validate.initial="form.name" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="应急人员姓名" 
                        type="text" id="name" class="el-input__inner" name="name" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="requireMsg && verrors.has('name')" class="error">
                    <td colspan="3">{{ verrors.first('name') }}</td>
                </tr>

                <tr v-show="requireMsg">
                    <td class="form-label">
                        <label for="org_id">所属机构</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.org_id" placeholder="请选择机构">
                            <el-option 
                                v-for="org in orgs" 
                                :label="org.name" 
                                :value="org.id">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr v-show="requireMsg">
                    <td class="form-label">
                        <label for="sex">性别</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-radio-group v-model="form.sex">
                            <el-radio-button :label="1">男</el-radio-button>
                            <el-radio-button :label="0">女</el-radio-button>
                        </el-radio-group>
                    </td>
                </tr>

                <tr v-show="requireMsg">
                    <td class="form-label">
                        <label for="duty">职责</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.duty" 
                        v-validate.initial="form.duty" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="职责" 
                        type="text" id="duty" class="el-input__inner" name="duty" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="requireMsg && verrors.has('duty')" class="error">
                    <td colspan="3">{{ verrors.first('duty') }}</td>
                </tr>

                <tr v-show="requireMsg">
                    <td class="form-label">
                        <label for="title">职务</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.title" 
                        v-validate.initial="form.title" 
                        data-vv-rules="required|max:20" 
                        data-vv-as="职务" 
                        type="text" id="title" class="el-input__inner" name="title" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="requireMsg && verrors.has('title')" class="error">
                    <td colspan="3">{{ verrors.first('title') }}</td>
                </tr>
                
            
                <tr v-show="!requireMsg">
                    <td class="form-label">
                        <label for="age">年龄</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.age" 
                        v-validate.initial="form.age" 
                        data-vv-rules="decimal:0" 
                        data-vv-as="年龄" 
                        type="text" id="age" class="el-input__inner" name="age">
                    </td>
                </tr>

                <tr v-show="!requireMsg && verrors.has('age')" class="error">
                    <td colspan="3">{{ verrors.first('age') }}</td>
                </tr>

                <tr v-show="!requireMsg">
                    <td class="form-label">
                        <label for="phone">固定电话</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.phone" 
                        v-validate.initial="form.phone" 
                        data-vv-rules="phone" 
                        data-vv-as="固定电话" 
                        type="text" id="phone" class="el-input__inner" name="phone">
                    </td>
                </tr>

                <tr v-show="!requireMsg && verrors.has('phone')" class="error">
                    <td colspan="3">{{ verrors.first('phone') }}</td>
                </tr>

                <tr v-show="!requireMsg">
                    <td class="form-label">
                        <label for="cellphone">手机</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.cellphone" 
                        v-validate.initial="form.cellphone" 
                        data-vv-rules="cellphone" 
                        data-vv-as="手机" 
                        type="text" id="cellphone" class="el-input__inner" name="cellphone">
                    </td>
                </tr>

                <tr v-show="!requireMsg && verrors.has('cellphone')" class="error">
                    <td colspan="3">{{ verrors.first('cellphone') }}</td>
                </tr>

                <tr v-show="!requireMsg">
                    <td class="form-label">
                        <label for="email">邮箱</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.email" 
                        v-validate.initial="form.email" 
                        data-vv-rules="email" 
                        data-vv-as="邮箱" 
                        type="text" id="email" class="el-input__inner" name="email">
                    </td>
                </tr>

                <tr v-show="!requireMsg && verrors.has('email')" class="error">
                    <td colspan="3">{{ verrors.first('email') }}</td>
                </tr>

                <tr v-show="!requireMsg">
                    <td class="form-label">
                        <label for="memo">备注</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.meno" 
                        v-validate.initial="form.meno" 
                        data-vv-rules="max:255" 
                        data-vv-as="备注" 
                        type="text" id="meno" class="el-input__inner" name="meno">
                    </td>
                </tr>

                <tr v-show="!requireMsg && verrors.has('meno')" class="error">
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
    </form>
</template>

<script>

    export default {
        name: 'PopExpert',
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        id: '',
                        name: '',
                        age: 0,
                        sex: 1,
                        duty: '',
                        title: '',
                        phone: '',
                        cellphone: '',
                        email: '',
                        meno: '',
                        org_id: 0
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
                    age: 0,
                    sex: 1,
                    duty: '',
                    title: '',
                    phone: '',
                    cellphone: '',
                    email: '',
                    meno: '',
                    org_id: 0
                },
                // 机构
                orgs: [],
                active: '0',
                // 是否显示必填信息
                requireMsg: true,
                // 必填信息有误
                requireMsgError: false,
                // 详细信息有误
                detailMsgError: false
            }
        },
        computed: {
            errors () {
                return this.verrors.errors
            }
        },
        watch: {
            errors () {
                if(!this.requireMsg && (this.verrors.has('name') || 
                    this.verrors.has('duty') ||
                    this.verrors.has('title'))) {
                    this.requireMsgError = true
                }else {
                    this.requireMsgError = false
                }
                if(this.requireMsg && (this.verrors.has('age') || 
                    this.verrors.has('phone') ||
                    this.verrors.has('cellphone') ||
                    this.verrors.has('email') ||
                    this.verrors.has('meno'))) {
                    this.detailMsgError = true
                }else {
                    this.detailMsgError = false
                }
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getOrgs()
        },
        methods: {

            getOrgs () {
                axios.get(this.$adminUrl('org/query'))
                    .then((responce) => {
                        this.$set(this, 'orgs', responce.data.data)
                        if(!(this.form.org_id))this.form.org_id = this.orgs[0].id
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

                    this.form = this.$filterObj(this.form, ['sex'])

                    if(this.edit) {
                        axios.put(this.$adminUrl('emergencycrew/') + this.form.id, this.form)
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
                        axios.post(this.$adminUrl('emergencycrew'), this.form)
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

            cancel () {
                this.$router.back()
            },

            handleClick (tab) {
                if(tab.$data.index == 1) {
                    this.requireMsg = false
                }else {
                    this.requireMsg = true
                }
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
    .tabs {
        width: 176px;
        margin: auto;
    }

    .tabs-item {
        text-align: center;
        color: red;
    }
</style>
