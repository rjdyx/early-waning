<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <el-tabs v-model="active" @tab-click="handleClick" class="tabs">
            <el-tab-pane label="必填信息" name="0" class="tabs-item"><template v-if="detailMsgError">详细信息有错误</template></el-tab-pane>
            <el-tab-pane label="详细信息" name="1" class="tabs-item"><template v-if="requireMsgError">必填信息有错误</template></el-tab-pane>
        </el-tabs>

        <table class="form-table">
        
            <tbody v-show="requireMsg" class="form-body">

                <template v-for="proto of Object.keys(rows.requireMsg)">
                    <tr v-if="rows.requireMsg[proto].component">
                        <td class="form-label">
                            <label :for="proto">{{rows.requireMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <component :is="rows.requireMsg[proto].component" @return-value="returnValue"></component>
                        </td>
                    </tr>

                    <tr v-else-if="!rows.requireMsg[proto].rules && !rows.requireMsg[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows.requireMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-input v-model="tableForm[proto]" :id="proto"></el-input>
                        </td>
                    </tr>

                    <tr v-else-if="rows.requireMsg[proto].rules">
                        <td class="form-label">
                            <label :for="proto">{{rows.requireMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="tableForm[proto]" 
                            v-validate.initial="tableForm[proto]" 
                            :data-vv-rules="rows.requireMsg[proto].rules | rulesToString" 
                            :data-vv-as="rows.requireMsg[proto].label" 
                            type="text" :id="proto" class="el-input__inner" :name="proto" :placeholder="rows.requireMsg[proto].placeholder">
                        </td>
                    </tr>

                    <tr v-show="rows.requireMsg[proto].rules && verrors.has(proto)" class="error">
                        <td colspan="3">{{ verrors.first(proto) }}</td>
                    </tr> 
                    
                    <tr v-if="rows.requireMsg[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows.requireMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-select v-model="tableForm[proto]" :placeholder="rows.requireMsg[proto].placeholder">
                                <el-option 
                                    v-for="option in rows.requireMsg[proto].options" 
                                    :label="option[rows.requireMsg[proto].optionLabel]" 
                                    :value="option[rows.requireMsg[proto].optionValue]">
                                </el-option>
                            </el-select>
                        </td>
                    </tr>
                </template>

            </tbody>

            <tbody v-show="!requireMsg" class="form-body">

                <template v-for="proto of Object.keys(rows.detailMsg)">
                    <tr v-if="rows.detailMsg[proto].component">
                        <td class="form-label">
                            <label :for="proto">{{rows.detailMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <component :is="rows.detailMsg[proto].component" @return-value="returnValue"></component>
                        </td>
                    </tr>

                    <tr v-else-if="!rows.detailMsg[proto].rules && !rows.detailMsg[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows.detailMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-input v-model="tableForm[proto]" :id="proto"></el-input>
                        </td>
                    </tr>

                    <tr v-else-if="rows.detailMsg[proto].rules">
                        <td class="form-label">
                            <label :for="proto">{{rows.detailMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <input 
                            v-model="tableForm[proto]" 
                            v-validate.initial="tableForm[proto]" 
                            :data-vv-rules="rows.detailMsg[proto].rules | rulesToString" 
                            :data-vv-as="rows.detailMsg[proto].label" 
                            type="text" :id="proto" class="el-input__inner" :name="proto" :placeholder="rows.detailMsg[proto].placeholder">
                        </td>
                    </tr>

                    <tr v-show="rows.detailMsg[proto].rules && verrors.has(proto)" class="error">
                        <td colspan="3">{{ verrors.first(proto) }}</td>
                    </tr> 
                    
                    <tr v-if="rows.detailMsg[proto].options">
                        <td class="form-label">
                            <label :for="proto">{{rows.detailMsg[proto].label}}</label>
                        </td>
                        <td class="form-input" colspan="2">
                            <el-select v-model="tableForm[proto]" :placeholder="rows.detailMsg[proto].placeholder">
                                <el-option 
                                    v-for="option in rows.detailMsg[proto].options" 
                                    :label="option[rows.detailMsg[proto].optionLabel]" 
                                    :value="option[rows.detailMsg[proto].optionValue]">
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
                        requireMsg: {
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
                        },

                        detailMsg: {
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
            let requireProto = []
            let detailProto = []
            for(let proto of Object.keys(this.rows.requireMsg)) {
                form[proto] = this.rows.requireMsg[proto].value
                requireProto.push(proto)
            }

            for(let proto of Object.keys(this.rows.detailMsg)) {
                form[proto] = this.rows.detailMsg[proto].value
                if(this.rows.detailMsg[proto].rules && this.rows.detailMsg[proto].rules.length) {
                    detailProto.push(proto)
                }
            }

            return {
                form: form,
                requireProto: requireProto,
                detailProto: detailProto,
                active: '0',
                requireMsg: true
            }
        },
        computed: {
            tableForm (){
                return this.edit?this.editForm:this.form
            },
            errors () {
                return this.verrors.errors
            }
        },
        watch: {
            errors () {
                this.showTabErrorMsg(this.requireMsg, this.requireProto, 'requireMsgError')
                this.showTabErrorMsg(!this.requireMsg, this.detailProto, 'detailMsgError')
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
            },

            handleClick (tab) {
                if(tab.$data.index == 1) {
                    this.requireMsg = false
                }else {
                    this.requireMsg = true
                }
            },

            showTabErrorMsg (requireMsg=true, protoArr=[], errorFlag='') {
                if(!requireMsg) {
                    let flag = true
                    for(let proto of protoArr) {
                        if(this.verrors.has(proto)) {
                            flag = false
                            this[errorFlag] = true
                            break
                        }
                    }
                    if(flag) {
                        this[errorFlag] = false
                    }
                }else {
                    this[errorFlag] = false
                }
            }

        }

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