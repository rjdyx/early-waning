/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 */
<template>

    <div class="detail">
        <panel header="事件详情" :list="list" type="2"></panel>

        <!-- 按钮组 -->
        <sticky>
            <div class="btns">
                <grid>
                  <grid-item label="预案" @on-item-click="planDialogVisible=true"></grid-item>
                  <grid-item label="专题知识" @on-item-click="informationDialogVisible=true"></grid-item>
                  <grid-item label="参与专家" @on-item-click="expertDialogVisible=true"></grid-item>
                </grid>
            </div>
        </sticky>

        <!-- 事件进度 -->
        <divider>事件进度</divider>
        <div class="progress">
            <timeline>
                <timeline-item v-for="(item, index) in progress" :key="index">
                    <h3>{{item.user_name}}</h3>
                    <p>{{item.content}}</p>
                </timeline-item>
            </timeline>
        </div>

        <!-- 发送模块 -->
        <div v-if="status" class="msg">
            <group>
                <x-input v-model="message">
                    <x-button slot="right" type="primary" @click.native="publishProgress" mini>发送</x-button>
                </x-input>
            </group>
        </div>

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

    </div>

</template>
<style lang="sass" scoped>

    .detail {
        background: #fbf9fe;

        .btns {
            margin: 10px 0;
            background: white;
        }

        p {
            margin-top: 5px;
        }

        .msg {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            z-index: 19920219;
        }

        .progress {
            background: white;
        }
    }

    
</style>
<script>

    import { Grid, GridItem, Divider, Timeline, TimelineItem, XInput, Group, XButton, Panel, Sticky } from 'vux'
    import { mapGetters, mapMutations } from 'vuex'
    import Plan from './plan.vue'
    import Information from './information.vue'
    import Expert from './expert.vue'

    export default{
        name:'Detail',
        data () {
            console.log(this.formMsg);
            return {
                list: [],
                message: '',
                eventId: this.$route.params.id,
                plan: {id: 0, name: '', content: ''},
                information: {name: '食品安全', content: ''},
                experts: [],
                // 是否显示事件详情弹窗
                eventDialogVisible: false,
                // 是否显示预案详情弹窗
                planDialogVisible: false,
                // 是否显示专题详情弹窗
                informationDialogVisible: false,
                // 是否显示专家弹窗
                expertDialogVisible: false
            }
        },
        computed: {
            ...mapGetters([
                'formMsg',
                'progress',
                'ws'
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
            Grid,
            GridItem,
            Divider,
            Timeline, 
            TimelineItem,
            XInput,
            Group,
            XButton,
            Plan,
            Information,
            Expert,
            Panel,
            Sticky
        },
        mounted () {
            this.setShowBack(true)
            this.setMenu([
                {
                    label: '刷新',
                    value: 'flesh'
                }
            ])
            this.getEventHandleMsg()
            this.getEventProgress()
            this.list.push({ title: this.formMsg.name, desc: this.formMsg.detail })
        },
        methods: {

            ...mapMutations([
                'setShowBack',
                'setMenu',
                'setProgress',
                'pushProgress',
                'setFormMsg'
            ]),

            getEventHandleMsg () {
                axios.get(this.$adminUrl('eventhandle/query?event_id=') + this.eventId)
                    .then((responce) => {
                        this.plan = responce.data.plan
                        this.information = responce.data.information
                        this.$set(this, 'experts', responce.data.experts)
                    })
            },

            getEventProgress () {
                axios.get(this.$adminUrl('eventprogress/query?event_id=') + this.eventId)
                    .then((responce) => {
                        this.setProgress(responce.data.data)
                    })
            },

            publishProgress () {
                
                let params = {
                    content: this.message,
                    event_id: this.eventId,
                    user_id: Laravel.user.id
                }

                let _this = this
                axios.all([
                    axios.get(this.$adminUrl('emergencycrew/query-crew/') + this.plan.id),
                    axios.post(this.$adminUrl('eventprogress'), params)
                ])
                .then(axios.spread(function (emergencycrews, responce) {
                    if(responce.data) {

                        let msg = {
                            id: responce.data.id,
                            user_name: Laravel.user.name,
                            content: responce.data.content,
                            event_progresses_created_at: responce.data.created_at
                        }

                        _this.$toast('新增成功')
                        _this.message = ''

                        let broadcast = _this.$broadcast(_this.expert, emergencycrews.data)

                        _this.ws.send(JSON.stringify({
                            msg: msg,
                            broadcast: broadcast,
                            type: 'progress'
                        }))
                    }
                }))
            }

        },
        destroyed () {
            this.setProgress([])
            this.setFormMsg(null)
        }
    }

</script>
