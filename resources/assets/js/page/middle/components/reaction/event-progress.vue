<template>
    <div class="content">
        <div class="event-handle">
            <div>
                <el-button @click="eventDialogVisible=true">事件详情</el-button>
                <el-button @click="planDialogVisible=true">预案</el-button>
                <el-button @click="informationDialogVisible=true">专题知识</el-button>
                <el-button @click="expertDialogVisible=true">参与专家</el-button>
                <el-button v-if="status" type="success" icon="plus" @click="progressDialogVisible=true">更新进度</el-button>
                <el-button v-if="status" type="danger" icon="warning" @click="closeEvent">结束事件</el-button>

            </div>
        </div>
        <div class="event-progress">
            <ul>
                <li v-for="(item, index) of progress">
                    <div>{{item.user_name}}<span>{{item.event_progresses_created_at}}</span></div>
                    <div>{{item.content}}</div>
                    <i v-if="status" class="el-icon-close" @click="deleteProgress(item.id, index)"></i>
                </li>
            </ul>
            <div class="btn" v-if="progress.length">
                <el-button size="small" @click="moreProgress">more</el-button>
            </div>
        </div>

        <event-detail
            :dialogVisible="eventDialogVisible" 
            :event="formMsg" 
            @cancel="eventDialogVisible=false">
        </event-detail>

        <plan 
            :dialogVisible="planDialogVisible" 
            :msg="plan" 
            @cancel="planDialogVisible=false"
        ></plan>

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
            :event="formMsg" 
            :dialogVisible="progressDialogVisible"
            @callback="addProgress"
            @cancel="progressDialogVisible=false">
        </pop-progress>
    </div>
</template>

<script>

    import { mapGetters, mapMutations } from 'vuex'
    import EventDetail from './event-detail.vue'
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
                // 是否显示事件详情弹窗
                eventDialogVisible: false,
                // 是否显示预案详情弹窗
                planDialogVisible: false,
                // 是否显示专题详情弹窗
                informationDialogVisible: false,
                // 是否显示专家弹窗
                expertDialogVisible: false,
                // 是否显示新增进度弹窗
                progressDialogVisible: false,
                page: 1
            }
        },
        computed: {
            ...mapGetters([
                'formMsg',
                'ws',
                'progress'
            ]),
            status () {
                if(this.formMsg.status == 2 || this.formMsg.status == 5) {
                    return true
                }else {
                    return false
                }
            }
        },
        components: {
            EventDetail,
            Plan,
            Information,
            Expert,
            PopProgress
        },
        mounted () {
            this.$nextTick(() => {
                this.getEventHandleMsg()
                this.getEventProgress()
            })
        },
        methods: {

            ...mapMutations([
                'setProgress',
                'pushProgress',
                'spliceProgress'
            ]),

            getEventHandleMsg () {
                axios.get(this.$adminUrl('eventhandle/query?event_id=') + this.formMsg.id)
                    .then((responce) => {
                        this.plan = responce.data.plan
                        this.information = responce.data.information
                        this.$set(this, 'experts', responce.data.experts)
                    })
            },

            getEventProgress () {
                axios.get(this.$adminUrl('eventprogress/query?event_id=') + this.formMsg.id)
                    .then((responce) => {
                        this.setProgress(responce.data.data)
                    })
            },

            closeEvent () {
                this.$confirm('确定结束此事件？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {

                    axios.all([
                        axios.post(this.$adminUrl('eventhandle/changeEventStatus/') + this.formMsg.id),
                        axios.get(this.$adminUrl('emergencycrew/query-crew/') + this.plan.id)
                    ])
                        .then(axios.spread((responce, crews) => {
                            if(responce.data) {
                                this.formMsg.status++
                                this.$message({
                                    type: 'success',
                                    message: '事件处理完成!'
                                })
                                
                                let broadcast = this.$broadcast(this.experts, crews.data)
                                
                                this.ws.send(JSON.stringify({
                                    msg: this.formMsg,
                                    broadcast: broadcast,
                                    type: 'closeEvent'
                                }))
                            }
                        }))
                    
                })
                .catch((error) => {})
            },

            addProgress (progress) {
                let msg = {
                    id: progress.id,
                    user_name: Laravel.user.name,
                    content: progress.content,
                    event_progresses_created_at: progress.created_at
                }

                axios.get(this.$adminUrl('emergencycrew/query-crew/') + this.plan.id)
                    .then((responce) => {
                        
                        let broadcast = this.$broadcast(this.experts, responce.data)
                        
                        this.ws.send(JSON.stringify({
                            msg: msg,
                            broadcast: broadcast,
                            type: 'progress'
                        }))
                    }) 
            },

            deleteProgress (id, index) {
                axios.delete(this.$adminUrl('eventprogress/') + id)
                    .then((responce) => {
                        if(responce.data) {
                            this.$message({
                                type: 'success',
                                message: '删除成功!'
                            })
                            this.spliceProgress(index)
                        }else {
                            this.$message({
                                type: 'info',
                                message: '事件已结束!'
                            })
                        }
                    })
            },

            moreProgress() {
                axios.get(this.$adminUrl('eventprogress/query?event_id=') + this.formMsg.id + '&page=' + (++this.page))
                    .then((responce) => {
                        if(responce.data.data.length) {
                            console.log(responce.data.data);
                            let arr = this.progress.concat(responce.data.data)
                            this.setProgress(arr)
                        }else {
                            this.page--
                            this.$message({
                                type: 'info',
                                message: '没有更多数据了'
                            })
                        }
                        
                    })
            }

        },
        destroyed () {
            this.setProgress([])
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
                    position: relative;
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

                    i {
                        display: none;
                        position: absolute;
                        top: 10px;
                        right: 10px;
                    }
                }
                li:nth-child(1) {
                    border: 1px solid rgba(0, 154, 97, 0.48);
                    border-left: 7px solid rgba(0, 154, 97, 0.48);
                }
                li:hover {
                    cursor: pointer;

                    i {
                        display: inline-block;
                    }
                }
            }
        }

        .btn {
            margin-bottom: 35px;
            text-align: center;
        }
    }
</style>
