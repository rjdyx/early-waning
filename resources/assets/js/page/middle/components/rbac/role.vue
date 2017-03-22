<template>
    <el-select v-model="role" size="small" placeholder="请选择" @change="change">
        <el-option
            label="管理员"
            :value="0">
        </el-option>
        <el-option
            label="专家"
            :value="1">
        </el-option>
        <el-option
            label="应急人员"
            :value="2">
        </el-option>
    </el-select>
</template>

<script>

    export default {
        name:'Role',
        props:{
            scope: {
                type: Object,
                required: true,
                default () {
                    return {}
                }
            }
        },
        data () {
            return {
                role: this.scope.row.role
            }
        },
        methods: {

            change (val) {
                let param = {
                    id: this.scope.row.id,
                    role: val
                }
                axios.post(this.$adminUrl('user/changeRole'), param)
                    .then((responce) => {
                        this.$message({
                          message: '角色修改成功',
                          type: 'success'
                        })
                    })
            }

        }

    }
</script>
