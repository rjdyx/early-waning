<template>
    <el-dialog title="发布进度" v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <div>
        <el-input type="textarea":rows="4" placeholder="请输入内容"></el-input>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
            <el-button @click="cancel" type="primary">确 定</el-button>
        </span>
    </el-dialog>
</template>

<script>

    export default {
        name: 'PopProgress',
        props: {
            dialogVisible: false,
        },
        methods: {

            cancel () {
                this.$emit('cancel')
            }

        }
    }
</script>

<style lang="sass" scoped>

    .content {
        max-height: 150px;
        padding: 5px;

        ul {

            li {
                width: 100%;
                height: 35px;
                line-height: 35px;
                padding-left: 25px;
                margin-bottom: 3px;
            }

            li:hover {
                box-shadow: 0 0 6px 0px #bfcbd9;
            }
        }
    }

</style>
