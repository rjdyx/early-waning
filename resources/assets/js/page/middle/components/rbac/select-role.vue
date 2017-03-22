<template>
    <el-radio-group v-model="role">
        <el-radio-button :label="0">管理员</el-radio-button>
        <el-radio-button :label="1">专家</el-radio-button>
        <el-radio-button :label="2">应急人员</el-radio-button>
    </el-radio-group>
</template>

<script>

    export default {
        name:'SelectRole',
        props: {
            value: 0
        },
        data () {
            return {
                role: this.value
            }
        },
        watch: {
            role (){
                this.$emit('return-value', {name: 'role', value: this.role})
            }
        }

    }
</script>
