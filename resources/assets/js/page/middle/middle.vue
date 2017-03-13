/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div>
        <basic-model
            ref="basicModel"
            :models="models[type]"
        ></basic-model>
    </div>
</template>


<script>

    import message from './message.js'
    import reaction from './reaction.js'

    export default{
        name:'Message',
        data () {
            
            let modelObj = {}
            Object.assign(modelObj, message, reaction)

        	return {
                models: modelObj
        	}
        },
        computed: {
            type () {
                return this.$route.params.model
            }
        },
        beforeRouteUpdate (to, from, next) {
            this.$refs.basicModel.init(to.params.index)
            next()
        },
        methods: {

        }
    }

</script>
