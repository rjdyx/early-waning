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
        <x-header :left-options="{showBack: showBack}" :right-options="{showMore: true}" @on-click-more="showMenus = true">{{user}}</x-header>
        <actionsheet :menus="menu" v-model="showMenus" show-cancel @on-click-menu="clickMenu"></actionsheet>
    </div>
</template>
<style lang="sass" scoped>

</style>
<script>

    import { XHeader, Actionsheet } from 'vux'
    import { mapState } from 'vuex'

    export default{
        name:'Header',
        data () {
            return {
                user: Laravel.user.name,
                showMenus: false
            }
        },
        computed: mapState([
            'showBack',
            'menu'
        ]),
        components: {
            XHeader,
            Actionsheet
        },
        methods: {

            clickMenu (menu) {
                switch(menu) {
                    case 'logout':
                        this.logout()
                        break
                    case 'flesh':
                        location.reload()
                        break
                }
            },

            logout () {
                let _this = this
                this.$vux.confirm.show({
                    title: '确认退出?',
                    onConfirm () {
                        _this.logoutPost()
                    }
                })
            },

            logoutPost () {
                axios.post('logout')
                    .then((responce) => {
                        if(responce.data) {
                            Laravel.user = {id: null, name: null, email: null}
                            this.$router.push('/login')
                        }
                    })
            }
        }
    }

</script>
