<template>
    <el-input type="textarea" v-model="content" id="content"></el-input>
</template>

<script>

    export default {
        name:'Textarea',
        props: {
            value: 0
        },
        data () {
            return {
                content: this.value
            }
        },
        watch: {
            content (){
                this.$emit('return-value', {name: 'content', value: this.content})
            }
        }

    }
</script>
