<template>
    <el-dialog v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <div class="information">
            <h1>{{msg.name}}</h1>
            <div>{{msg.content}}</div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
        </span>
    </el-dialog>
</template>

<script>

    export default {
        name: 'Information',
        props: {
            dialogVisible: false,
            msg: {
                type: Object,
                default () {
                    return {id: 0, name: '', content: ''}
                }
            }
        },
        methods: {

            cancel () {
                this.$emit('cancel')
            }

        }
    }
</script>

<style lang="sass" scoped>

    .information {

        h1 {
            text-align: center;
            font-size: 20px;
        }

        ul {
            margin: 9px 0;
        }
        
    }

</style>
