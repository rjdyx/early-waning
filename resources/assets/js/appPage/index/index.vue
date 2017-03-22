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
        <my-header></my-header>
        <router-view></router-view>
    </div>
</template>
<style lang="sass" scoped>
    .swiper {
        margin-bottom: 1px;
    }

    .event-list {

        font-size: 14px;

        li {
            overflow: hidden;
            background: linear-gradient(180deg,#e5e5e5,#e5e5e5,hsla(0,0%,90%,0)) 0 100% no-repeat;
            background-size: 100% 1px;

            .left {
                float: left;
                padding: 10px;

                h3 {
                    width: 200px;
                    margin-bottom: 6px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                    word-break: keep-all;
                }

                p {
                    width: 230px;
                    font-size: 13px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                    word-break: keep-all;
                }
            }

            .right {
                float: right;
                padding: 10px;
            }
        }
    }
</style>
<script>

    import header from './components/header.vue'
    import list from './components/list.vue'

    export default{
        name:'Index',
        data () {
            return {

            }
        },
        components: {
            'my-header': header,
            list
        },
        methods: {

        }
    }

</script>
