<template>
    <el-menu
        :router="true" 
        class="slider-bar">
      <el-submenu 
        v-for="(navbar, index) in navbars"
        :index="navbar.name">
            <template slot="title">{{navbar.name}}</template>
            <el-menu-item 
                v-for="(subNavbar, subIndex) in navbar.children" 
                :index="subNavbar.path" exact>
                {{subNavbar.name}}
            </el-menu-item>
      </el-submenu>
    </el-menu>
</template>

<script>

    export default {
        name:'SliderBar',
        props:{
            // 侧边栏数组
            navbars: {
                type: Array,
                default: []
            }
        },
        data (){
            return {}
        },
        computed: {},
        methods:{

            /**
             * 判断用户是否有此操作栏的权限
             * @param  {Object}  navbar 
             * @return {Boolean}
             */
            hasRole (navbar) {
                if ((typeof window == undefined || typeof window == 'object') && window.role && window.role.role1) {
                    return window.role.role1.some(function(item, index) {
                        return navbar.role == item;
                    }) 
                }else {
                    return true;
                }
                
            }
        }

    }
</script>

<style lang="sass" scoped>
    @import "../../../sass/function";
    
    .slider-bar {
        width: pxToRem(180);
        height: 100%;
        padding-top: pxToRem(48);
        z-index: 101;
    }

    .subNavbar {
        display: inline-block;
        width: 100%;
    }
</style>