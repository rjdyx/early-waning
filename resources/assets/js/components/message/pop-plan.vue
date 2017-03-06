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
                planLevels: []
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getplanLevel()
        },
        methods: {

            getplanLevel () {
                axios.get(this.$adminUrl('normal-type?type=3'))
                    .then((responce) => {
                        this.$set(this, 'planLevels', responce.data)
                        if(!(this.form.plan_type_id))this.form.plan_type_id = this.planLevels[0].id
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
