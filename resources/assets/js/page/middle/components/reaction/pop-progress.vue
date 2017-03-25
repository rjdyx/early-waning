<template>
    <el-dialog title="发布进度" v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <div>
            <el-input 
                v-model="content" 
                type="textarea" 
                :rows="4" 
                placeholder="请输入内容">
            </el-input>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
            <el-button @click="publishProgress" type="primary">确 定</el-button>
        </span>
    </el-dialog>
</template>

<script>

    export default {
        name: 'PopProgress',
        props: {
            dialogVisible: false,
            event: null
        },
        data () {
            return {
                content: ''
            }
        },
        methods: {

            publishProgress () {

                if(this.content == '') {
                    this.$message({
                        type: 'error',
                        message: '请输入内容!'
                    })
                    return false
                }
                
                let params = {
                    content: this.content,
                    event_id: this.event.id,
                    user_id: Laravel.user.id
                }
                axios.post(this.$adminUrl('eventprogress'), params)
                    .then((responce) => {
                        if(responce.data) {
                            this.$message({
                                type: 'success',
                                message: '发布成功!'
                            })
                            this.content = ''
                            this.$emit('callback', responce.data)
                        }else {
                            this.$message({
                                type: 'info',
                                message: '事件已结束!'
                            })
                        }
                    })
                this.cancel()
            },

            cancel () {
                this.content = ''
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
