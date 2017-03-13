<template>
    <el-radio-group v-model="sex">
        <el-radio-button :label="1">男</el-radio-button>
        <el-radio-button :label="0">女</el-radio-button>
    </el-radio-group>
</template>

<script>

    export default {
        name:'SelectSex',
        data () {
            return {
                sex: 1
            }
        },
        watch: {
            sex (){
                this.$emit('return-value', {name: 'sex', value: this.sex})
            }
        }

    }
</script>
