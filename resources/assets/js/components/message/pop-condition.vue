<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                 <tr>
                    <td class="form-label">
                        <label for="code">预警条件编码</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.code" 
                        v-validate.initial="form.code" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="预警条件编码" 
                        type="text" id="code" class="el-input__inner" name="code" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('code')" class="error">
                    <td colspan="3">{{ verrors.first('code') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="type">事件类型</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.type" placeholder="请选择事件类型">
                            <el-option 
                                label="预警事件" 
                                :value="1">
                            </el-option>
                            <el-option 
                                label="突发事件" 
                                :value="2">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="code">预警条件描述</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.description" 
                        v-validate.initial="form.description" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="预警条件描述" 
                        type="text" id="description" class="el-input__inner" name="description" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('description')" class="error">
                    <td colspan="3">{{ verrors.first('description') }}</td>
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
                        code: '',
                        description: '',
                        type: 1
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
                    code: '',
                    description: '',
                    type: 1
                }
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
        },
        methods: {

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
                        axios.put(this.$adminUrl('waningcondition/') + this.form.id, this.form)
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
                        axios.post(this.$adminUrl('waningcondition'), this.form)
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
