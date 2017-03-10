<template>
    <div class="content">
        <div class="event-handle">
            <div>
                <el-button @click="planDialogVisible=true">预案</el-button>
                <el-button @click="informationDialogVisible=true">专题知识</el-button>
                <el-button @click="expertDialogVisible=true">参与专家</el-button>
                <el-button type="success" icon="plus" @click="progressDialogVisible=true">更新进度</el-button>
                <el-button type="danger" icon="warning" @click="closeEvent">结束事件</el-button>
            </div>
        </div>
        <div class="event-progress">
            <ul>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
                <li>
                    <div>苏锐佳<span>2017/03/09 21:13</span></div>
                    <div>这是第一个步骤，请好好执行</div>
                </li>
            </ul>
            <div class="btn">
                <el-button size="small">more</el-button>
            </div>
        </div>

        <plan 
            :dialogVisible="planDialogVisible" 
            :msg="plan" 
            @cancel="planDialogVisible=false">
        </plan>

        <information 
            :dialogVisible="informationDialogVisible" 
            :msg="information" 
            @cancel="informationDialogVisible=false">
        </information>

        <expert 
            :dialogVisible="expertDialogVisible" 
            :experts="experts" 
            @cancel="expertDialogVisible=false">
        </expert>

        <pop-progress
            :dialogVisible="progressDialogVisible"
            @cancel="progressDialogVisible=false">
        </pop-progress>
    </div>
</template>

<script>

    import { mapState } from 'vuex'
    import Plan from './plan.vue'
    import Information from './information.vue'
    import Expert from './expert.vue'
    import PopProgress from './pop-progress.vue'

    export default {
        name: 'EventProgress',
        data () {
            return {
                plan: {name: '食品安全'},
                information: {name: '食品安全'},
                experts: [],
                // 是否显示预案详情弹窗
                planDialogVisible: false,
                // 是否显示专题详情弹窗
                informationDialogVisible: false,
                // 是否显示专家弹窗
                expertDialogVisible: false,
                // 是否显示新增进度弹窗
                progressDialogVisible: false
            }
        },
        computed: {
            ...mapState([
                'formMsg'
            ])
        },
        components: {
            Plan,
            Information,
            Expert,
            PopProgress
        },
        mounted () {
            this.getEventHandleMsg()
        },
        methods: {

            getEventHandleMsg () {
                axios.get(this.$adminUrl('eventhandle/query'))
                    .then((responce) => {
                        this.plan = responce.data.plan
                        this.information = responce.data.information
                        this.$set(this, 'experts', responce.data.experts)
                    })
            },

            closeEvent () {
                this.$confirm('确定结束此事件？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: '事件处理完成!'
                    })
                })
            }

        }
    }
</script>

<style lang="sass" scoped>

    .content {
        margin-top: 49px;

        .event-handle {

            padding: 20px 0;
            padding-left: 10px;
            border-bottom: 1px solid #d9d9d9;

            div {
                margin-right: 10px;
                display: inline-block;
            }
        }

        .event-progress {

            ul {

                width: 80%;
                margin: auto;
                margin-bottom: 35px;

                li {
                    width: 100%;
                    padding: 10px;
                    padding-left: 18px;
                    margin-top: 35px;
                    border: 1px solid rgb(211, 209, 209);
                    border-left: 7px solid rgb(211, 209, 209);

                    div:nth-child(1) {
                        margin-bottom: 10px;
                    }

                    span {
                        margin-left: 30px;
                        font-size: 12px;
                        color: #9E9E9E;
                    }
                }
                li:nth-child(1) {
                    border: 1px solid rgba(0, 154, 97, 0.48);
                    border-left: 7px solid rgba(0, 154, 97, 0.48);
                }
            }
        }

        .btn {
            margin-bottom: 35px;
            text-align: center;
        }
    }
</style>
