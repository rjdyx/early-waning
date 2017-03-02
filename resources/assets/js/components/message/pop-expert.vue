<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <el-tabs v-model="active" @tab-click="handleClick" class="tabs">
            <el-tab-pane label="必填信息" name="0"></el-tab-pane>
            <el-tab-pane label="详细信息" name="1"></el-tab-pane>
        </el-tabs>

        <table class="form-table">
            <tbody class="form-body">

                <template v-if="requireMsg">
                    <tr>
                        <td class="form-label">
                            <label for="name">专家姓名</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.name" 
                            v-validate.initial="form.name" 
                            data-vv-rules="required|max:50" 
                            data-vv-as="专家姓名" 
                            type="text" id="name" class="el-input__inner" name="name" placeholder="必填">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('name')" class="error">
                        <td colspan="3">{{ verrors.first('name') }}</td>
                    </tr>

                    <tr>
                        <td class="form-label">
                            <label for="expert_area_id">专家领域</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-select v-model="form.expert_area_id" placeholder="请选择专家领域">
                                <el-option 
                                    v-for="expertArea in expertAreas" 
                                    :label="expertArea.name" 
                                    :value="expertArea.id">
                                </el-option>
                            </el-select>
                        </td>
                    </tr>

                    <tr>
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

                    <tr>
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

                    <tr>
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

                    <tr v-show="verrors.has('duty')" class="error">
                        <td colspan="3">{{ verrors.first('duty') }}</td>
                    </tr>

                    <tr>
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

                    <tr v-show="verrors.has('title')" class="error">
                        <td colspan="3">{{ verrors.first('title') }}</td>
                    </tr>
                </template>
                
                <template v-else>
                    <tr>
                        <td class="form-label">
                            <label for="degree">学历</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.degree" 
                            v-validate.initial="form.degree" 
                            data-vv-rules="max:20" 
                            data-vv-as="学历" 
                            type="text" id="degree" class="el-input__inner" name="degree">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('degree')" class="error">
                        <td colspan="3">{{ verrors.first('degree') }}</td>
                    </tr>


                    <tr>
                        <td class="form-label">
                            <label for="address">住址</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.address" 
                            v-validate.initial="form.address" 
                            data-vv-rules="max:50" 
                            data-vv-as="住址" 
                            type="text" id="address" class="el-input__inner" name="address">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('address')" class="error">
                        <td colspan="3">{{ verrors.first('address') }}</td>
                    </tr>

                    <tr>
                        <td class="form-label">
                            <label for="zipcode">邮编</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.zipcode" 
                            v-validate.initial="form.zipcode" 
                            data-vv-rules="max:20" 
                            data-vv-as="邮编" 
                            type="text" id="zipcode" class="el-input__inner" name="zipcode">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('zipcode')" class="error">
                        <td colspan="3">{{ verrors.first('zipcode') }}</td>
                    </tr>

                    <tr>
                        <td class="form-label">
                            <label for="company">单位</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.company" 
                            v-validate.initial="form.company" 
                            data-vv-rules="max:50" 
                            data-vv-as="单位" 
                            type="text" id="company" class="el-input__inner" name="company">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('company')" class="error">
                        <td colspan="3">{{ verrors.first('company') }}</td>
                    </tr>

                    <tr>
                        <td class="form-label">
                            <label for="officephone">办公电话</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.officephone" 
                            v-validate.initial="form.officephone" 
                            data-vv-rules="phones" 
                            data-vv-as="办公电话" 
                            type="text" id="officephone" class="el-input__inner" name="officephone">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('officephone')" class="error">
                        <td colspan="3">{{ verrors.first('officephone') }}</td>
                    </tr>

                    <tr>
                        <td class="form-label">
                            <label for="homephone">宅电</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="form.homephone" 
                            v-validate.initial="form.homephone" 
                            data-vv-rules="homephone" 
                            data-vv-as="宅电" 
                            type="text" id="homephone" class="el-input__inner" name="homephone">
                        </td>
                    </tr>

                    <tr v-show="verrors.has('homephone')" class="error">
                        <td colspan="3">{{ verrors.first('homephone') }}</td>
                    </tr>

                    <tr>
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

                    <tr v-show="verrors.has('cellphone')" class="error">
                        <td colspan="3">{{ verrors.first('cellphone') }}</td>
                    </tr>

                    <tr>
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

                    <tr v-show="verrors.has('email')" class="error">
                        <td colspan="3">{{ verrors.first('email') }}</td>
                    </tr>

                    <tr>
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

                    <tr v-show="verrors.has('meno')" class="error">
                        <td colspan="3">{{ verrors.first('meno') }}</td>
                    </tr>
                </template>
                
                
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
                        sex: 1,
                        degree: '',
                        duty: '',
                        title: '',
                        address: '',
                        zipcode: '',
                        company: '',
                        officephone: '',
                        homephone: '',
                        cellphone: '',
                        email: '',
                        meno: '',
                        org_id: 0,
                        expert_area_id: 0
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
                    sex: 1,
                    degree: '',
                    duty: '',
                    title: '',
                    address: '',
                    zipcode: '',
                    company: '',
                    officephone: '',
                    homephone: '',
                    cellphone: '',
                    email: '',
                    meno: '',
                    org_id: 0,
                    expert_area_id: 0
                },
                // 机构
                orgs: [],
                // 专家领域
                expertAreas: [],
                active: '0',
                requireMsg: true
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getOrgs()
            this.getExpertAreas()
        },
        methods: {

            getOrgs () {
                axios.get(this.$adminUrl('org/query'))
                    .then((responce) => {
                        this.$set(this, 'orgs', responce.data.data)
                        if(!(this.form.org_id))this.form.org_id = this.orgs[0].id
                    })
            },

            getExpertAreas () {
                axios.get(this.$adminUrl('normal-type?type=2'))
                    .then((responce) => {
                        this.$set(this, 'expertAreas', responce.data)
                        if(!(this.form.expert_area_id))this.form.expert_area_id = this.expertAreas[0].id
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
                        axios.put(this.$adminUrl('expert/') + this.form.id, this.form)
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
                        axios.post(this.$adminUrl('expert'), this.form)
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
</style>
