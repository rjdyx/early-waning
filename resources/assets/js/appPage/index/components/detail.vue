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
                <timeline-item v-for="(i, index) in 13" :key="index">
                    <h3>苏锐佳</h3>
                    <p>这是第一个步骤，请好好执行</p>
                </timeline-item>
            </timeline>
        </div>
        <div class="msg">
            <group>
                <x-input v-model="message">
                <x-button slot="right" type="primary" mini>发送</x-button>
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
                message: ''
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
        },
        methods: {

            ...mapMutations([
                'setShowBack',
                'setMenu'
            ])

        }
    }

</script>
