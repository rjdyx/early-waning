<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
        
            <tbody class="form-body">

                <template v-for="proto of Object.keys(rows)">
                    <tr v-if="rows[proto].component">
                        <td class="form-label">
                            <label :for="proto">{{rows[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <component :is="rows[proto].component" @return-value="returnValue"></component>
                        </td>
                    </tr>

                    <tr v-else-if="!rows[proto].rules && !rows[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-input v-model="tableForm[proto]" :id="proto"></el-input>
                        </td>
                    </tr>

                    <tr v-else-if="rows[proto].rules">
                        <td class="form-label">
                            <label :for="proto">{{rows[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="tableForm[proto]" 
                            v-validate.initial="tableForm[proto]" 
                            :data-vv-rules="rows[proto].rules | rulesToString" 
                            :data-vv-as="rows[proto].label" 
                            type="text" :id="proto" class="el-input__inner" :name="proto" :placeholder="rows[proto].placeholder">
                        </td>
                    </tr>

                    <tr v-show="rows[proto].rules && verrors.has(proto)" class="error">
                        <td colspan="3">{{ verrors.first(proto) }}</td>
                    </tr> 
                    
                    <tr v-if="rows[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-select v-model="tableForm[proto]" :placeholder="rows[proto].placeholder">
                                <el-option 
                                    v-for="option in rows[proto].options" 
                                    :label="option[rows[proto].optionLabel]" 
                                    :value="option[rows[proto].optionValue]">
                                </el-option>
                            </el-select>
                        </td>
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
        name:'Add',
        props:{
            rows: {
                type: Object,
                default () {
                    return {
                        name: {
                            label: '预案名称',
                            rules: ['required', 'max:50'],
                            value: '',
                            placeholder: '必填'
                        },
                        type: {
                            label: '预案名称',
                            options: [{}],
                            optionLabel: '',
                            optionValue: '',
                            value: '',
                            placeholder: '必填'
                        }
                    }
                }
            },
            editForm: {
                type: Object,
                default() {
                    return {}
                }
            },
            edit: {
                type: Boolean,
                default: false
            }
        },
        data () {

            let form = {}
            for(let proto of Object.keys(this.rows)) {
                form[proto] = this.rows[proto].value
            }

            return {
                form: form
            }
        },
        computed: {
            tableForm (){
                return this.edit?this.editForm:this.form
            }
        },
        methods: {

            returnValue ({name, value}) {
                this.form[name] = value
            },

            submit () {
                this.$emit('submit')
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

                    this.tableForm = this.$filterObj(this.tableForm, this.filterArray)
                    this.$popForm.beforeFn()

                    if(this.edit) {
                        axios.put(this.$adminUrl(this.formUrl) + '/' + this.tableForm.id, this.tableForm)
                        .then((responce) => {
                            if(responce.data) {
                                this.$popForm.afterEditFn()                                
                                this.$message({
                                  message: '修改成功',
                                  type: 'success'
                                })
                                this.$router.back()
                            }
                        })
                    }else {
                        axios.post(this.$adminUrl(this.formUrl), this.tableForm)
                        .then((responce) => {
                            if(responce.data) {
                                this.$popForm.afterAddFn()
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

        }

    }
</script>
