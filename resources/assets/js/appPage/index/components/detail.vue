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
    import { mapMutations } from 'vuex'

    export default{
        name:'Detail',
        data () {
            return {
                message: '',
                progress: []
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
            this.getEventProgress()
        },
        methods: {

            ...mapMutations([
                'setShowBack',
                'setMenu'
            ]),

            getEventProgress () {
                axios.get(this.$adminUrl('eventprogress/query?event_id=') + this.$route.params.id)
                    .then((responce) => {
                        this.$set(this, 'progress', responce.data.data)
                    })
            },

            publishProgress () {
                
                let params = {
                    content: this.message,
                    event_id: this.$route.params.id,
                    user_id: Laravel.user.id
                }
                axios.post(this.$adminUrl('eventprogress'), params)
                    .then((responce) => {
                        if(responce.data) {
                            this.$toast('新增成功')
                            this.message = ''
                            this.progress.unshift({
                                id: responce.data.id,
                                user_name: Laravel.user.name,
                                content: responce.data.content
                            })
                        }
                    })
            }

        }
    }

</script>
