/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 */
<template>

    <div>
        <div class="btns">
            <grid>
              <grid-item label="预案"></grid-item>
              <grid-item label="专题知识"></grid-item>
              <grid-item label="参与专家"></grid-item>
            </grid>
        </div>
        <divider>事件进度</divider>
        <div>
            <timeline>
                <timeline-item v-for="(item, index) in progress" :key="index">
                    <h3>{{item.user_name}}</h3>
                    <p>{{item.content}}</p>
                </timeline-item>
            </timeline>
        </div>
        <div class="msg">
            <group>
                <x-input v-model="message">
                    <x-button slot="right" type="primary" @click.native="publishProgress" mini>发送</x-button>
                </x-input>
            </group>
        </div>
    </div>

</template>
<style lang="sass" scoped>
    .btns {
        margin-bottom: 20px;
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
</style>
<script>

    import { Grid, GridItem, Divider, Timeline, TimelineItem, XInput, Group, XButton } from 'vux'
    import { mapGetters, mapMutations } from 'vuex'

    export default{
        name:'Detail',
        data () {
            return {
                message: '',
                eventId: this.$route.params.id,
                plan: null,
                experts: []
            }
        },
        computed: {
            ...mapGetters([
                'progress',
                'ws'
            ])
        },
        components: {
            Grid,
            GridItem,
            Divider,
            Timeline, 
            TimelineItem,
            XInput,
            Group,
            XButton
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
        },
        methods: {

            ...mapMutations([
                'setShowBack',
                'setMenu',
                'setProgress',
                'pushProgress'
            ]),

            getEventHandleMsg () {
                axios.get(this.$adminUrl('eventhandle/query?event_id=') + this.eventId)
                    .then((responce) => {
                        this.plan = responce.data.plan
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

        }
    }

</script>
