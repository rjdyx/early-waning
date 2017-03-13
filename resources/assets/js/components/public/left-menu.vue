<template>
    <el-menu
        :router="true" 
        class="left-menu">
      <el-submenu 
        v-for="(menu, index) in menus"
        :index="menu.name">
            <template slot="title">{{menu.name}}</template>
            <el-menu-item 
                v-for="(subMenu, subIndex) in menu.children" 
                :index="subMenu.path" @click="clickEvent(menu, subMenu)" exact>
                {{subMenu.name}}
            </el-menu-item>
      </el-submenu>
    </el-menu>
</template>

<script>

    import {mapMutations} from 'vuex'

    export default {
        name:'SliderBar',
        props:{
            // 左菜单栏数组
            menus: {
                type: Array,
                default () {
                    return []
                }
            }
        },
        methods: {

            ...mapMutations([
                'setNavbarName',
                'setSubNavBarName'
            ]),

            clickEvent (menu, subMenu) {
                this.setNavbarName(menu.name)
                this.setSubNavBarName(subMenu.name)
            }
        }
    }
</script>

<style lang="sass" scoped>
    @import "../../../sass/function";
    
    .left-menu {
        width: pxToRem(180);
        height: 100%;
        padding-top: pxToRem(48);
        z-index: 101;
    }

    .subMenu {
        display: inline-block;
        width: 100%;
    }
</style>