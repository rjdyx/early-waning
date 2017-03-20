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
        <x-header :right-options="{showMore: true}" @on-click-more="showMenus = true">{{user}}</x-header>
        <actionsheet :menus="menus" v-model="showMenus" show-cancel></actionsheet>
    </div>
</template>
<style lang="sass" scoped>

</style>
<script>

    import { XHeader, Actionsheet } from 'vux'

    export default{
        name:'Index',
        data () {
            return {
                user: Laravel.user.name,
                menus: {
                    menu1: 'Take Photo',
                    menu2: 'Choose from photos'
                },
                showMenus: false
            }
        },
        components: {
            XHeader,
            Actionsheet
        }
    }

</script>
