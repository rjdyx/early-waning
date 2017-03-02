<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                 <tr>
                    <td class="form-label">
                        <label for="name">机构名称</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.name" 
                        v-validate.initial="form.name" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="机构名称" 
                        type="text" id="name" class="el-input__inner" name="name" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('name')" class="error">
                    <td colspan="3">{{ verrors.first('name') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="org_level_id">机构类型</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.org_level_id" placeholder="请选择机构类型">
                            <el-option 
                                v-for="orgLevel in orgLevels" 
                                :label="orgLevel.name" 
                                :value="orgLevel.id">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="address">机构地址</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.address" 
                        v-validate.initial="form.address" 
                        data-vv-rules="max:50" 
                        data-vv-as="机构地址" 
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

                <tr v-show="verrors.has('phone')" class="error">
                    <td colspan="3">{{ verrors.first('phone') }}</td>
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
                        <label for="fax">传真</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.fax" 
                        v-validate.initial="form.fax" 
                        data-vv-rules="phone" 
                        data-vv-as="传真" 
                        type="text" id="fax" class="el-input__inner" name="fax">
                    </td>
                </tr>

                <tr v-show="verrors.has('fax')" class="error">
                    <td colspan="3">{{ verrors.first('fax') }}</td>
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
        name: 'PopOrg',
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        id: '',
                        name: '',
                        address: '',
                        zipcode: '',
                        phone: '',
                        cellphone: '',
                        fax: '',
                        meno: '',
                        pid: 0,
                        org_level_id: 0
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
                    address: '',
                    zipcode: '',
                    phone: '',
                    cellphone: '',
                    fax: '',
                    meno: '',
                    pid: 0,
                    org_level_id: 0
                },
                // 机构等级
                orgLevels: []
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getOrgLevel()
        },
        methods: {

            getOrgLevel () {
                axios.get(this.$adminUrl('normal-type?type=1'))
                    .then((responce) => {
                        this.$set(this, 'orgLevels', responce.data)
                        if(!(this.form.org_level_id))this.form.org_level_id = this.orgLevels[0].id
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

                    if(this.edit) {
                        axios.put(this.$adminUrl('org/') + this.form.id, this.form)
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
                        axios.post(this.$adminUrl('org'), this.form)
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
