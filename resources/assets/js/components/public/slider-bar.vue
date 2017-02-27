/**
 * 侧边栏组件
 * @description 手机端的侧边栏，具备左右滑动的动画效果，侧边栏上的顶层菜单点击后展开子菜单，目前只支持二级菜单，子菜单可以是一开始就定义好的，也可以点击父菜单后才从后端加载
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 * Props:
 * 
 * @param  show 
 * 类型：Boolean
 * 是否必填：true
 * 默认值：true
 * 描述：显示或隐藏侧边栏的标志
 * 
 * 
 * @param  navbars 
 * 类型：Array
 * 是否必填：false
 * 默认值：[]
 * 描述：侧边栏数组，每一项的格式如下example
 * 例子：
 *   {
 *        name:'种植管理',  // 顶层菜单项名称
 *        isEvent: false,   // 为true时，表示是通过点击顶层菜单，从后台获取子菜单数据再渲染到页面；false表示子菜单项是一开始就定义好的
 *        children: [       // 子菜单项数组
 *            {
 *                path: '/basic',   // 子菜单项在vue-router中的访问路径
 *                name:'基础信息管理' // 子菜单项名称
 *            },
 *        ]
 *    }
 * 
 * 
 * Events:
 * 
 * @function hide
 * 返回：无
 * 必用：true
 * 描述：隐藏侧边栏
 * 
 * @function getSubNavbars
 * 返回：name 被点击的顶层菜单项的名称
 * 必用：false
 * 描述：如果顶层菜单项的isEvent为true，则点击顶层菜单项会触发此事件
 * 
 * 
 */
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
            // 显示或隐藏侧边栏的标志
            show: {
                type: Boolean,
                required: true,
                default: true
            },
            // 侧边栏数组
            navbars: {
                type: Array,
                default: []
            }
        },
        data (){
            return {
                // 用于记住展开哪个子菜单的下标
                subNavbarIndex: -1
            }
        },
        computed: {},
        methods:{
            /**
             * 隐藏侧边栏
             */
            hide () {
                this.$emit('hide');
            },

            /**
             * 展开或隐藏子下来菜单
             * @param  {Boolean} isEvent 
             * @param  {Number}  index   
             */
            triggle (name, isEvent, index) {
                if(this.subNavbarIndex == index) {
                    this.subNavbarIndex = -1;
                }else {
                    if(isEvent) {
                        this.$emit('getSubNavbars', name);
                    }
                    this.subNavbarIndex = index;
                }
            },

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
    }

    .subNavbar {
        display: inline-block;
        width: 100%;
    }
</style>